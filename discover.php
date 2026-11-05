<?php
require_once __DIR__ . '/shared_inc/wiki_site.inc.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
try {
	$url = $_GET['url'] ?? '';
	if (!is_string($url) || strlen($url) > 4096 || $url === '') {
		throw new RuntimeException('Invalid wiki URL');
	}
	echo json_encode(discover_wiki_site($url));
} catch (RuntimeException $e) {
	http_response_code(400);
	echo json_encode(['error' => $e->getMessage()]);
}
