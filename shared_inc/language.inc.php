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
?>
