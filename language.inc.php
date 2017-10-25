<?php

// list all languages available in inc directory
function get_language_list ($inc_dir)
{
    global $user_lang;
    $dir_ref = opendir($inc_dir);
    rewinddir($dir_ref);
	$list = array();

	do
	{
		$file = readdir($dir_ref); //get next file of inc directory
		clearstatcache();
		
		if((substr($file,0,1)!=".")&&(!is_dir($inc_dir."/".$file))&&($file!="")) //current file is really a file and no directory
		{
			if((stristr($file, '.php')) && (!stristr($file, 'qqq')))  //file is really a language file (qqq comes from translatewiki)
			{
				$list[] = str_replace('.php', '', $file); //add language of file to the list
			}
		}
	}while($file);
		
	sort($list);
	closedir($dir_ref);
	return $list;
}

function get_language($lang, $inc_dir)
{
	global $messages, $inc_dir, $text_dir;
	if(strlen($lang)>9) //3 was too small because of be-tarask
	{
		$lang='en';
	}
	$langfile = "$inc_dir/$lang.php";

	if(!@include ($langfile))
	{
		//echo "Using default language: english";
		include("$inc_dir/en.php");
	}
}

//tries to retrieve the language of the browser
function read_language()
{
	$user_lang=isset ($_REQUEST['user_lang']) ? $_REQUEST['user_lang'] : "";

	if($user_lang=="")
	{
		$acceptLang = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? $_SERVER["HTTP_ACCEPT_LANGUAGE"] : "";
		//http://www.php-resource.de/forum/showthread.php?threadid=22545
		preg_match("/^([a-z]+)-?([^,;]*)/i", $_SERVER["HTTP_ACCEPT_LANGUAGE"], $matches);
		
		$user_lang = $matches[1];
		//echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		if($user_lang=="")
		{
			$user_lang='en';
		}
	}
	return $user_lang;
}

//tries to avoid most of the incorrect entered languages
function correct_language_mistakes($lang)
{
	$lang = strtolower(trim($lang));
	
	//first: parts of strings that occour in a lot of translations of a language
	if(stristr($lang, 'esp'))
	{
		return 'es';
	}
	
	if(stristr($lang, 'eng'))
	{
		return 'en';
	}
	
	if(stristr($lang, 'catal'))
	{
		return 'ca';
	}
	
	if(stristr($lang, 'ita'))
	{
		return 'it';
	}
	
	if(stristr($lang, 'pol'))
	{
		return 'pl';
	}
	
	if(stristr($lang, 'portu'))
	{
		return 'pt';
	}
	
	if(stristr($lang, 'viet'))
	{
		return 'vi';
	}
	
	if(stristr($lang, 'α'))
	{
		return 'el';
	}
	
	//second: some known words
	switch($lang)
	{
		case 'afrikaans':	return 'af';
		case 'aleman':		return 'de';
		case 'anglais':		return 'en';
		case 'arabic':		return 'ar';
		case 'عربي':		return 'ar';
		case 'العربية':		return 'ar';
		case 'bosanski':	return 'bs';
		case 'castellano':	return 'es';
		case 'deutsch':		return 'de';
		case 'enlish': 		return 'en';
		case 'elinika':		return 'el';
		case 'ellinika':	return 'el';
		case 'ΕΛΛΗΝΙΚΑ':	return 'el';
		case 'ελληνικη':	return 'el';
		case 'ΕΛΛΗΝΙΚΗ':	return 'el';
		case 'françai';		return 'fr';
		case 'francais';	return 'fr';
		case 'français';	return 'fr';
		case 'française';	return 'fr';
		case 'french';		return 'fr';
		case 'german': 		return 'de';
		case 'hindi': 		return 'hi';
		case 'inggris': 	return 'id';
		case 'khmer':		return 'km';
		case 'malay':		return 'ms';
		case 'nepali':		return 'ne';
		case 'spanish':		return 'es';
		case 'tamil':		return 'ta';
		case '中文':			return 'zh';
		default: return $lang;
	}
}

function language_selection($user_lang, $inc_dir)
{
	echo "<select name=\"user_lang\" onchange=\"javascript:forms['mainform'].submit()\">\n";
	//create links to all languages
	foreach(get_language_list($inc_dir) AS $language)
	{
		if($language!=$user_lang)
		{
			echo "<option>$language</option>\n";
			//echo "[<a href=\"?user_lang=$language\">$language</a>]&nbsp;";
		}
		else
		{
			echo "<option selected>$language</option>\n";
			//echo "[$language]&nbsp;";
		}
	}
	echo "</select>\n";
}

function get_months($messages)
{
    $the_months[] =  $messages['January'];
    $the_months[] =  $messages['February'];
    $the_months[] =  $messages['March'];
    $the_months[] =  $messages['April'];
    $the_months[] =  $messages['May'];
    $the_months[] =  $messages['June'];
    $the_months[] =  $messages['July'];
    $the_months[] =  $messages['August'];
    $the_months[] =  $messages['September'];
    $the_months[] =  $messages['October'];
    $the_months[] =  $messages['November'];
    $the_months[] =  $messages['December'];
    return $the_months;
}
?>
