<?php
require_once ROOT.'config.php';
require_once ROOT.'basics.php';
require_once SHARED_DIR.'language.inc.php';
require_once SHARED_DIR.'wiki_functions.inc.php';

//get the language file and decide whether rtl oder ltr is used
include_language_file(DEFAULT_UI_LANGUAGE);       // Fallback is english
include_language_file(read_ui_lang());

$text_dir   = $text_dir             ? $text_dir : DEFAULT_WRITE_DIRECTION;
$alignment  = $text_dir == 'ltr'    ? 'right'   : 'left';

// Check required stuff
#if (!is_writeable(LOGFILE)) die('Error: '.basename(LOGFILE).' is not writeable.');

if (!@include('HTML/QuickForm.php')) {
    die('Error: PEAR Class QuickForm is missing.');
} else {
	require_once 'HTML/QuickForm.php';
}