<?php

function wiki_paths_from_request($request)
{
	$defaults = ['api' => '/w/api.php', 'script' => '/w/index.php', 'articlepath' => '/wiki/$1', 'scheme' => 'https'];
	$value = $request['wiki_paths'] ?? '';
	$paths = is_string($value) ? json_decode($value, true) : null;
	if (!is_array($paths)) {
		return $defaults;
	}
	foreach (['api', 'script', 'articlepath'] as $key) {
		$path = $paths[$key] ?? '';
		if (!is_string($path) || !preg_match('~^/(?!/)[^\x00-\x20\\\\#]*$~', $path)) {
			return $defaults;
		}
		if ($key != 'articlepath' && str_contains($path, '?')) {
			return $defaults;
		}
	}
	if (!str_contains($paths['articlepath'], '$1') || !in_array($paths['scheme'] ?? '', ['http', 'https'], true)) {
		return $defaults;
	}
	return array_intersect_key($paths, $defaults);
}

function wiki_endpoint($server, $type)
{
	global $wiki_paths;
	$paths = $wiki_paths ?? wiki_paths_from_request([]);
	return $paths['scheme'] . '://' . $server . $paths[$type];
}

function wiki_page_url($server, $title)
{
	$title = str_replace('%2F', '/', rawurlencode(str_replace(' ', '_', $title)));
	return str_replace('$1', $title, wiki_endpoint($server, 'articlepath'));
}

// Resolve both relative and absolute discovery links without assuming a script directory.
function resolve_wiki_url($base, $reference)
{
	$reference = trim($reference);
	if (preg_match('~^[a-z][a-z0-9+.-]*:~i', $reference)) {
		return $reference;
	}
	$parts = parse_url($base);
	if (str_starts_with($reference, '//')) {
		return $parts['scheme'] . ':' . $reference;
	}
	$origin = $parts['scheme'] . '://' . $parts['host'] . (isset($parts['port']) ? ':' . $parts['port'] : '');
	if ($reference === '' || $reference[0] === '?' || $reference[0] === '#') {
		return $origin . ($parts['path'] ?? '/') . $reference;
	}
	$target = parse_url($reference);
	$path = $target['path'] ?? '';
	if (!str_starts_with($path, '/')) {
		$basepath = $parts['path'] ?? '/';
		$path = substr($basepath, 0, strrpos($basepath, '/') + 1) . $path;
	}
	$segments = [];
	foreach (explode('/', $path) as $segment) {
		if ($segment === '..') {
			array_pop($segments);
		} elseif ($segment !== '' && $segment !== '.') {
			$segments[] = $segment;
		}
	}
	return $origin . '/' . implode('/', $segments) . (isset($target['query']) ? '?' . $target['query'] : '');
}

function wiki_url_origin($url)
{
	$parts = parse_url($url);
	if (!$parts || !in_array($parts['scheme'] ?? '', ['http', 'https'], true) || empty($parts['host']) || isset($parts['user']) || isset($parts['pass'])) {
		throw new RuntimeException('Invalid wiki URL');
	}
	return $parts['scheme'] . '://' . $parts['host'] . (isset($parts['port']) ? ':' . $parts['port'] : '');
}

// Pin each public destination, including redirects, to prevent discovery reaching private services.
function fetch_wiki_discovery_url($url, &$effective_url = null, $head_only = false)
{
	for ($redirect = 0; $redirect <= 5; $redirect++) {
		wiki_url_origin($url);
		$parts = parse_url($url);
		$host = trim($parts['host'], '[]');
		$port = $parts['port'] ?? ($parts['scheme'] === 'https' ? 443 : 80);
		$addresses = filter_var($host, FILTER_VALIDATE_IP) ? [$host] : gethostbynamel($host);
		if (!$addresses) {
			throw new RuntimeException('Could not resolve wiki host');
		}
		foreach ($addresses as $address) {
			if (!filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
				throw new RuntimeException('Wiki host must be publicly accessible');
			}
		}
		$address = $addresses[0];
		if (str_contains($address, ':')) {
			$address = '[' . $address . ']';
		}
		$body = '';
		$head_complete = false;
		$location = null;
		$ch = curl_init($url);
		curl_setopt_array($ch, [
			CURLOPT_PROXY => '',
			CURLOPT_RESOLVE => ["$host:$port:$address"],
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_TIMEOUT => 15,
			CURLOPT_USERAGENT => 'Wikiblame/1.0 (flominator@gmx.net)',
			CURLOPT_WRITEFUNCTION => function ($ch, $chunk) use (&$body, &$head_complete, $head_only) {
				if (strlen($body) + strlen($chunk) > 2 * 1024 * 1024) {
					return 0;
				}
				$body .= $chunk;
				if ($head_only && ($end = stripos($body, '</head>')) !== false) {
					$body = substr($body, 0, $end + strlen('</head>'));
					$head_complete = true;
					return 0; // Stop the GET once the discovery metadata has arrived.
				}
				return strlen($chunk);
			},
			CURLOPT_HEADERFUNCTION => function ($ch, $header) use (&$location) {
				if (stripos($header, 'Location:') === 0) {
					$location = trim(substr($header, 9));
				}
				return strlen($header);
			},
		]);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($result === false && !$head_complete) {
			throw new RuntimeException('Could not fetch wiki settings');
		}
		if ($status >= 300 && $status < 400 && $location !== null) {
			$url = resolve_wiki_url($url, $location);
			continue;
		}
		if ($status < 200 || $status >= 300) {
			throw new RuntimeException('Wiki returned HTTP ' . $status);
		}
		$effective_url = $url;
		return $body;
	}
	throw new RuntimeException('Too many wiki redirects');
}

function wiki_api_from_html($html, $page_url)
{
	if ($html === '') {
		throw new RuntimeException('Empty wiki page');
	}
	$document = new DOMDocument();
	$previous = libxml_use_internal_errors(true);
	$loaded = $document->loadHTML($html, LIBXML_NONET);
	libxml_clear_errors();
	libxml_use_internal_errors($previous);
	if (!$loaded) {
		throw new RuntimeException('Could not read wiki page');
	}
	$base = $document->getElementsByTagName('base')->item(0);
	if ($base && $base->hasAttribute('href')) {
		$page_url = resolve_wiki_url($page_url, $base->getAttribute('href'));
	}
	foreach ($document->getElementsByTagName('link') as $link) {
		if (in_array('edituri', preg_split('/\s+/', strtolower(trim($link->getAttribute('rel')))), true)) {
			$url = resolve_wiki_url($page_url, $link->getAttribute('href'));
			return wiki_url_origin($url) . (parse_url($url, PHP_URL_PATH) ?: '/');
		}
	}
	throw new RuntimeException('Wiki page does not advertise an API');
}

function wiki_title_from_url($url, $articlepath, $script = '/w/index.php')
{
	$parts = parse_url($url);
	parse_str($parts['query'] ?? '', $query);
	if (isset($query['title']) && is_string($query['title']) && $query['title'] !== '') {
		return str_replace('_', ' ', $query['title']);
	}
	if (str_starts_with($parts['path'] ?? '', $script . '/')) {
		return str_replace('_', ' ', rawurldecode(substr($parts['path'], strlen($script) + 1)));
	}
	[$prefix, $suffix] = explode('$1', $articlepath, 2);
	$path = $parts['path'] ?? '';
	if (!str_starts_with($path, $prefix) || ($suffix !== '' && !str_ends_with($path, $suffix))) {
		throw new RuntimeException('Page URL does not match this wiki');
	}
	$title = substr($path, strlen($prefix), strlen($path) - strlen($prefix) - strlen($suffix));
	if ($title === '') {
		throw new RuntimeException('No page title in URL');
	}
	return str_replace('_', ' ', rawurldecode($title));
}

function known_wiki_site($page_url)
{
	wiki_url_origin($page_url);
	$parts = parse_url($page_url);
	$host = strtolower($parts['host']);
	$projects = ['wikipedia', 'wikimedia', 'wiktionary', 'wikibooks', 'wikiquote', 'wikinews', 'wikisource', 'wikiversity', 'wikivoyage', 'wikidata', 'wikifunctions', 'mediawiki'];
	foreach ($projects as $project) {
		$domain = $project . '.org';
		if ($host === $domain || str_ends_with($host, '.' . $domain)) {
			if (isset($parts['port'])) {
				return null;
			}
			$paths = wiki_paths_from_request([]);
			try {
				$title = wiki_title_from_url($page_url, $paths['articlepath']);
			} catch (RuntimeException $e) {
				return null;
			}
			$host = preg_replace('/\.m\.([^.]+\.org)$/', '.$1', $host);
			return ['host' => $host, 'title' => $title, 'paths' => $paths];
		}
	}
	return null;
}

function wiki_site_from_api($api, $page_url, $fetch)
{
	$json = $fetch($api . '?action=query&meta=siteinfo&format=json', $api_url);
	$general = json_decode($json, true)['query']['general'] ?? [];
	$origin = wiki_url_origin($api_url);
	$paths = [
		'api' => parse_url($api_url, PHP_URL_PATH),
		'script' => $general['script'] ?? '',
		'articlepath' => $general['articlepath'] ?? '',
		'scheme' => parse_url($origin, PHP_URL_SCHEME),
	];
	if (wiki_paths_from_request(['wiki_paths' => json_encode($paths)]) !== $paths) {
		throw new RuntimeException('Invalid wiki settings');
	}
	if (wiki_url_origin($page_url) !== $origin) {
		throw new RuntimeException('Wiki page and API must share an origin');
	}
	return [
		'host' => substr($origin, strpos($origin, '://') + 3),
		'title' => wiki_title_from_url($page_url, $paths['articlepath'], $paths['script']),
		'paths' => $paths,
	];
}

function discover_wiki_site($page_url, $fetch = null)
{
	$known = known_wiki_site($page_url);
	if ($known !== null) {
		return $known;
	}
	$fetch = $fetch ?? 'fetch_wiki_discovery_url';
	$effective_url = $page_url;
	try {
		$html = $fetch($page_url, $effective_url, true);
		$api = wiki_api_from_html($html, $effective_url);
		return wiki_site_from_api($api, $effective_url, $fetch);
	} catch (RuntimeException $e) {
		// Some sites block HTML requests while allowing their public API.
	}
	$origin = wiki_url_origin($effective_url);
	$candidates = ['/w/api.php', '/api.php', '/wiki/api.php'];
	if (preg_match('~^(.*)/index\.php(?:/|$)~', parse_url($effective_url, PHP_URL_PATH) ?? '', $matches)) {
		array_unshift($candidates, $matches[1] . '/api.php');
	}
	foreach (array_unique($candidates) as $path) {
		try {
			return wiki_site_from_api($origin . $path, $effective_url, $fetch);
		} catch (RuntimeException $e) {
			// A successful HTTP response alone does not identify a MediaWiki API.
		}
	}
	throw new RuntimeException('Could not discover wiki settings');
}

// Read revision metadata without depending on the site's history-page HTML.
function wiki_revision_history($api, $title, $offset, $limit, $ignore_minors, $request = null)
{
	$request = $request ?? 'curl_request';
	$limit = max(1, (int) $limit);
	$params = ['action' => 'query', 'prop' => 'revisions', 'titles' => $title,
		'rvprop' => 'ids|timestamp|flags|sha1', 'format' => 'json', 'formatversion' => 2];
	if ($offset !== '') {
		$date = DateTimeImmutable::createFromFormat('!YmdHis', $offset, new DateTimeZone('UTC'));
		if (!$date) {
			throw new RuntimeException('Invalid revision offset');
		}
		// History pagination starts before the supplied revision, not at it.
		$params['rvstart'] = $date->modify('-1 second')->format('YmdHis');
	}
	$revisions = [];
	$deleted = 0;
	$seen = 0;
	do {
		$params['rvlimit'] = min(500, $limit - $seen);
		$json = json_decode($request($api . '?' . http_build_query($params)), true);
		if (!isset($json['query']['pages'][0]) || !is_array($json['query']['pages'][0]) || isset($json['error'])) {
			throw new RuntimeException('Could not retrieve revision history');
		}
		$page = $json['query']['pages'][0];
		$batch = $page['revisions'] ?? [];
		if (!is_array($batch) || (isset($json['continue']) && !is_array($json['continue']))) {
			throw new RuntimeException('Invalid revision history response');
		}
		$seen += count($batch);
		foreach ($batch as $revision) {
			if (!is_array($revision)) {
				throw new RuntimeException('Invalid revision record');
			}
			if (!empty($revision['sha1hidden']) || !isset($revision['revid'])) {
				$deleted++;
			} elseif (!$ignore_minors || empty($revision['minor'])) {
				if (!isset($revision['timestamp']) || !is_string($revision['timestamp'])) {
					throw new RuntimeException('Revision timestamp is missing');
				}
				$revisions[] = $revision;
			}
		}
		$params = array_merge($params, $json['continue'] ?? []);
	} while ($seen < $limit && $batch && isset($json['continue']));
	return ['revisions' => $revisions, 'deleted' => $deleted];
}

function wiki_revision_record($revision, $months, $date_format)
{
	$timestamp = strtotime($revision['timestamp']);
	if ($timestamp === false) {
		throw new RuntimeException('Invalid revision timestamp');
	}
	$date = strtr($date_format, [
		'%B' => $months[(int) gmdate('n', $timestamp) - 1],
		'%d' => gmdate('d', $timestamp),
		'%e' => str_pad(gmdate('j', $timestamp), 2, ' ', STR_PAD_LEFT),
		'%Y' => gmdate('Y', $timestamp),
		'%H' => gmdate('H', $timestamp),
		'%k' => str_pad(gmdate('G', $timestamp), 2, ' ', STR_PAD_LEFT),
		'%M' => gmdate('i', $timestamp),
	]);
	return ['offset' => gmdate('YmdHis', $timestamp), 'timestamp' => $timestamp,
		'id' => $revision['revid'], 'local_date' => $date, 'checked' => false, 'found' => false];
}
