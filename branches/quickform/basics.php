<?php
// wikiblame independend functions

/**
 * Required to prevent automatic escaping of input strings
 * 
 * Thanks to http://www.php.net/manual/de/security.magicquotes.disabling.php
 */
function stripslashes_deep() {
    if (get_magic_quotes_gpc()) {
    	$_POST     = array_map('_stripslashes_deep', $_POST);
    	$_GET      = array_map('_stripslashes_deep', $_GET);
    	$_COOKIE   = array_map('_stripslashes_deep', $_COOKIE);
    	$_REQUEST  = array_map('_stripslashes_deep', $_REQUEST);
	}
}

function _stripslashes_deep($value) {
	return is_array($value) ? array_map('_stripslashes_deep', $value) : stripslashes($value);
}

/**
 * Tries to retrieve the language of the browser
 * 
 * See http://www.php-resource. de/forum/showthread.php?threadid=22545
 */
function get_client_language() {
    preg_match("/^([a-z]+)-?([^,;]*)/i", $_SERVER["HTTP_ACCEPT_LANGUAGE"], $matches);
    return $matches[1];
}

/**
 * Get a request param
 */
function param($name, $default_value = NULL) {
	if (isset($_REQUEST[$name])) {
		$result = trim($_REQUEST[$name]); // TODO do more sanitizing
        return $result;
	} else {
		return $default_value;
	}
}

/**
 * 
 */
function name_in_url($name) {
    $name = str_replace(' ', '_', $name);
    $name = urlencode($name);
    return $name;
}