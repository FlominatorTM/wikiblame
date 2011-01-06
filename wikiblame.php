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


//for benchmarking reasons
$beginning = time();

$article = $_REQUEST['article']; 
$articleenc = name_in_url($article);

$needle = trim($_REQUEST['needle']); 

$lang = correct_language_mistakes($_REQUEST['lang']);
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

//Offset = YYYYMMDDmmhhss
$offset = $_REQUEST['offjahr'];
$offset.= str_pad ($_REQUEST['offmon'], 2, '0', STR_PAD_LEFT);
$offset.= str_pad ($_REQUEST['offtag'], 2, '0', STR_PAD_LEFT);
$offset.= '235500';

if(strlen($offset)<12)
{	
	$offset=strftime("%Y%m%d%H%M%S");
}

$use_binary_search = true;
if($_REQUEST['searchmethod']=="lin")
{
	$use_binary_search = false;
}

$asc = false;
if($_REQUEST['order']=="asc")
{
	if(!$use_binary_search)
	{
		$asc=true;
	}
}

$user=$_REQUEST['user'];

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

$force_wikitags = $_REQUEST['force_wikitags'];
if($force_wikitags=="on")
{
	$tags_present = true;
}
else
{
	$force_wikitags = "off";
	$tags_present=wikitags_present();
}

?>
<body onload="document.mainform.<?
//set cursor into needle or article field
if($article!="")
{
	echo "needle";
}
else //no article selected
{
	echo "article";
}

$allowedRevisionsPerCall = 50;

$jsTextLessVersions = str_replace( "__ALLOWEDREVISIONS__", $allowedRevisionsPerCall, $messages['get_less_versions']);

?>.focus();checkScanAmount();" style="background: #F9F9F9; font-family: arial; font-size: 84%;  direction: <? echo $text_dir ?>; unicode-bidi: embed">

<script>
function setFormDate(year, mon, day)
{
	document.forms['mainform'].elements['offjahr'].value = year;
	document.forms['mainform'].elements['offmon'].value = mon;
	document.forms['mainform'].elements['offtag'].value = day;
}

//disable submit button when user wants to query too much revisions by linear search
function checkScanAmount()
{
	var allowedVersionsPerCall = <? echo $allowedRevisionsPerCall ?>;
	var expectedVersionsToQuery = 0;
	var versionsToQuery = document.forms['mainform'].elements['limit'].value;
	var versionsToSkipDuring = document.forms['mainform'].elements['skipversions'].value;
	var versionsToSkipBeginning = document.forms['mainform'].elements['ignorefirst'].value;
	
	expectedVersionsToQuery = versionsToQuery - versionsToSkipBeginning;
	if(versionsToSkipDuring>0)
	{
		expectedVersionsToQuery = expectedVersionsToQuery / versionsToSkipDuring;
	}
	
	if(expectedVersionsToQuery > allowedVersionsPerCall &&
  	   document.forms['mainform'].elements['linear'].checked)
	{
		var alertText = "<? echo $jsTextLessVersions ?>";

		alert(alertText.replace(/__NUMREVISIONS__/g, ""+expectedVersionsToQuery));
		document.forms['mainform'].elements['start'].disabled=true;
	}
	else
	{
		document.forms['mainform'].elements['start'].disabled=false;
	}
}
</script>

		<form method="get" name="mainform" action="<? echo $datei ?>">
		<div align="<? echo $alignment ?>">
		<?
			echo $messages['ui_lang'].'<br />';
			language_selection($user_lang);?>
		</div>
<div align="center">
		<h1 style="font-weight: bold;">WikiBlame</h1><!-- Design by Elian -->
			<table style="font-family: arial; font-size: 84%;" cellspacing="5">
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="lang">
							<? echo $messages['lang']?>
						</label>
					</td>
					<td>
						<input type="text" name="lang" id="lang" value="<?php echo $lang; ?>"> (<?php echo $messages['lang_example']; ?>)
					</td>
				</tr>
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="project">
							<? echo $messages['project']?>
						</label>
					</td>
					<td>
						<input type="text" name="project" id="project" value="<?php echo $project; ?>">  (<?php echo $messages['project_example']; ?>)
					</td>
				</tr>				
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="article">
							<? echo $messages['article']; ?>
						</label>
					</td>
					<td>
						<input type="text" name="article" id="article" value="<?php echo htmlspecialchars($article); ?>">
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
						<input type="text" name="skipversions" id="skipversions" onchange="javascript:checkScanAmount()" value="<?php echo  $skipversions; ?>">
					</td>
				</tr>				
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="ignorefirst">
							<? echo $messages['ignorefirst'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="ignorefirst" id="ignorefirst" onchange="javascript:checkScanAmount()" value="<?php echo $ignorefirst; ?>">
					</td>
				</tr>	
				<tr>
					<td align="<? echo $alignment ?>">
						<label for="limit">
							<? echo $messages['limit'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="limit" id="limit" onchange="javascript:checkScanAmount()" value="<?php echo $limit; ?>">
					</td>
				</tr>	
				<tr>
					<td align="<? echo $alignment ?>">
						<? echo $messages['start_date'].' (DD-MM-YYYY)' ?>
					</td>
					<td>
						<?php datedrop_with_months($messages['start_date'].' (DD-MM-YYYY)', "off", false, 2003, '', $_REQUEST['offjahr'], $_REQUEST['offmon'], $_REQUEST['offtag'], $the_months); ?>
						
						<input type="button" value="<? echo $messages['reset'] ?>" onclick="javascript:var now=new Date();setFormDate(now.getFullYear(),now.getMonth()+1, now.getDate());">
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
						<input type="radio" name="searchmethod" id="linear" value="lin"  onchange="javascript:checkScanAmount()"  <? if ($use_binary_search!=true) echo checked; ?> >
						<label for="linear">
							<? echo $messages['linear'] ?>
						</label>
						<input type="radio" name="searchmethod" id="int" value="int" onchange="javascript:checkScanAmount()"   <? if ($use_binary_search==true) echo checked; ?> >
						<label for="int">
						<a href="<? echo $messages['binary_in_wp']?>"><? echo $messages['binary'] ?></a>
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
						
						<input type="checkbox" name="force_wikitags" id="force_wikitags" <? if ($force_wikitags=="on") echo checked; ?> >
					</td>
					<td>
						<label for="force_wikitags">
							<? echo $messages['force_wikitags'] ?>
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><br><br>
						<input name="start" id="start" type="submit" value="<? echo $messages['start'] ?>" >
					</td>
				</tr>
			</table>
		</form>
<hr>
<a href='<? echo $messages['manual_link'] ?>'><? echo $messages['manual'] ?></a> - 
<a href='<? echo $messages['contact_link'] ?>'><? echo $messages['contact'] ?></a> - 
<a href='http://translatewiki.net/wiki/Translating:Wikiblame'><? echo $messages['help_translating'] ?></a> -
<a href="http://de.wikipedia.org/wiki/Benutzer:Flominator">by Flominator</a>
<br/> <br/>
Do you think WikiBlame's user interface needs improvement? Please post your opinion <a target="_blank" href="https://sourceforge.net/tracker/index.php?func=detail&aid=2811478&group_id=261179&atid=1127548"> at SourceForge</a>.<br/> <br/>
</div>
<?php

if($needle!="")
{
	//$needle = needle_regex($needle); necessary if you work with html, which is currently not the case
	check_options(); // stops script, when wrong options are used
	if(!$use_binary_search)
	{
		check_calls_from_this_ip($limit, $ignorefirst, $skipversions);
	}
	
	
	if($lang=="blank")
	{
		$server= $project.".org";
	}
	else
	{
		$server= $lang.".".$project.".org";
	}
	
	$historyurl = "http://".$server."/w/index.php?title=".$articleenc."&action=history&limit=$limit&offset=$offset&uselang=$user_lang";
	
	//@TODO: create a method from this
	if($tags_present==true)
	{
		$msg = str_replace('_ARTICLELINK_', "<a href=\"http://".$server."/wiki/".$article."\">$article</a>", $messages['search_in_progress_wikitags']);	
	}
	else
	{
		$msg = str_replace('_ARTICLELINK_', "<a href=\"http://".$server."/wiki/".$article."\">$article</a>", $messages['search_in_progress_text']);	
	}

	$msg = str_replace('_NEEDLE_', htmlentities($needle),$msg);
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
	
		echo '<br /><br /><small>'. htmlspecialchars(get_url($_REQUEST['offjahr'], $_REQUEST['offmon'], $_REQUEST['offtag'])) .'</small>';
		
}


function language_selection($user_lang)
{
	global $inc_dir;
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
		case 'portugues': 	return 'pt';
		case 'spanish':		return 'es';
		case '中文':			return 'zh';
		default: return $lang;
	}
	
	
}

//takes the requested history page, extracts links to the revisions and puts them into an array that is returned
function listversions ($history)
{
	global $articleenc, $asc, $messages, $ignore_minors;
	$searchterm = "name=\"diff\" "; //assumes that the history begins at the first occurrence of name="diff" />  <!--removed />-->

	$versionen=array(); //array to store the links in
	
	$revision_html_blocks = explode($searchterm, $history); 
	
	/*
	result in $revision_html_blocks are parts of the revision history that look like this (without line wraps) 
	
	id="mw-diff-64569839" /> 
	<a href="/w/index.php?title=Hinterzarten&amp;oldid=64569839" title="Hinterzarten">11:27, 16. Sep. 2009</a> 
	<span class='history-user'>
		<a href="/wiki/Benutzer:TXiKiBoT" title="Benutzer:TXiKiBoT" class="mw-userlink">TXiKiBoT</a> 
		<span class="mw-usertoollinks">(<a href="/wiki/Benutzer_Diskussion:TXiKiBoT" title="Benutzer Diskussion:TXiKiBoT">Diskussion</a> | 
			<a href="/wiki/Spezial:Beitr%C3%A4ge/TXiKiBoT" title="Spezial:Beiträge/TXiKiBoT">Beiträge</a>)
		</span>
	</span> 
	<abbr class="minor" title="Kleine �?nderung">K</abbr> 
	<span class="history-size">(10.740 Bytes)</span> 
	<span class="comment">(Bot: Ergänze: <a href="http://vi.wikipedia.org/wiki/Hinterzarten" class="extiw" title="vi:Hinterzarten">vi:Hinterzarten</a>)</span> (<span class="mw-history-undo"><a href="/w/index.php?title=Hinterzarten&amp;action=edit&amp;undoafter=64556690&amp;undo=64569839" title="Hinterzarten">entfernen</a></span>) </span> <small><span class='fr-hist-autoreviewed plainlinks'>[<a href="http://de.wikipedia.org/w/index.php?title=Hinterzarten&amp;stableid=64569839" class="external text" rel="nofollow">automatisch gesichtet</a>]</span></small></li> <li><span class='flaggedrevs-color-1'>(<a href="/w/index.php?title=Hinterzarten&amp;diff=64569839&amp;oldid=64556690" title="Hinterzarten">Aktuell</a>) (<a href="/w/index.php?title=Hinterzarten&amp;diff=64556690&amp;oldid=63484457" title="Hinterzarten">Vorherige</a>) <input type="radio" value="64556690" checked="checked" name="oldid" id="mw-oldid-64556690" /><input type="radio" value="64556690" 
	</li>	*/
	
	//iterate over the parts 
	for($block_i = 1;$block_i<count($revision_html_blocks);$block_i++)
	{
		//find the beginning of the a tag
		$start_pos_of_a = strpos($revision_html_blocks[$block_i], "<a"); 
		
		//find the closing sequence of the a tag
		$pos_of_closed_a = strpos($revision_html_blocks[$block_i], "</a>"); 
		
		$length_between_both = $pos_of_closed_a - $start_pos_of_a;
		
		//extract the link from the current part like this one:
		$one_version = substr($revision_html_blocks[$block_i], $start_pos_of_a , $length_between_both);
		
		//result: <a href="/w/index.php?title=Hinterzarten&amp;oldid=64569839" title="Hinterzarten">11:27, 16. Sep. 2009

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
	global $server, $skipversions, $ignorefirst, $needle;

	$version_counter = 0;
	echo "<ul>";
	foreach($versions as $version)
	{
		echo "<li>".str_replace("/w/", "http://".$server."/w/", $version)."</a> ";
		
		if($ignorefirst==0)
		{
			if($version_counter==0)
			{
				$rev_text = get_revision(idfromurl($version));
				if(stristr($rev_text, $needle))
				{
					echo " <font color=\"green\">OOO</font>\n";
				}
				else
				{
					echo " <font color=\"red\">XXX</font>\n";
				}
				start_over_here($rev_text);
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

function get_revision($id)
{
	set_time_limit(60);
	global $needle, $server, $articleenc, $tags_present;
	$url = "http://".$server."/w/index.php?uselang=en&title=".$articleenc."&oldid=".$id;
	
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
	removeheaders(&$versionpage);
	return $versionpage;
}

//generate link to start a new search with the date of this revision
//currently only works when not searching for wiki text
function start_over_here($versionpage)
{
	global $messages;
	// every revision (except the current on contains a text like this:
	//as of 10:01, 7 November 2006 by username

	$strBegin = "Revision as of ";
	$beginning = strpos($versionpage, $strBegin);

	if($beginning>0) //this is not the current revision (which looks different)
	{
		$ending = strpos($versionpage, " by ", $beginning);
		//extract date from revision text
		$strDate = substr($versionpage, $beginning+strlen($strBegin)+6, $ending-$beginning-strlen($strBegin));

		$dateParts = explode(' ', trim($strDate));
		$day = $dateParts[0];
		
		$months['January'] = 1;
		$months['February'] = 2;
		$months['March'] = 3;
		$months['April'] = 4;
		$months['May'] = 5;
		$months['June'] = 6;
		$months['July'] = 7;
		$months['August'] = 8;
		$months['September'] = 9;
		$months['October'] = 10;
		$months['November'] = 11;
		$months['December'] = 12;
		$month = $months[$dateParts[1]] ;
		$year = $dateParts[2];
		$theUrl = get_url($year,$month , $day, false);
		echo "<a href=\"".$theUrl."\">[".$messages['start_here']."]</a>";
	}

}

function log_search ($time="started")
{
	global $article, $needle, $lang, $project, $asc, $use_binary_search, $server, $limit, $skipversions, $get_version_time, $versions, $offset, $user, $user_lang;
	$logfile = "wikiblame_".strftime("%Y-%m-%d").".csv";
	
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

	$rev_text = get_revision(idfromurl($versions[$middle]));
	$in_this = stristr($rev_text, $needle);
	$in_next = stristr(get_revision(idfromurl($versions[$middle+1])), $needle);
	if($in_this AND $in_next)
	{
		echo "<font color=\"green\">OO</font>\n";
		start_over_here($rev_text);
		echo "<br />";
		binary_search(floor($middle+abs(($from-$middle)/2)), $middle);
	}
	else
	{
		if(!$in_this AND !$in_next)
		{
			echo "<font color=\"red\">XX</font>\n";
			start_over_here($rev_text);
			echo "<br />";
			binary_search(floor($middle-abs(($from-$middle)/2)), $middle);
		}
		else
		{
		//$right_version was 1
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
				echo "<font color=\"red\">X</font>\n";
				//start_over_here($rev_text);
				$deletion_found = str_replace('LEFT_VERSION', $left_version, $messages['deletion_found']);
				echo str_replace('RIGHT_VERSION', $right_version, $deletion_found);
			}			
			echo "<br />";
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
	$tag_elements=array('[', ']', '{', '}', '*', '#', '==', "''", '<', '>', '|', '__', '---');
	
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


function get_url($year, $month, $day, $include_ignorefirst=true)
{
	global $project, $article, $needle, $lang, $limit, $ignorefirst,$order, $force_wikitags, $user_lang;
	$url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"]."?project=$project&article=".urlencode($article)."&needle=".urlencode($needle)."&"."lang=$lang&limit=$limit"."&offjahr=$year&offmon=$month&offtag=$day&searchmethod=".$_REQUEST['searchmethod']."&order=".$_REQUEST['order']."&force_wikitags=$force_wikitags&user_lang=$user_lang";
	
	if($include_ignorefirst)
	{
		$url.="&ignorefirst=".$_REQUEST['ignorefirst'];
	}
	return $url;
}

function check_calls_from_this_ip($limit, $ignorefirst, $skipversions)
{
	
	global $messages;
	$allowedRevisionsPerPeriod = 100;
	$periodInMinutes =30;
	$expectedVersions = $limit - $ignorefirst;
	$totalVersions = $expectedVersions;
	if($skipversions > 0)
	{
		$expectedVersions = $expectedVersions / $skipversions;
	}
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$filename = "quota/". md5($ip);
	
	if(file_exists($filename))
	{
		//echo "File $filename exists";
		//echo "File is younger than $periodInMinutes minutes";
		$file = fopen($filename, "r");
		
		if($file)
		{
			$alreadyQueried = fgets($file, 8);
			fclose($file);
			//echo "IP has already queried $alreadyQueried versions ";
			$totalVersions = $alreadyQueried + $expectedVersions;
			
			if($totalVersions > $allowedRevisionsPerPeriod)
			{
				$timeForReset = filectime($filename) + ($periodInMinutes *60);
				if(time()>$timeForReset)
				{
					write_simple_file($filename, $expectedVersions);
				}
				else
				{
					$dieMessage = str_replace("__VERSIONLIMIT__", $allowedRevisionsPerPeriod, $messages['too_much_versions']);
					$dieMessage = str_replace("__WAITMINUTES__", $periodInMinutes, $dieMessage);
					log_search("blocked");
					die($dieMessage);
				}
			}
			else
			{
				write_simple_file($filename, $totalVersions);
			}
		}
	}
	else
	{
		write_simple_file($filename, $expectedVersions);
	}
}

function write_simple_file($filename, $content)
{
	$file = fopen($filename, "w");
	if($file)
	{
		fputs($file, $content);
		fclose($file);
	}
}

?>
 <p align="<? echo $alignment ?>"> 
    <!-- <a href="http://www.ps-webhosting.de/?ref=k3591" target="_blank"><img height="31" width="88" alt="Webhosting von ps-webhosting.de" border="0" src="http://www.ps-webhosting.de/banner/ps_button3.gif"></a>-->
	<a href="http://www.ramselehof.de"><img border="0"
        src="ramselehof_powered_feddich.jpg"
        alt="Ramselehof.de"></a>
    <a href="http://validator.w3.org/check?uri=referer"><img border="0"
        src="http://www.w3.org/Icons/valid-html401-blue"
        alt="Valid HTML 4.01 Transitional" height="31" width="88"></a>
  </p>
	</body>
</html>