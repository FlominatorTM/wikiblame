<?php

/**
 * List all languages available in inc directory
 */
function ui_language_list() {
    
    $ui_language_list = glob(TRANSLATION_DIR.'*.php');
    
    foreach ($ui_language_list AS $l) {
        $ui_lang                = str_replace('.php', '', basename($l));
        $ui_languages[$ui_lang] = $ui_lang;
    }
	asort($ui_languages);

    $form = new HTML_QuickForm('ui_language');
    $form->setDefaults(array('user_lang' => read_ui_lang()));
    $form->addElement('select', 'user_lang', NULL, $ui_languages);
    $form->addElement('submit', 'change', 'change');

    return $form->toHtml();
}

function include_language_file($ui_lang = NULL) {
    global $messages, $text_dir;
    
	if (strlen($ui_lang) > 7) {
		$ui_lang = DEFAULT_UI_LANGUAGE;
	}
    
    // security
    $ui_lang = str_replace(array('.', '/', '\\', ' '), '', $ui_lang);
    
    $langfile           = TRANSLATION_DIR.$ui_lang.'.php';
    $langfile_fallback  = TRANSLATION_DIR.DEFAULT_UI_LANGUAGE.'.php';

	if (!@include $langfile) {
		include $langfile_fallback;
	}
}

/**
 * Handles the client language
 */
function read_ui_lang() {
	$ui_lang = param('user_lang');

	if (empty($ui_lang)) {
		$ui_lang = get_client_language();
	}
	
    if (empty($ui_lang)) {
		$ui_lang = DEFAULT_UI_LANGUAGE;
	}

	return $ui_lang;
}
