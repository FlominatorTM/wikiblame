<?php header('Content-Type: text/html; charset=utf-8');  

// Emulate the header BigPipe sends so we can test through Varnish.
header('Surrogate-Control: BigPipe/1.0');

// Explicitly disable caching so Varnish and other upstreams won't cache.
header("Cache-Control: no-cache, must-revalidate");

// Setting this header instructs Nginx to disable fastcgi_buffering and disable
// gzip for this request.
header('X-Accel-Buffering: no');

//last four lines come from https://www.jeffgeerling.com/blog/2016/streaming-php-disabling-output-buffering-php-apache-nginx-and-varnish
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="WikiBlame.png" type="image/png">
		<link rel="shortcut icon" href="WikiBlame.png" type="image/png">
		<title>WikiBlame</title>
	</head><?php 
include("shared_inc/language.inc.php");
include("shared_inc/wiki_functions.inc.php");
prevent_automatic_escaping_of_input_strings();
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

fill_variables($user_lang);
$the_months = get_months($messages);
?>
<body onload="document.mainform.<?php 
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

?>.focus();checkScanAmount();" style="background: <?php 
if(stristr($_SERVER["PHP_SELF"], 'wikiblame.exp.php'))
{
    echo "#FFEBAD";
}
else 
{
    echo "#F9F9F9";
}?>; font-family: arial; font-size: 84%;  direction: <?php  echo $text_dir ?>; unicode-bidi: embed">

<script type="text/javascript">
function setFormDate(year, mon, day)
{
	document.forms['mainform'].elements['offjahr'].value = year;
	document.forms['mainform'].elements['offmon'].value = mon;
	document.forms['mainform'].elements['offtag'].value = day;
}

//disable submit button when user wants to query too much revisions by linear search
function checkScanAmount()
{
 	var allowedVersionsPerCall = <?php  echo $allowedRevisionsPerCall ?>;
	var expectedVersionsToQuery = 0;
	var versionsToQuery = document.forms['mainform'].elements['limit'].value;
	var versionsToSkipDuring = document.forms['mainform'].elements['skipversions'].value;
	var versionsToSkipBeginning = document.forms['mainform'].elements['ignorefirst'].value;
	
	expectedVersionsToQuery = versionsToQuery - versionsToSkipBeginning;
	if(versionsToSkipDuring>0)
	{
		expectedVersionsToQuery = expectedVersionsToQuery / versionsToSkipDuring;
	}
	
	if((expectedVersionsToQuery > allowedVersionsPerCall &&
  	   document.forms['mainform'].elements['linear'].checked
	   )  <?php  if ($user!="") echo "&& false" ?>)
	{
		var alertText = "<?php  echo $jsTextLessVersions ?>";

		alert(alertText.replace(/__NUMREVISIONS__/g, ""+expectedVersionsToQuery));
		document.forms['mainform'].elements['start'].disabled=true;
	}
	else
	{
		document.forms['mainform'].elements['start'].disabled=false;
	}
}

function pasteFieldsFromUrl()
{
    var mediaWikiUrl = window.prompt('<?php echo $messages['paste_url'] ?>', '');
    if(mediaWikiUrl==null) return;
    var a = document.createElement('a');
    a.href=mediaWikiUrl;

    var hostParts = (a.hostname).split('.');
    var article;
    var language;
    var project;
    if(hostParts.length==3)
    {
        language = hostParts[0];
        project = hostParts[1];
    }
    if(hostParts.length==2)
    {
        language = 'blank';
        project = hostParts[0];
    }

    var titleFound = false;
    var slashWiki = '/wiki/';
    var titleEquals = 'title=';
    if(mediaWikiUrl.search(titleEquals)>0)
    {
        var urlParts = mediaWikiUrl.split('?');
       
        if(urlParts.length==2)
        {
            var paramParts = urlParts[1].split('&');
            for (var i=0; i<paramParts.length; i++)
            {
                if(paramParts[i].startsWith(titleEquals))
                {
                    article = decodeURIComponent(paramParts[i].substr(titleEquals.length)).replace(/_/gm, ' ');
                    titleFound = true;
                    break;
                }
            }
        }
    }
    else if(a.pathname.startsWith(slashWiki))
    {
        article = decodeURIComponent(a.pathname.substr(slashWiki.length)).replace(/_/gm, ' ');
        titleFound = true;
    }

    if(!titleFound)
    {
        alert("<?php echo $messages['no_valid_url'] ?>");
    }
    else
    {
        document.forms['mainform'].elements['lang'].value=language;
        document.forms['mainform'].elements['project'].value=project;
        document.forms['mainform'].elements['article'].value=article;
    }
}

function submitAndWait()
{
	var startButton = document.getElementById("start");
	startButton.disabled=true;
	startButton.value='<?php  echo $messages['please_wait'] ?>';
	return true;
}
</script>
<div align="center">
		<form method="get" name="mainform" onsubmit="submitAndWait();">
		<div align="<?php  echo $alignment ?>">
		<?php 
			echo $messages['ui_lang'].'<br>';
			language_selection($user_lang, $inc_dir);?>
		</div>

		<h1 style="font-weight: bold;">WikiBlame</h1><!-- Design by Elian -->
			<table style="font-family: arial; font-size: 84%;" cellspacing="5">
				<tr>
					<td align="<?php  echo $alignment ?>">
						<label for="lang">
							<?php  echo $messages['lang']?>
						</label>
					</td>
					<td>
						<input type="text" name="lang" id="lang" value="<?php echo $lang; ?>"> (<?php echo $messages['lang_example']; ?>)
					</td>
				</tr>
				<tr>
					<td align="<?php  echo $alignment ?>">
						<label for="project">
							<?php  echo $messages['project']?>
						</label>
					</td>
					<td>
						<input type="text" name="project" id="project" value="<?php echo $project; ?>">  (<?php echo $messages['project_example']; ?>)
					</td>
				</tr>				
				<tr>
					<td align="<?php  echo $alignment ?>">
						<label for="article">
							<?php  echo $messages['article']; ?>
						</label>
					</td>
					<td>
						<input type="text" name="article" id="article" value="<?php echo htmlspecialchars($article); ?>">
                        <input type="button" onclick="javascript:pasteFieldsFromUrl()" value="<?php echo $messages['from_url']?>">
					</td>
				</tr>
				<tr>
					<td align="<?php  echo $alignment ?>">
						<label for="needle">
							<?php  echo $messages['needle'] ?>
						</label>
					</td>						
					<td>
						<input type="text" name="needle" id="needle" value="<?php echo  htmlspecialchars($needle); ?>"> 
					</td>
				</tr>
				<tr>
					<td align="<?php  echo $alignment ?>">
						<label for="skipversions"> 
							<?php  echo $messages['skipversions'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="skipversions" id="skipversions" onchange="javascript:checkScanAmount()" value="<?php echo  $skipversions; ?>">
					</td>
				</tr>				
				<tr>
					<td align="<?php  echo $alignment ?>">
						<label for="ignorefirst">
							<?php  echo $messages['ignorefirst'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="ignorefirst" id="ignorefirst" onchange="javascript:checkScanAmount()" value="<?php echo $ignorefirst; ?>">
					</td>
				</tr>	
				<tr>
					<td align="<?php  echo $alignment ?>">
						<label for="limit">
							<?php  echo $messages['limit'] ?>
						</label>
					</td>
					<td>
						<input type="text" name="limit" id="limit" onchange="javascript:checkScanAmount()" value="<?php echo $limit; ?>">
					</td>
				</tr>	
				<tr>
					<td align="<?php  echo $alignment ?>">
						<?php  echo $messages['start_date'] ?>
					</td>
					<td>
						<?php datedrop_with_months( "", "off", false, 2001, date("Y"), $_REQUEST['offjahr'], $_REQUEST['offmon'], $_REQUEST['offtag'], $the_months, $messages['date_format']); ?>
						<input type="button" value="<?php  echo $messages['reset'] ?>" onclick="javascript:var now=new Date();setFormDate(now.getFullYear(),now.getMonth()+1, now.getDate());">
					</td>
				<tr>
					<td align="<?php  echo $alignment ?>"><?php  echo $messages['search_method'] ?></td>
					<td>
						<input type="radio" name="searchmethod" id="linear" value="lin"  onchange="javascript:checkScanAmount()"  <?php  if ($use_binary_search!=true) echo checked; ?> >
						<label for="linear">
							<?php  echo $messages['linear'] ?>
						</label>
						<input type="radio" name="searchmethod" id="int" value="int" onchange="javascript:checkScanAmount()"   <?php  if ($use_binary_search==true) echo checked; ?> >
						<label for="int">
						<a href="<?php  echo $messages['binary_in_wp']?>"><?php  echo $messages['binary'] ?></a>
						</label>
					</td>
				</tr>	
				<tr>
					<td align="<?php  echo $alignment ?>"><?php  echo $messages['order'] ?></td>
					<td>
						<input type="radio" name="order" id="desc" value="desc" <?php  if ($asc!=true) echo checked; ?> >
						<label for="desc">
							<?php  echo $messages['newest_first'] ?>
						</label>
						<input type="radio" name="order" id="asc" value="asc" <?php  if ($asc==true) echo checked; ?> >
						<label for="asc">
							<?php  echo $messages['oldest_first'] ?>
						</label>
					</td>
				</tr>				
				<tr>
					<td align="<?php  echo $alignment ?>">
					<input type="checkbox" name="binary_search_inverse" id="binary_search_inverse" <?php  if ($binary_search_inverse) echo checked; ?> >
					</td>
					<td>
						<label for="binary_search_inverse">
							<?php  echo $messages['binary_search_inverse'] ?>
						</label>
					</td>
				</tr>		
				<tr>
					<td align="<?php  echo $alignment ?>">
						
						<input type="checkbox" name="ignore_minors" id="ignore_minors" <?php  if ($ignore_minors==true) echo checked; ?> >
					</td>
					<td>
						<label for="ignore_minors">
							<?php  echo $messages['ignore_minors'] ?>
						</label>
					</td>
				</tr>
				<tr>
					<td align="<?php  echo $alignment ?>">
						
						<input type="checkbox" name="force_wikitags" id="force_wikitags" <?php  if ($force_wikitags=="on") echo checked; ?> >
					</td>
					<td>
						<label for="force_wikitags">
							<?php  echo $messages['force_wikitags'] ?>
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><br><br>
						<input name="start" id="start" type="submit" value="<?php  echo $messages['start'] ?>" >
						<input name="user" id="user" type="hidden" value="<?php  echo $user ?>" >
					</td>
				</tr>
			</table>
		</form>
<hr>
<a href='<?php  echo $messages['manual_link'] ?>'><?php  echo $messages['manual'] ?></a> - 
<a href='<?php  echo $messages['contact_link'] ?>'><?php  echo $messages['contact'] ?></a> - 
<a href='http://translatewiki.net/wiki/Translating:Wikiblame'><?php  echo $messages['help_translating'] ?></a> -
<a href="https://de.wikipedia.org/wiki/Benutzer:Flominator">by Flominator</a>
</div>
<?php

if($needle!="")
{
	//$needle = needle_regex($needle); necessary if you work with html, which is currently not the case
	check_options(); // stops script, when wrong options are used
    check_revision_date_format($messages);
	if(!$use_binary_search && $_REQUEST['user']=="")
	{
		check_calls_from_this_ip($limit, $ignorefirst, $skipversions);
	}
	
	//@TODO: create a method from this
	if($tags_present)
	{
		$msg = str_replace('_ARTICLELINK_', "<a href=\"https://".$server."/wiki/".$article."\">$article</a>", $messages['search_in_progress_wikitags']);	
	}
	else
	{
		$msg = str_replace('_ARTICLELINK_', "<a href=\"https://".$server."/wiki/".$article."\">$article</a>", $messages['search_in_progress_text']);	
	}

	$msg = str_replace('_NEEDLE_', htmlspecialchars($needle),$msg);
	echo "$msg<br>\n";
	
	$exec_time = do_search();
	echo '<br>'.$exec_time;
	echo '<br><br><small>'. get_url($_REQUEST['offjahr'], $_REQUEST['offmon'], $_REQUEST['offtag']) .'</small>';
}

function fill_variables($user_lang)
{
    global $article, $articleenc, $needle, $lang, $project, $server,
        $use_binary_search, $limit, $ignorefirst, $skipversions, $ignore_minors, $offset, $binary_search_inverse, $asc,
        $user, $force_wikitags, $tags_present; //todo: probably $tags_present doesn't need to be exposed
    $article = str_replace('_', ' ', $_REQUEST['article']); 
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
    if($lang=="blank")
    {
        $server= $project.".org";
    }
    else
    {
        $server= $lang.".".$project.".org";
    }


    $use_binary_search = true;
    if($_REQUEST['searchmethod']=="lin")
    {
        $use_binary_search = false;
    }

    $limit = $_REQUEST['limit'];

    if($limit=="")
    {
        if($use_binary_search)
        {
            $limit = 500;
        }
        else
        {
            $limit = 50;
        }
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

    $offhour = str_pad ($_REQUEST['offhour'], 2, '0', STR_PAD_LEFT);;
    if($offhour == "00")
    {
        $offhour = 23;
    }
    else
    {
        $offhour = str_pad (Get_UTC_Hours($offhour, $server), 2, '0', STR_PAD_LEFT);
    }

    $offmin = str_pad ($_REQUEST['offmin'], 2, '0', STR_PAD_LEFT);;

    if($offmin == "00")
    {
        $offmin = 55;
    }
    $offset.= $offhour.$offmin.'00';

    if(strlen($offset)<12)
    {	
        $offset=strftime("%Y%m%d%H%M%S");
    }

    if($_REQUEST['binary_search_inverse'] == "on")
    {
        $binary_search_inverse = true;
    }
    else
    {
        $binary_search_inverse = false;
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
    
}

function do_search()
{
    global $versions, $articleenc, $offset, $needle_ever_found, $binary_search_retries, $use_binary_search, $skipversions, $ignorefirst, $messages;

    $beginning = time();//for benchmarking reasons
    $versions = get_all_versions($articleenc, $offset);
    
	log_search();
	$needle_ever_found = false;
	$binary_search_retries = 4;
	if(count($versions)>0)
	{
		if($use_binary_search)
		{
            binary_search_from_earliest_index($versions);
		}
		else
		{
			checkversions($versions, $skipversions, $ignorefirst);
		}
	}
    $finished = time()-$beginning;
	$exec_time =  str_replace('_EXECUTIONTIME_', $finished, $messages['execution_time']);
	
	if(!$needle_ever_found)
	{	
		echo "<br>";
		echo $messages['not_found_at_all']."\n";
		$finished.="_nf";
	}	
	log_search($finished);
    return $exec_time;
}

function check_revision_date_format($messages)
{
    if( !stristr($messages['revision_date_format'], '%d') //day
     || !stristr($messages['revision_date_format'], '%B') //monthname
     || !stristr($messages['revision_date_format'], '%Y') //year
     || !stristr($messages['revision_date_format'], '%H') //hour
     || !stristr($messages['revision_date_format'], '%M')) //minute
     {
         //fallback to en in case of fucked up format
         $messages['revision_date_format'] = "%H:%M, %d %B %Y";
     }
}

function get_all_versions($articleenc, $offset)
{
    global $limit, $server, $user_lang;
    $historyurl = "https://".$server."/wiki/".$articleenc."?action=history&limit=$limit&offset=$offset&uselang=en";	//$user_lang"
	$history = curl_request($historyurl);
	//echo "<hr><pre>$history</pre><hr>";
	return listversions($history);
}

//takes the requested history page, extracts links to the revisions and puts them into an array that is returned
//in default (meaning $asc!=true) index 0 contains the latest revision
function listversions ($history)
{
	global $articleenc, $asc, $messages, $ignore_minors, $deleted_revisions;
	$searchterm = "name=\"diff\" "; //assumes that the history begins at the first occurrence of name="diff" />  <!--removed />-->

	$versionen=array(); //array to store the links in
	$deleted_revisions = 0;
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
	<abbr class="minor" title="Kleine Änderung">K</abbr> 
	<span class="history-size">(10.740 Bytes)</span> 
	<span class="comment">(Bot: Ergänze: <a href="http://vi.wikipedia.org/wiki/Hinterzarten" class="extiw" title="vi:Hinterzarten">vi:Hinterzarten</a>)</span> (<span class="mw-history-undo"><a href="/w/index.php?title=Hinterzarten&amp;action=edit&amp;undoafter=64556690&amp;undo=64569839" title="Hinterzarten">entfernen</a></span>) </span> <small><span class='fr-hist-autoreviewed plainlinks'>[<a href="http://de.wikipedia.org/w/index.php?title=Hinterzarten&amp;stableid=64569839" class="external text" rel="nofollow">automatisch gesichtet</a>]</span></small></li> <li><span class='flaggedrevs-color-1'>(<a href="/w/index.php?title=Hinterzarten&amp;diff=64569839&amp;oldid=64556690" title="Hinterzarten">Aktuell</a>) (<a href="/w/index.php?title=Hinterzarten&amp;diff=64556690&amp;oldid=63484457" title="Hinterzarten">Vorherige</a>) <input type="radio" value="64556690" checked="checked" name="oldid" id="mw-oldid-64556690" /><input type="radio" value="64556690" 
	</li>	*/
	
	if(count($revision_html_blocks)==1) 
	{
		//only one revision and therefor no diff radio buttons
		//simply split at some string that makes the next <a tag the right one
		$revision_html_blocks = explode("pagehistory", $history); 
	}	
	
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

		$is_deleted_revision = stristr($one_version, 'mw-userlink'); //there is no revision link

		if($is_deleted_revision)
        {
            $deleted_revisions++;
        }
        else
		{
			if($ignore_minors)
			{
				//checks if the revision was marked as minor edit
				if(!stristr($one_version, "<span class=\"minor\">")) 
				{
                    add_one_version($one_version, $versions);
					
				}
				else
				{
					//echo "ignored a minor change";
				}
			}
			else
			{
                add_one_version($one_version, $versions);
			}
		}
	}

	if($asc==true)
	{
		//echo "reversing the list";
		$versions = array_reverse($versions);
	}

	echo str_replace('_NUMBEROFVERSIONS_', count($versions), $messages['versions_found']).'<br>';
	return $versions;
	
	//regular expression that could be used to extract data from the revision links somewhen
	//!oldid=(\d+)".*>([^<]+)</a>.*>([^<]+)</a>! 1=date, 2=revid 3=user
}

function add_one_version($one_version, &$versions)
{
    global $server, $the_months, $messages;
    //echo "one version: " . htmlspecialchars($one_version);
    $offset_parts = extract_date_parts_from_history_link($one_version);
    $month = $offset_parts[2];
    $day = $offset_parts[1];
    $year = $offset_parts[3];
    
    $hour = substr($offset_parts[0], 0, 2);
    $minute = substr($offset_parts[0], 3, 2);
    $offset = $year . $month . $day . $hour . $minute;
    
    $timestamp = mktime($hour, $minute, 0, $month, $day, $year);
    $month_localized = $the_months[$month-1];
    $pattern = str_replace('%B', $month_localized, $messages['revision_date_format']);
    $date_localized = strftime($pattern, $timestamp);

    $id = idfromurl ($one_version);
    $versions[] = array('offset' => $offset,
                        'timestamp' => $timestamp,
                        'id' => $id,
                        'local_date' => $date_localized,
                        'checked' => false,
                        'found' => false);
}

function checkversions ($versions, $skipversions, $ignorefirst)
{
	global $server, $needle, $needle_ever_found, $limit, $articleenc, $the_months ;

	$version_counter = 0;
	echo "<ul>";
	for($i=0;$i<count($versions);$i++)
	{
		echo "<li>". get_diff_link($versions[$i]);
		
		if($ignorefirst==0)
		{
			if($version_counter==0)
			{
				if(needle_in_version($needle, $versions, $i))
				{
					echo " <font color=\"green\">OOO</font>\n";
					$needle_ever_found = true;
				}
				else
				{
					echo " <font color=\"red\">XXX</font>\n";
				}
				start_over_here($versions[$i]['offset'], $skipversions);
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
	flush();
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
	$url = "https://".$server."/w/index.php?uselang=en&title=".$articleenc."&oldid=".$id;
    
	if($tags_present)
	{
		$versionpage = curl_request($url."&action=raw");
	}
	else
	{
		//remove the html tags (not included above because of <ref> and others)
		$versionpage = curl_request($url);
		//remove header and footer
		$versionpage = strip_tags(chop_content($versionpage));
	}

	/*
		//php replacement for command line
		$url = str_replace("&", "\&", $url); 
		if(shell_exec("/usr/bin/wget --quiet -O - $url| /bin/grep \"$needle\"")!="")
	*/

	return $versionpage;
}

//generate link to start a new search with the date of this revision
function start_over_here($offset, $skip=0, $link_text="")
{
	global $messages, $limit;
    
    if($link_text=="") //poor man's default parameter
    {
        $link_text = $messages['start_here'];
    }
    $parts = str_split($offset, 2);
    $hour = $parts[4];
    $minute = $parts[5];
    $day = $parts[3];
    $month = $parts[2];		
    $year = $parts[0].$parts[1];
    $theUrl = get_url($year,$month , $day, $hour, $minute, false);
    
    if($skip != 0)
    {
        $theUrl = str_replace("limit=$limit", "limit=$skip", $theUrl);
    }
    echo "<a href=\"".$theUrl."\">[".$link_text."]</a>";


}

function get_month_number($month_text)
{
    $months['January'] = '01';
    $months['February'] = '02';
    $months['March'] = '03';
    $months['April'] = '04';
    $months['May'] = '05';
    $months['June'] = '06';
    $months['July'] = '07';
    $months['August'] = '08';
    $months['September'] = '09';
    $months['October'] = '10';
    $months['November'] = '11';
    $months['December'] = '12';
    return $months[$month_text] ;
}

// 0: time, 1: day, 2: month, 3: year
function extract_date_parts_from_history_link($versionpage)
{
    $ret = false;
    // every revision history link contains a text like this:
	//<a href="/w/index.php?title=Hinterzarten&amp;oldid=151152765" class="mw-changeslist-date" title="Hinterzarten">17:28, 6 February 2016

	$strBegin = ">"; 
	$beginning = strrpos($versionpage, $strBegin);

	if($beginning>0) //this is not the current revision (which looks different)
	{
		//extract date from revision text
		$strDate = substr($versionpage, $beginning+strlen($strBegin));
        $dateParts = explode(' ', trim($strDate));
        
        $dateParts[1] = str_pad($dateParts[1], 2, '0', STR_PAD_LEFT);
        $dateParts[2] = get_month_number($dateParts[2]);
        $ret = $dateParts;
    }
    return $ret;
}
function log_search ($time="started")
{
	global $article, $needle, $lang, $project, $asc, $use_binary_search, $server, $limit, $skipversions, $get_version_time, $versions, $offset, $user, $user_lang;
	$logfile = "log/wikiblame_".strftime("%Y-%m-%d").".csv";
	
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
		$header.="User;";
		$header.="Execution-Time;";
		$header.="Get-Version-Time;";
		$header.="User-Agent;";
		$header.="URL;";
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
		fputs($file, '"'.$_SERVER['HTTP_USER_AGENT'].'"'.";");
		fputs($file, str_replace('&amp;', '&', get_url($year,$month, $day, $hour, $min, true)).";\n");
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

function needle_in_version ($needle, &$versions, $index)
{
    if(!$versions[$index]['checked'])
    {
        $rev_text = get_revision($versions[$index]['id']);
        $found = stristr($rev_text, $needle); 
        $versions[$index]['checked'] = true;
        $versions[$index]['found'] = !(!$found); //to have the boolean instead of the text
    }
    return  $versions[$index]['found'];
}
function check_if_found_in_earliest_version($needle, $versions, $earliest_index, $youngest_version=false)
{
    global $messages;
    //checking first/earliest revision => highest array index
    $found_in_earliest_revision = needle_in_version ($needle, $versions, $earliest_index);
    
    if($found_in_earliest_revision)
    {
		$revLink = get_diff_link($versions[$earliest_index]);
		if(!$youngest_version)
		{
			//highest array index
			$msg = str_replace('__NEEDLE__', '<b>'.htmlspecialchars($needle).'</b>', $messages['first_version_present']);
		}
		else
		{
			//lowest array index
			$msg = str_replace('__NEEDLE__', '<b>'.htmlspecialchars($needle).'</b>', $messages['latest_version_present']);
		}
        echo (str_replace('__REVISIONLINK__', $revLink, $msg)).'<br>';
    }
	flush();
    return $found_in_earliest_revision;
}

function binary_search($middle, $from)
{
	global $needle, $versions, $server, $messages, $binary_search_inverse, $binary_search_retries, $needle_ever_found, $limit, $articleenc, $deleted_revisions;
	//echo "binary_search(".$middle.",".$from.")";
	flush();
	if($middle<0)
	{
        if($from != 2 && $from != 1)
        {
            log_search("first_version");
            //echo ('<br>'.$messages['first_version']);
            return;
        }    
        else
        {
            $middle=0;
        }
	}

    $first_possible_from_value = count($versions);
    $earliest_index = $first_possible_from_value-1;
    if($from == $first_possible_from_value && !$binary_search_inverse)
    {
        if(check_if_found_in_earliest_version($needle, $versions, $earliest_index))
        {
            if((count($versions)+$deleted_revisions)==$limit)
            {
                //there might be revisions before 
                echo $messages['earlier_versions_available'].' ';
                //start_over_here($versions[$earliest_index]['offset']);
                $offset = $versions[$earliest_index]['offset'];
                $versions = get_all_versions($articleenc, $offset);
                binary_search_from_earliest_index($versions);
            }
            $needle_ever_found = true;
            return; //either the new search was started or it was present in the initial version"
        }
    }
    
        
	if($middle==$from)
	{
		log_search("no_differences");
		
		if($binary_search_inverse)
		{
			if(check_if_found_in_earliest_version($needle, $versions, 0, true))
			{
				$needle_ever_found = true;
				//searching for removal, brick wall, found in latest version
				// return
			}
            else if(check_if_found_in_earliest_version($needle, $versions, $earliest_index))
            {
                 $needle_ever_found = true;
                //must have been removed between earliest and where we just checked
                $middle = floor($from + ($earliest_index-$from)/2);
                binary_search($middle, $from);
            }
            else
            {
                if($from>0)
                {
                    //start at a later revision (maybe it was not even inserted at this point of $from)     
                    echo $messages['inverse_restart'].'<br>';
                    binary_search(floor($from/4), floor($from/2));
                }
                else
                {
                     $needle_ever_found = true; //actually it was not, but like this the message "try again" will disappear and the search will be over anyway
                     echo str_replace('_NUMBEROFVERSIONS_', count($versions), $messages['inverse_stuck']).'<br>';
                    start_over_here($versions[$earliest_index]['offset'], 0, $messages['inverse_earliest']);
                    echo '<br>';
                }
            }
        }
		else //looking for insertion => maybe we hit an edit war 
		{	
			/*
				quick and dirty hack to fix this endless loop:
				wikiblame.php?user_lang=en&lang=fr&project=wikipedia&article=Modèle%3AMéta+bandeau+d'événement+récent&needle=<u>&skipversions=0&ignorefirst=0&limit=50&offmon=10&offtag=23&offjahr=2017&searchmethod=int&order=desc&force_wikitags=on
			*/
			if(count($versions)==1) 
			{
				if(check_if_found_in_earliest_version($needle, $versions, 0, false))
				{				
					return;
				}
				else
				{
					$binary_search_retries=0;
				}
			}
			
            if($binary_search_retries>0)
            {
                if(needle_in_version ($needle, $versions, $middle))
                {
                    //was present here already, remove later revisions
                    clear_array_until_including($versions, $middle+1); //middle+1 might be the inserting revision
                    echo str_replace('_NUMBEROFVERSIONS_', count($versions), $messages['versions_found']).'<br>';
                    binary_search_from_earliest_index($versions); 
                }
                else
                {
                    echo $messages['dead_end'].'<br><br>';
                    echo $messages['once_more'].'<br>';
                    $binary_search_retries--; //this only is applied after the recursion :(
                    binary_search($middle, $from-$binary_search_retries);
                        log_search("retry");
                }
            }
            else
            {
                echo $messages['binary_enough'];
                log_search("enough, done");
            }
		}
	}
	else
	{
		//echo "Checking differences between ".get_diff_link($middle)." between $middle and ". ($middle+1)." starting from $from : ";
		//echo $messages['search_in_progress'];
		
		$test_msg = str_replace('_FIRSTDATEVERSION_', get_diff_link($versions[$middle]), $messages['binary_test']);
		$test_msg = str_replace('_FIRSTNUMBER_', $middle, $test_msg);
		$test_msg = str_replace('_SECONDNUMBER_', $middle+1, $test_msg); 
		$test_msg = str_replace('_SOURCENUMBER_', $from, $test_msg);
		echo $test_msg;

		/* Revision list looks like this:
		 [0]: 18. Jan. 2011 21:00 (current revision)
		 [1]: 18. Jan. 2011 19:00
		 [2]: 18. Jan. 2011 17:00
		 [3]: 15. Jan. 2011 15:00 */
		  
		$in_right = needle_in_version ($needle, $versions, $middle);
		$in_left = needle_in_version ($needle, $versions, $middle+1);
		$step_length = abs(($from-$middle)/2);
		if($in_right AND $in_left)
		{
			$needle_ever_found = true;
			echo "<font color=\"green\">OO</font>\n";
			//start_over_here($versions[$middle]['offset'], 0, 0);
			echo "<br>";
			if($binary_search_inverse)
			{
				//looking for removal => found in both => must have been removed later => remove the rest
                $first_to_remove = $middle + 2; //$middle + 1 was checked and might be needed for output
                $count = count($versions);
                if($count>$first_to_remove)
                {
                    echo str_replace('_NUMBEROFVERSIONS_', $count-$first_to_remove, $messages['delete_from_here']).'<br><br>';
                    
                    clear_array_starting_at($versions, $first_to_remove);
                    
                    echo str_replace('_NUMBEROFVERSIONS_', count($versions), $messages['versions_found']).'<br>';
                    binary_search_from_earliest_index($versions); 
                }
                else
                {
                    //prevent endless loops in the last four revisions
                    binary_search(floor($middle-1), $middle);
                }
                
			}
			else
			{
				//looking for insertion => found in both => must have been added earlier => check earlier versions => higher index in history array
				binary_search(floor($middle+$step_length), $middle);
			}
		}
		else
		{
			if(!$in_right AND !$in_left)
			{
				echo "<font color=\"red\">XX</font>\n";
				//start_over_here($versions[$middle]['offset']);
				echo "<br>";
				if($binary_search_inverse)
				{
					//looking for removal => not found in any of both => must have been removed earlier => higher index in history array
					binary_search(floor($middle+$step_length), $middle);
				}
				else
				{
					//looking for insertion => not found in any of both => look later => lower index in history array
					binary_search(floor($middle-$step_length), $middle);						
				}
			}
			else
			{
				$left_version = get_old_link ($versions[$middle+1]);
				$right_version = get_old_link($versions[$middle]);
				if(!$in_left AND $in_right) //XO
				{
					$needle_ever_found = true;
					echo "<font color=\"red\">X</font>\n";
					echo "<font color=\"green\">0</font><br>\n";
					$insertion_found = str_replace('LEFT_VERSION', $left_version, $messages['insertion_found']);
					echo str_replace('RIGHT_VERSION', $right_version, $insertion_found).': ';;
                    if($binary_search_inverse)
                    {
						//looking for removal
						//was inserted at version "right"
						//removal must have happend afterwards = more right = lower indexes
						
						
                        $first_to_remove = $middle +1;
                        $count = count($versions);
                        echo '<br>' . str_replace('_NUMBEROFVERSIONS_', $count-$first_to_remove, $messages['delete_from_here']).'<br><br>';
                        clear_array_starting_at($versions, $middle+1);
                        echo str_replace('_NUMBEROFVERSIONS_', count($versions), $messages['versions_found']).'<br>';
                        binary_search_from_earliest_index($versions);                       
                        return; //new search started, therefore we don't continue with this one
                    }
				}
				else
				{
					$needle_ever_found = true;
					echo "<font color=\"green\">O</font>\n";
					echo "<font color=\"red\">X</font><br>\n";
					$deletion_found = str_replace('LEFT_VERSION', $left_version, $messages['deletion_found']);
					echo str_replace('RIGHT_VERSION', $right_version, $deletion_found).': ';
                    if(!$binary_search_inverse)
                    {
                        //was inserted before it got deleted
                        clear_array_until_including($versions, $middle+1);//middle+1 might be the inserting revision

                        echo str_replace('_NUMBEROFVERSIONS_', count($versions), $messages['versions_found']).'<br>';
                        binary_search_from_earliest_index($versions);                       
                        return; //new search started, therefore we don't continue with this one
                    }
				}			
				$difflink = get_diff_link($versions[$middle]);
				$end_of_opening_a = strpos($difflink, '>');
				echo substr($difflink, 0, $end_of_opening_a +1) . '<b>' . $messages['here'] . '</b></a>';
				echo "<br>";
                start_over_here($versions[$middle]['offset']);
			}
		}
	}

}
 
function clear_array_starting_at(&$versions, $first_to_remove)
{
    $end = count($versions);
    for($i=$first_to_remove;$i<$end;$i++)
    {
        unset($versions[$i]);
    }
}

function clear_array_until_including(&$versions, $last_to_remove)
{
    global $messages;
    //forget everything later than this version and do re-indexing
    $first_to_remove = 0;
    $end = count($versions)-$last_to_remove;
    echo "<br>";
    echo str_replace('_NUMBEROFVERSIONS_', $last_to_remove-$first_to_remove, $messages['delete_until_here']).'<br><br>';
    for($i=$first_to_remove;$i<$end;$i++)
    {
        $old_index = $last_to_remove+$i;
        $new_index = $i;
        //echo "$old_index => $new_index<br>";
        $versions[$new_index] = $versions[$old_index];
    }                  
    clear_array_starting_at($versions, $end);   
}
function binary_search_from_earliest_index($versions)
{
    $earliest_index = count($versions);
    binary_search(floor($earliest_index/2), $earliest_index-1);
}
 
function get_diff_link($version, $order="prev")
{
	global $server, $articleenc;
    
    $link = 'https://' . $server . '/w/index.php?title=' . $articleenc . '&diff=prev&oldid=' . $version['id'];
    
    return '<a href="' . $link . '">' . $version['local_date'].'</a>';
}

function get_old_link($version)
{
    global $server, $articleenc;
    $link = 'https://' . $server . '/w/index.php?title=' . $articleenc . '&oldid=' . $version['id'];
    return '<a href="' . $link . '">' . $version['local_date'].'</a>';

}

function check_options()
{
	global $skipversions, $limit, $ignorefirst, $messages;
	
	$msg = str_replace('__VERSIONSTOSEARCH__', $limit, $messages['wrong_skips']);
	
	if($skipversions>=$limit)
	{
		$msg = str_replace('__VERSIONSTOSKIP__', $skipversions, $msg);
		echo "<br>";
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
		echo "<br>";
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


function get_url($year, $month, $day, $hours=23, $minutes=55, $include_ignorefirst=true)
{
	global $project, $article, $needle, $lang, $limit, $ignorefirst,$order, $force_wikitags, $user_lang, $binary_search_inverse, $user;
	$url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"]."?project=$project&amp;article=".urlencode($article)."&amp;needle=".urlencode($needle)."&amp;"."lang=$lang&amp;limit=$limit"."&amp;offjahr=$year&amp;offmon=$month&amp;offtag=$day&amp;offhour=$hours&amp;offmin=$minutes&amp;searchmethod=".$_REQUEST['searchmethod']."&amp;order=".$_REQUEST['order']."&amp;force_wikitags=$force_wikitags&amp;user_lang=$user_lang";
	
	if($include_ignorefirst)
	{
		$url.="&amp;ignorefirst=".$_REQUEST['ignorefirst'];
	}
	if($binary_search_inverse)
	{
		$url.="&amp;binary_search_inverse=on";
	}
	if($user != "")
	{
		$url.="&amp;user=".$user;
	}
	return $url;
}

function check_calls_from_this_ip($limit, $ignorefirst, $skipversions)
{
	
	global $messages;
	
	$allowedRevisionsPerPeriod = 300;
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

function Get_UTC_Hours($localHours, $server)
{
	$url = "https://" . $server . "/w/api.php?action=query&meta=siteinfo&format=php";
	ini_set( 'user_agent', 'WikiBlame_by_Flominator' );
	$SiteInfo = unserialize ( curl_request ( $url) ) ;
	$offsetToUtc = $SiteInfo['query']['general']['timeoffset'];
	$UtcHours = $localHours -($offsetToUtc / 60);
	return $UtcHours;
}
?>
 <p align="<?php  echo $alignment ?>"> 
    <!--<a href="http://www.ps-webhosting.de/?ref=k3591" target="_blank"><img alt="Webhosting von ps-webhosting.de" border="0" src="http://www.ps-webhosting.de/banner/ps_button2.gif"></a>-->
	<a href="http://www.ramselehof.de"><img border="0"
        src="ramselehof_powered_feddich.jpg"
        alt="Ramselehof.de"></a>
    <a href="http://validator.w3.org/check?uri=referer"><img border="0"
        src="http://www.w3.org/Icons/valid-html401-blue"
        alt="Valid HTML 4.01 Transitional" height="31" width="88"></a>
  </p>
	</body>
</html>
