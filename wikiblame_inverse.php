<?header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>WikiBlame</title>
	</head><?
	
	// required to prevent automatic escaping of input strings
	// thanks to http://www.php.net/manual/de/security.magicquotes.disabling.php	
	if (get_magic_quotes_gpc()) {
		function stripslashes_deep($value)
		{
			$value = is_array($value) ?
						array_map('stripslashes_deep', $value) :
						stripslashes($value);
			return $value;
		}

		$_POST = array_map('stripslashes_deep', $_POST);
		$_GET = array_map('stripslashes_deep', $_GET);
		$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
		$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
	}
		

include("shared_inc/language.inc.php");
include("shared_inc/wiki_functions.inc.php");
$inc_dir = "wikiblame_inc";

//get the language file and decide whether rtl oder ltr is used
$user_lang = read_language();
get_language('en', $inc_dir); //not translated messages will be printed in English
get_language($user_lang, $inc_dir);

$alignment = 'right';
if($text_dir=='rtl')
{
	$alignment = 'left';
}

?>
<body style="background: #F9F9F9; font-family: arial; font-size: 84%;  direction: <? echo $text_dir ?>; unicode-bidi: embed">
<?
//for benchmarking reasons
$beginning = time();

$article = $_REQUEST['article']; 
$articleenc = name_in_url($article);

$needle = $_REQUEST['needle']; 

$lang = $_REQUEST['lang'];
if($lang=="")
{
	$lang=$user_lang; 
}

$project = $_REQUEST['project'];
if($project=="")
{
	$project="wikipedia";
}

$limit = $_REQUEST['limit'];

if($limit=="")
{
	$limit = 50;
}

$ignorefirst = $_REQUEST['ignorefirst'];
if($ignorefirst=="")
{
	$ignorefirst = 0;
}

$skipversions = $_REQUEST['skipversions'];
if($skipversions=="")
{
	$skipversions = 0;
}

$ignore_minors = $_REQUEST['ignore_minors'];
if($ignore_minors=="on")
{
	$ignore_minors = true;
}
else
{
	$ignore_minors = false;
}

$invert_sense = $_REQUEST['invert_sense'];
if($invert_sense=="on")
{
	$invert_sense = true;
}
else
{
	$invert_sense = false;
}

//Offset = YYYYMMDDmmhhss
$offset = $_REQUEST['offjahr'];
$offset.= str_pad ($_REQUEST['offmon'], 2, '0', STR_PAD_LEFT);
$offset.= str_pad ($_REQUEST['offtag'], 2, '0', STR_PAD_LEFT);
$offset.= '235500';

if(strlen($offset)<12)
{	
	$offset=strftime("%Y%m%d%H%M%S");
}

$use_binary_search = false;
if($_REQUEST['searchmethod']=="int")
{
	$use_binary_search = true;
}

$asc = false;
if($_REQUEST['order']=="asc")
{
	//if(!$use_binary_search)
	{
		$asc=true;
	}
}

$user=$_REQUEST['user'];

?>		<div align="center">
		<? language_list($inc_dir); ?>
		<h1 style="font-weight: bold;">WikiBlame</h1><!-- Design by Elian -->
		<form method="post" name="mainform" action="<? echo $datei ?>">
		<input type="hidden" name="user_lang" value="<?php echo $user_lang?>">
			<table style="font-family: arial; font-size: 84%;" cellspacing="5">
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="lang">
							<? echo $messages['lang']?>
						</label>
					</td>
					<td>
						<input type="text" name="lang" id="lang" value="<?php echo $lang; ?>">
					</td>
				</tr>
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="project">
							<? echo $messages['project']?>
						</label>
					</td>
					<td>
						<input type="text" name="project" id="project" value="<?php echo $project; ?>">
					</td>
				</tr>				
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="article">
							<? echo $messages['article'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="article" id="article" value="<?php echo $article; ?>">
					</td>
				</tr>
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="needle">
							<? echo $messages['needle'] ?>
						</label>
					</td>						
					<td>
						<input type="text" name="needle" id="needle" value="<?php echo  htmlspecialchars($needle); ?>"> 
					</td>
				</tr>
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="skipversions"> 
							<? echo $messages['skipversions'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="skipversions" id="skipversions" value="<?php echo  $skipversions; ?>">
					</td>
				</tr>				
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="ignorefirst">
							<? echo $messages['ignorefirst'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="ignorefirst" id="ignorefirst" value="<?php echo $ignorefirst; ?>">
					</td>
				</tr>	
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="limit">
							<? echo $messages['limit'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="limit" id="limit" value="<?php echo $limit; ?>">
					</td>
				</tr>	
				<tr>
					<td align="<? echo $alignment ?>">
						<? echo $messages['start_date'].' (DD-MM-YYYY)' ?>
					</td>
					<td>
						<?php datedrop($messages['start_date'].' (DD-MM-YYYY)', "off", false, 2003, '', $_REQUEST['offjahr'], $_REQUEST['offmon'], $_REQUEST['offtag']); ?>
						
						<input type="button" value="<? echo $messages['reset'] ?>" onclick="javascript:var now=new Date();document.forms['mainform'].elements['offtag'].value=now.getDate();document.forms['mainform'].elements['offmon'].value=now.getMonth()+1;document.forms['mainform'].elements['offjahr'].value=now.getFullYear();">
					</td>
				<tr>
					<td align="<? echo $alignment ?>"><? echo $messages['order'] ?></td>
					<td>
						<input type="radio" name="order" id="desc" value="desc" <? if ($asc!=true) echo checked; ?> >
						<label for="desc">
							<? echo $messages['newest_first'] ?>
						</label>
						<input type="radio" name="order" id="asc" value="asc" <? if ($asc==true) echo checked; ?> >
						<label for="asc">
							<? echo $messages['oldest_first'] ?>
						</label>
					</td>
				</tr>
				<tr>
					<td align="<? echo $alignment ?>"><? echo $messages['search_method'] ?></td>
					<td>
						<input type="radio" name="searchmethod" id="linear" value="lin" <? if ($use_binary_search!=true) echo checked; ?> >
						<label for="linear">
							<? echo $messages['linear'] ?>
						</label>
						<input type="radio" name="searchmethod" id="int" value="int" <? if ($use_binary_search==true) echo checked; ?> >
						<label for="int">
						<? echo $messages['interpolated'] ?>
						</label>
					</td>
				</tr>		
				<tr>
					<td align="<? echo $alignment ?>">
						
						<input type="checkbox" name="ignore_minors" id="ignore_minors" <? if ($ignore_minors==true) echo checked; ?> >
					</td>
					<td>
						<label for="ignore_minors">
							<? echo $messages['ignore_minors'] ?>
						</label>
					</td>
				</tr>
				<tr>
					<td align="<? echo $alignment ?>">
					<input type="checkbox" name="invert_sense" id="invert_sense" <? if ($invert_sense==true) echo checked; ?> >
					</td>
					<td>
					<label for="invert_sense">
					<? echo $messages['invert_sense'] ?> inverse sense
					</label>
					</td>
				<tr>
					<td colspan="2" align="center"><br><br>
						<input type="submit" value="<? echo $messages['start'] ?>" >
					</td>
				</tr>
			</table>
		</form>
<hr>
<a href='<? echo $messages['manual_link'] ?>'><? echo $messages['manual'] ?></a> - 
<a href="http://de.wikipedia.org/wiki/Benutzer:Flominator">by Flominator</a> <? print_translator($user_lang)?>
<a href='<? echo $messages['contact_link'] ?>'><? echo $messages['contact'] ?></a> - 
</div>
<?php

if($needle!="")
{
	//$needle = needle_regex($needle); necessary if you work with html, which is currently not the case
	check_options(); // stops script, when wrong options are used
	
	$tags_present = $_REQUEST['tags_present'];
	if($tags_present=="")
	{
		$tags_present=wikitags_present();
	}
	
	if($lang=="blank")
	{
		$server= $project.".org";
	}
	else
	{
		$server= $lang.".".$project.".org";
	}
	
	$historyurl = "http://".$server."/w/index.php?title=".$articleenc."&action=history&limit=$limit&offset=$offset";
	
	//@TODO: create a method from this
	$msg = str_replace('_ARTICLELINK_', "<a href=\"http://".$server."/wiki/".$article."\">$article</a>", $messages['search_in_progress']);
	$msg = str_replace('_NEEDLE_', $needle,$msg);
	echo "$msg<br>\n";
	
	//echo $historyurl;
	$history = get_request($server, $historyurl);
	
	
	//echo "<hr><pre>$history</pre><hr>";
	$get_version_time = time()-$beginning;
	$versions = listversions($history);
	log_search();
	
	if(count($versions)>0)
	{
		if($use_binary_search)
		{
			binary_search(floor(count($versions)/2), count($versions)-1);
		}
		else
		{
			checkversions($versions);
		}
	}
		
	$finished = time()-$beginning;
	log_search($finished);
	echo "<br>";
	echo str_replace('_EXECUTIONTIME_', $finished, $messages['execution_time']);
	
		echo '<br /><br /><small>http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"]."?project=$project&article=".urlencode($article)."&needle=".urlencode($needle)."&"."l<!----->ang=$lang&limit=$limit&ignorefirst=$ignorefirst&offjahr=$offjahr&offmon=$offmon&offtag=$offtag&searchmethod=$searchmethod&order=$order</small>";
	
}

//takes the requested history page, extracts links to the revisions and puts them into an array that is returned
function listversions ($history)
{
	global $articleenc, $asc, $messages, $ignore_minors;
	$searchterm = "name=\"diff\" /> "; //assumes that the history begins at the first occurrence of name="diff" />
	$versionen=array(); //array to store the links in
	
	$revision_html_blocks = explode($searchterm, $history); 
	
	/*
	result in $revision_html_blocks are parts of the revision history that look like this (without line wraps) 
	
	<a href="/w/index.php?title=Hinterzarten&amp;oldid=282077848" title="Hinterzarten">09:56, 6 April 2009</a> 
	<span class='history-user'><a href="/wiki/User:KapHorn" title="User:KapHorn" class="mw-userlink">KapHorn</a>  
		<span class="mw-usertoollinks">(<a href="/wiki/User_talk:KapHorn" title="User talk:KapHorn">talk</a>&#32;|&#32;
			<a href="/wiki/Special:Contributions/KapHorn" title="Special:Contributions/KapHorn">contribs</a>)
		</span>
	/span> 
	<span class="history-size">(4,556 bytes)</span> 
	<span class="comment">(Changed link &quot;Höllental&quot;)</span> 
	(<span class="mw-history-undo"><a href="/w/index.php?title=Hinterzarten&amp;action=edit&amp;undoafter=260903093&amp;undo=282077848" title="Hinterzarten">undo</a></span>) 
	</li>	*/
	
	//iterate over the parts 
	for($block_i = 1;$block_i<count($revision_html_blocks);$block_i++)
	{
		//find the closing sequence of the a tag
		$pos_of_closed_a = strpos($revision_html_blocks[$block_i], "</a>"); 
		
		//extract the link from the current part (e.g. <a href="/w/index.php?title=Hinterzarten&amp;oldid=282077848" title="Hinterzarten">09:56, 6 April 2009)
		$one_version = substr($revision_html_blocks[$block_i], 0, $pos_of_closed_a);
		
		if($ignore_minors)
		{
			//checks if the revision was marked as minor edit
			if(!stristr($one_version_link, "<span class=\"minor\">")) 
			{
				$versions[]= $one_version;
			}
			else
			{
				//echo "ignored a minor change";
			}
		}
		else
		{
			$versions[]= $one_version;
		}
	}

	if($asc==true)
	{
		echo "reversing the list";
		$versions = array_reverse($versions);
	}

	echo str_replace('_NUMBEROFVERSIONS_', count($versions), $messages['versions_found']).'<br>';
	return $versions;
	
	//regular expression that could be used to extract data from the revision links somewhen
	//!oldid=(\d+)".*>([^<]+)</a>.*>([^<]+)</a>! 1=date, 2=revid 3=user
}

function checkversions ($versions)
{
	global $server, $skipversions, $ignorefirst;

	$version_counter = 0;
	echo "<ul>";
	foreach($versions as $version)
	{
		echo "<li>".str_replace("/w/", "http://".$server."/w/", $version)."</a> ";
		
		if($ignorefirst==0)
		{
			if($version_counter==0)
			{
				if(needleinversion(idfromurl($version)))
				{
					echo " <font color=\"green\">OOO</font>\n";
				}
				else
				{
					echo " <font color=\"red\">XXX</font>\n";
				}
				$version_counter=$skipversions;
			}
			else
			{
				echo " <font color=\"blue\">???</font>\n";
				$version_counter--;
			}
		}
		else
		{
			echo " <font color=\"blue\">???</font>\n";
			$ignorefirst--;
		}
		echo "</li>\n";
	}
	echo "</ul>";
}

function idfromurl ($url)
{
	$pos = strpos($url, "oldid=");
	$endpos = strpos($url, "\"", $pos+6);
	$id=substr($url, $pos+6, $endpos-($pos+6)); 
	return $id;
}

function needleinversion ($id)
{
	set_time_limit(60);
	global $needle, $server, $articleenc, $tags_present, $asc, $invert_sense;
	$url = "http://".$server."/w/index.php?title=".$articleenc."&oldid=".$id;
	
	if($tags_present)
	{
		$versionpage = get_request($server, $url."&action=raw");
	}
	else
	{
		//remove the html tags (not included above because of <ref> and others)
		$versionpage = strip_tags(get_request($server, $url));
	}

	
	/*
		//php replacement for command line
		$url = str_replace("&", "\&", $url); 
		if(shell_exec("/usr/bin/wget --quiet -O - $url| /bin/grep \"$needle\"")!="")
	*/
	
	if(stristr($versionpage, $needle))
	{
		return(!$invert_sense);//true);
	}
	else
	{
		return($invert_sense);//false);
	}

}

function log_search ($time="started")
{
	global $article, $needle, $lang, $project, $asc, $use_binary_search, $server, $limit, $skipversions, $get_version_time, $versions, $offset, $user, $user_lang;
	$logfile = "wikiblame.csv";
	
	if(!file_exists($logfile))
	{
		$header="Day;";
		$header.="Time;";
		$header.="IP (Client);";
		$header.="UI Language;";
		$header.="Needle;";
		$header.="Article;";
		$header.="Language;";
		$header.="Project;";
		$header.="Offset;";
		$header.="Wanted Versions;";
		$header.="Found Versions;";
		$header.="Skipped Versions;";
		$header.="Linear/Interpolated;";
		$header.="Execution-Time;";
		$header.="Get-Version-Time;";
		$header.="Referer\n";
		
	}
	
	
	if($file = fopen($logfile, "a"))
	{
		fputs($file, $header);
		fputs($file, strftime("%Y-%m-%d").";");
		fputs($file, strftime("%H:%M").";");
		fputs($file, "\"".$_SERVER['REMOTE_ADDR']."\";");
		fputs($file, $user_lang.";");
		fputs($file, "\"".$needle."\";");
		fputs($file, "\"".$article."\";");
		fputs($file, $lang.";");
		fputs($file, $project.";");
		fputs($file, "'$offset;");
		fputs($file, $limit.";");
		fputs($file, count($versions).";");
		fputs($file, $skipversions.";");

		
		if($use_binary_search)
		{
			fputs($file, "interpolated;");
		}
		else
		{
			fputs($file, "linear;");
		}
		
		fputs($file, $time.";");
		fputs($file, $get_version_time.";");
		fputs($file, $_SERVER['HTTP_REFERER'].";\n");
		fclose($file);
	}
	
}


//translates wiki syntax to html
function needle_regex($needle)
{
	$needle = preg_replace('#\'\'\'(.*)\'\'\'#is', '<b>$1</b>', $needle); //bold
	$needle = preg_replace('#\'\'(.*)\'\'#is', '<i>$1</i>', $needle); //italic
	$needle = str_replace('[[', '<a.*>', $needle); //link
	$needle = str_replace(']]', '</a>', $needle); //end of link
	$needle = preg_replace('#\n\*([^\n\r]*)#is', '<li>$1</li>', $needle); //list items
	return($needle);
}

function binary_search($middle, $from)
{
	global $needle, $versions, $server, $messages;
	
	if($middle<1)
	{
		die($messages['first_version']);
	}
	
	if($middle==$from)
	{
		die($messages['no_differences']);
	}

	//echo "Checking differences between ".get_diff_link($middle)." between $middle and ". ($middle+1)." starting from $from : ";
	//echo $messages['search_in_progress'];
	
	$test_msg = str_replace('_FIRSTDATEVERSION_', get_diff_link($middle), $messages['binary_test']);
	$test_msg = str_replace('_FIRSTNUMBER_', $middle, $test_msg);
	$test_msg = str_replace('_SECONDNUMBER_', $middle+1, $test_msg);
	$test_msg = str_replace('_SOURCENUMBER_', $from, $test_msg);
	echo $test_msg;
	
	$in_this = needleinversion(idfromurl($versions[$middle]));
	$in_next = needleinversion(idfromurl($versions[$middle+1]));
	if($in_this AND $in_next)
	{
		echo "<font color=\"green\">OO</font><br>\n";
		binary_search(floor($middle+abs(($from-$middle)/2)), $middle);
	}
	else
	{
		if(!$in_this AND !$in_next)
		{
			echo "<font color=\"red\">XX</font><br>\n";
			binary_search(floor($middle-abs(($from-$middle)/2)), $middle);
		}
		else
		{
			$left_version = str_replace("/w/", "http://".$server."/w/", $versions[$middle+1])."</a> ";
			$right_version = str_replace("/w/", "http://".$server."/w/", $versions[$middle])."</a>";
			if($in_this AND !$in_next)
			{
				echo "<font color=\"red\">X</font>\n";
				echo "<font color=\"green\">0</font><br>\n";
				$insertion_found = str_replace('LEFT_VERSION', $left_version, $messages['insertion_found']);
				echo str_replace('RIGHT_VERSION', $right_version, $insertion_found);
			}
			else
			{
				echo "<font color=\"green\">O</font>\n";
				echo "<font color=\"red\">X</font><br>\n";
				$deletion_found = str_replace('LEFT_VERSION', $left_version, $messages['deletion_found']);
				echo str_replace('RIGHT_VERSION', $right_version, $deletion_found);
			}
			echo "<br>";
			
		}
	}

}
 
function get_diff_link($index, $order="prev")
{
	global $versions, $server;
	
	$versionslink = str_replace("/w/", "http://".$server."/w/", $versions[$index])."</a>";
	$versionslink = str_replace("oldid", "diff=".$order."&oldid", $versionslink);
	return($versionslink);
}

function wikitags_present()
{
	global $needle;
	$tag_elements=array('[', ']', '{', '}', '*', '#', '==', "\'\'", '<', '>', '|');
	
	foreach ($tag_elements as $tag_element)
	{
		if(stristr($needle, $tag_element))
		{
			return true;
			break;
		}
	}
	
	return false;
}

function check_options()
{
	global $skipversions, $limit, $ignorefirst, $messages;
	
	$msg = str_replace('__VERSIONSTOSEARCH__', $limit, $messages['wrong_skips']);
	
	if($skipversions>=$limit)
	{
		$msg = str_replace('__VERSIONSTOSKIP__', $skipversions, $msg);
		echo "<br />";
		echo "<script>\n";
		echo "document.getElementById('skipversions').focus();\n";
		echo "document.getElementById('skipversions').select();\n";
		echo "</script>";
		echo $msg;
		die();
	}
	
	if($ignorefirst>=$limit)
	{
		$msg = str_replace('__VERSIONSTOSKIP__', $ignorefirst, $msg);
		echo "<br />";
		echo "<script>\n";
		echo "document.getElementById('ignorefirst').focus();\n";
		echo "document.getElementById('ignorefirst').select();\n";
		echo "</script>";
		echo $msg;
		die();
	}
}

function print_translator($lang)
{
	global $messages;
	if($messages['translator']!="")
	{
		echo "& <a href=\"".$messages['translator_link']."\">$messages[translator]</a> (translation)";
	}
}

?>
 <p align="<? echo $alignment ?>"> 
    <a href="http://validator.w3.org/check?uri=referer"><img border="0"
        src="http://www.w3.org/Icons/valid-html401-blue"
        alt="Valid HTML 4.01 Transitional" height="31" width="88"></a>
  </p>
	</body>
</html>