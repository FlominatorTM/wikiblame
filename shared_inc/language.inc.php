<?php
function language_list ($inc_dir)
{
    global $user_lang;
    $dir_ref = opendir($inc_dir);
    rewinddir($dir_ref);
	$list = array();
	do
	{
		$file = readdir($dir_ref);
		clearstatcache();
		if((substr($file,0,1)!=".")&&(!is_dir($inc_dir."/".$file))&&($file!=""))
		{
			if(stristr($file, '.php'))
			{
				$list[] = str_replace('.php', '', $file);
			}
		}
	}while($file);
		
	//Sortieren der Verzeichnisse
	sort($list);
	closedir($dir_ref);
	
	foreach($list AS $language)
	{
		if($language!=$user_lang)
		{
			echo "[<a href=\"?user_lang=$language\">$language</a>]&nbsp;";
		}
		else
		{
			echo "[$language]&nbsp;";
		}
	}
}

function get_language($lang, $inc_dir)
{
	global $messages, $inc_dir, $text_dir;
	$langfile = "$inc_dir/$lang.php";
	

	if(!@include ($langfile))
	{
		//echo "Using default language: english";
		include("$inc_dir/en.php");
	}
}

function read_language()
{
	$user_lang=$_REQUEST['user_lang'];

	if($user_lang=="")
	{
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