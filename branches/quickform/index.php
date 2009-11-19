<?php
// benchmark
$beginning = time();


require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
require_once ROOT.'bootstrap.php';

$needle             = param('needle');
$user               = param('user');
$article            = param('article');
$articleenc         = name_in_url($article);
$lang               = param('lang',         $ui_lang);
$limit              = (int)param('limit',   50);
$project            = param('project',      'wikipedia');
$ignorefirst        = param('ignorefirst',  0);
$skipversions       = param('skipversions', 0);
$ignore_minors      = (param('ignore_minors') == 'on')                      ? TRUE : FALSE;
$use_binary_search  = (param('searchmethod') == 'int')                      ? TRUE : FALSE;
$asc                = ((param('order') == 'asc') AND !$use_binary_search)   ? TRUE : FALSE;


//Offset = YYYYMMDDmmhhss
$offset = param('offjahr');
$offset .= str_pad(param('offmon'), 2, '0', STR_PAD_LEFT);
$offset .= str_pad(param('offtag'), 2, '0', STR_PAD_LEFT);
$offset .= '235500';

if (strlen($offset) < 12) {
    $offset = strftime("%Y%m%d%H%M%S");
}


$the_months[] = $messages['January'];
$the_months[] = $messages['February'];
$the_months[] = $messages['March'];
$the_months[] = $messages['April'];
$the_months[] = $messages['May'];
$the_months[] = $messages['June'];
$the_months[] = $messages['July'];
$the_months[] = $messages['August'];
$the_months[] = $messages['September'];
$the_months[] = $messages['October'];
$the_months[] = $messages['November'];
$the_months[] = $messages['December'];



?>
<?php 
header('Content-Type: text/html; charset=utf-8');
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>WikiBlame</title>
        <link rel="stylesheet" href="wikiblame.css" type="text/css" />
    </head>
<body onload="document.mainform.<?php

//set cursor into needle or article field
if ($article != "") {
    echo "needle";
} else //no article selected
    {
    echo "article";
}
?>.focus();" style="background: #F9F9F9; font-family: arial; font-size: 84%;  direction: <?php echo $text_dir ?>; unicode-bidi: embed">


<?php echo ui_language_list(); ?>
<div align="center">
        <h1>WikiBlame</h1><!-- Design by Elian -->
        <form method="post" name="mainform" action="<?php echo $datei ?>">
        <input type="hidden" name="user_lang" value="<?php echo $ui_lang?>">
            <table style="font-family: arial; font-size: 84%;" cellspacing="5">
                <tr>
                    <td align="<?php echo $alignment ?>">
                        <label for="lang">
                            <?php echo $messages['lang']?>
                        </label>
                    </td>
                    <td>
                        <input type="text" name="lang" id="lang" value="<?php echo $lang; ?>"> (<?php echo $messages['lang_example']; ?>)
                    </td>
                </tr>
                <tr>
                    <td align="<?php echo $alignment ?>">
                        <label for="project">
                            <?php echo $messages['project']?>
                        </label>
                    </td>
                    <td>
                        <input type="text" name="project" id="project" value="<?php echo $project; ?>">  (<?php echo $messages['project_example']; ?>)
                    </td>
                </tr>               
                <tr>
                    <td align="<?php echo $alignment ?>">
                        <label for="article">
                            <?php echo $messages['article'] ?>
                        </label>
                    </td>
                    <td>
                        <input type="text" name="article" id="article" value="<?php echo $article; ?>">
                    </td>
                </tr>
                <tr>
                    <td align="<?php echo $alignment ?>">
                        <label for="needle">
                            <?php echo $messages['needle'] ?>
                        </label>
                    </td>                       
                    <td>
                        <input type="text" name="needle" id="needle" value="<?php echo  htmlspecialchars($needle); ?>"> 
                    </td>
                </tr>
                <tr>
                    <td align="<?php echo $alignment ?>">
                        <label for="skipversions"> 
                            <?php echo $messages['skipversions'] ?>
                        </label>
                    </td>
                    <td>
                        <input type="text" name="skipversions" id="skipversions" value="<?php echo  $skipversions; ?>">
                    </td>
                </tr>               
                <tr>
                    <td align="<?php echo $alignment ?>">
                        <label for="ignorefirst">
                            <?php echo $messages['ignorefirst'] ?>
                        </label>
                    </td>
                    <td>
                        <input type="text" name="ignorefirst" id="ignorefirst" value="<?php echo $ignorefirst; ?>">
                    </td>
                </tr>   
                <tr>
                    <td align="<?php echo $alignment ?>">
                        <label for="limit">
                            <?php echo $messages['limit'] ?>
                        </label>
                    </td>
                    <td>
                        <input type="text" name="limit" id="limit" value="<?php echo $limit; ?>">
                    </td>
                </tr>   
                <tr>
                    <td align="<?php echo $alignment ?>">
                        <?php echo $messages['start_date'].' (DD-MM-YYYY)' ?>
                    </td>
                    <td>
                        <?php datedrop_with_months($messages['start_date'].' (DD-MM-YYYY)', "off", FALSE, 2003, '', param('offjahr'), param('offmon'), param('offtag'), $the_months); ?>
                        
                        <input type="button" value="<?php echo $messages['reset'] ?>" onclick="javascript:var now=new Date();document.forms['mainform'].elements['offtag'].value=now.getDate();document.forms['mainform'].elements['offmon'].value=now.getMonth()+1;document.forms['mainform'].elements['offjahr'].value=now.getFullYear();">
                    </td>
                <tr>
                    <td align="<?php echo $alignment ?>"><?php echo $messages['order'] ?></td>
                    <td>
                        <input type="radio" name="order" id="desc" value="desc" <?php if ($asc!=TRUE) echo checked; ?> >
                        <label for="desc">
                            <?php echo $messages['newest_first'] ?>
                        </label>
                        <input type="radio" name="order" id="asc" value="asc" <?php if ($asc==TRUE) echo checked; ?> >
                        <label for="asc">
                            <?php echo $messages['oldest_first'] ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td align="<?php echo $alignment ?>"><?php echo $messages['search_method'] ?></td>
                    <td>
                        <input type="radio" name="searchmethod" id="linear" value="lin" <?php if ($use_binary_search!=TRUE) echo checked; ?> >
                        <label for="linear">
                            <?php echo $messages['linear'] ?>
                        </label>
                        <input type="radio" name="searchmethod" id="int" value="int" <?php if ($use_binary_search==TRUE) echo checked; ?> >
                        <label for="int">
                        <?php echo $messages['interpolated'] ?>
                        </label>
                    </td>
                </tr>       
                <tr>
                    <td align="<?php echo $alignment ?>">
                        
                        <input type="checkbox" name="ignore_minors" id="ignore_minors" <?php if ($ignore_minors==TRUE) echo checked; ?> >
                    </td>
                    <td>
                        <label for="ignore_minors">
                            <?php echo $messages['ignore_minors'] ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><br><br>
                        <input type="submit" value="<?php echo $messages['start'] ?>" >
                    </td>
                </tr>
            </table>
        </form>
<hr>
<a href='<?php echo $messages['manual_link'] ?>'><?php echo $messages['manual'] ?></a> - 
<a href='<?php echo $messages['contact_link'] ?>'><?php echo $messages['contact'] ?></a> - 
<a href='http://translatewiki.net/wiki/Translating:Wikiblame'><?php echo $messages['help_translating'] ?></a> -
<a href="http://de.wikipedia.org/wiki/Benutzer:Flominator">by Flominator</a>
<br/> <br/>
Do you think WikiBlame's user interface needs improvement? Please post your opinon <a target="_blank" href="https://sourceforge.net/tracker/index.php?func=detail&aid=2811478&group_id=261179&atid=1127548"> at SourceForge</a>.<br/> <br/>
</div>
<?php


if ($needle != "") {
    //$needle = needle_regex($needle); necessary if you work with html, which is currently not the case
    check_options(); // stops script, when wrong options are used

    $tags_present = param('tags_present');
    if ($tags_present == "") {
        $tags_present = wikitags_present();
    }

    if ($lang == "blank") {
        $server = $project . ".org";
    } else {
        $server = $lang . "." . $project . ".org";
    }

    $historyurl = "http://" . $server . "/w/index.php?title=" . $articleenc . "&action=history&limit=$limit&offset=$offset&uselang=$ui_lang";

    //@TODO: create a method from this
    $msg = str_replace('_ARTICLELINK_', "<a href=\"http://" . $server . "/wiki/" . $article . "\">$article</a>", $messages['search_in_progress']);
    $msg = str_replace('_NEEDLE_', $needle, $msg);
    echo "$msg<br>\n";

    //echo $historyurl;
    $history = get_request($server, $historyurl);

    //echo "<hr><pre>$history</pre><hr>";
    $get_version_time = time() - $beginning;
    $versions = listversions($history);
    log_search();

    if (count($versions) > 0) {
        if ($use_binary_search) {
            binary_search(floor(count($versions) / 2), count($versions) - 1);
        } else {
            checkversions($versions);
        }
    }

    $finished = time() - $beginning;
    log_search($finished);
    echo "<br>";
    echo str_replace('_EXECUTIONTIME_', $finished, $messages['execution_time']);

    echo '<br /><br /><small>http://' . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"] . "?project=$project&article=" . urlencode($article) . "&needle=" . urlencode($needle) . "&" . "l<!----->ang=$lang&limit=$limit&ignorefirst=$ignorefirst&offjahr=$offjahr&offmon=$offmon&offtag=$offtag&searchmethod=$searchmethod&order=$order</small>";

}

//takes the requested history page, extracts links to the revisions and puts them into an array that is returned
function listversions($history) {
    global $articleenc, $asc, $messages, $ignore_minors;
    $searchterm = "name=\"diff\" "; //assumes that the history begins at the first occurrence of name="diff" />  <!--removed />-->

    $versionen = array (); //array to store the links in

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
    </li>   */

    //iterate over the parts 
    for ($block_i = 1; $block_i < count($revision_html_blocks); $block_i++) {
        //find the beginning of the a tag
        $start_pos_of_a = strpos($revision_html_blocks[$block_i], "<a");

        //find the closing sequence of the a tag
        $pos_of_closed_a = strpos($revision_html_blocks[$block_i], "</a>");

        $length_between_both = $pos_of_closed_a - $start_pos_of_a;

        //extract the link from the current part like this one:
        $one_version = substr($revision_html_blocks[$block_i], $start_pos_of_a, $length_between_both);

        //result: <a href="/w/index.php?title=Hinterzarten&amp;oldid=64569839" title="Hinterzarten">11:27, 16. Sep. 2009

        if ($ignore_minors) {
            //checks if the revision was marked as minor edit
            if (!stristr($one_version_link, "<span class=\"minor\">")) {
                $versions[] = $one_version;
            } else {
                //echo "ignored a minor change";
            }
        } else {
            $versions[] = $one_version;
        }
    }

    if ($asc == TRUE) {
        echo "reversing the list";
        $versions = array_reverse($versions);
    }

    echo str_replace('_NUMBEROFVERSIONS_', count($versions), $messages['versions_found']) . '<br>';
    return $versions;

    //regular expression that could be used to extract data from the revision links somewhen
    //!oldid=(\d+)".*>([^<]+)</a>.*>([^<]+)</a>! 1=date, 2=revid 3=user
}

function checkversions($versions) {
    global $server, $skipversions, $ignorefirst;

    $version_counter = 0;
    echo "<ul>";
    foreach ($versions as $version) {
        echo "<li>" . str_replace("/w/", "http://" . $server . "/w/", $version) . "</a> ";

        if ($ignorefirst == 0) {
            if ($version_counter == 0) {
                if (needleinversion(idfromurl($version))) {
                    echo " <font color=\"green\">OOO</font>\n";
                } else {
                    echo " <font color=\"red\">XXX</font>\n";
                }
                $version_counter = $skipversions;
            } else {
                echo " <font color=\"blue\">???</font>\n";
                $version_counter--;
            }
        } else {
            echo " <font color=\"blue\">???</font>\n";
            $ignorefirst--;
        }
        echo "</li>\n";
    }
    echo "</ul>";
}

function idfromurl($url) {
    $pos = strpos($url, "oldid=");
    $endpos = strpos($url, "\"", $pos +6);
    $id = substr($url, $pos +6, $endpos - ($pos +6));
    return $id;
}

function needleinversion($id) {
    set_time_limit(60);
    global $needle, $server, $articleenc, $tags_present;
    $url = "http://" . $server . "/w/index.php?title=" . $articleenc . "&oldid=" . $id;

    if ($tags_present) {
        $versionpage = get_request($server, $url . "&action=raw");
    } else {
        //remove the html tags (not included above because of <ref> and others)
        $versionpage = strip_tags(get_request($server, $url));
    }

    /*
        //php replacement for command line
        $url = str_replace("&", "\&", $url); 
        if(shell_exec("/usr/bin/wget --quiet -O - $url| /bin/grep \"$needle\"")!="")
    */

    if (stristr($versionpage, $needle)) {
        return (TRUE);
    } else {
        return (FALSE);
    }

}

function log_search($time = "started") {
    global $article, $needle, $lang, $project, $asc, $use_binary_search, $server, $limit, $skipversions, $get_version_time, $versions, $offset, $user, $ui_lang;
    $logfile = LOGFILE;

    if (!file_exists($logfile)) {
        $header = "Day;";
        $header .= "Time;";
        $header .= "IP (Client);";
        $header .= "UI Language;";
        $header .= "Needle;";
        $header .= "Article;";
        $header .= "Language;";
        $header .= "Project;";
        $header .= "Offset;";
        $header .= "Wanted Versions;";
        $header .= "Found Versions;";
        $header .= "Skipped Versions;";
        $header .= "Linear/Interpolated;";
        $header .= "Execution-Time;";
        $header .= "Get-Version-Time;";
        $header .= "Referer\n";

    }

    if ($file = fopen($logfile, "a")) {
        fputs($file, $header);
        fputs($file, strftime("%Y-%m-%d") . ";");
        fputs($file, strftime("%H:%M") . ";");
        fputs($file, "\"" . $_SERVER['REMOTE_ADDR'] . "\";");
        fputs($file, $ui_lang . ";");
        fputs($file, "\"" . $needle . "\";");
        fputs($file, "\"" . $article . "\";");
        fputs($file, $lang . ";");
        fputs($file, $project . ";");
        fputs($file, "'$offset;");
        fputs($file, $limit . ";");
        fputs($file, count($versions) . ";");
        fputs($file, $skipversions . ";");

        if ($use_binary_search) {
            fputs($file, "interpolated;");
        } else {
            fputs($file, "linear;");
        }

        fputs($file, $time . ";");
        fputs($file, $get_version_time . ";");
        fputs($file, $_SERVER['HTTP_REFERER'] . ";\n");
        fclose($file);
    }

}

//translates wiki syntax to html
function needle_regex($needle) {
    $needle = preg_replace('#\'\'\'(.*)\'\'\'#is', '<b>$1</b>', $needle); //bold
    $needle = preg_replace('#\'\'(.*)\'\'#is', '<i>$1</i>', $needle); //italic
    $needle = str_replace('[[', '<a.*>', $needle); //link
    $needle = str_replace(']]', '</a>', $needle); //end of link
    $needle = preg_replace('#\n\*([^\n\r]*)#is', '<li>$1</li>', $needle); //list items
    return ($needle);
}

function binary_search($middle, $from) {
    global $needle, $versions, $server, $messages;

    if ($middle < 1) {
        die($messages['first_version']);
    }

    if ($middle == $from) {
        die($messages['no_differences']);
    }

    //echo "Checking differences between ".get_diff_link($middle)." between $middle and ". ($middle+1)." starting from $from : ";
    //echo $messages['search_in_progress'];

    $test_msg = str_replace('_FIRSTDATEVERSION_', get_diff_link($middle), $messages['binary_test']);
    $test_msg = str_replace('_FIRSTNUMBER_', $middle, $test_msg);
    $test_msg = str_replace('_SECONDNUMBER_', $middle +1, $test_msg);
    $test_msg = str_replace('_SOURCENUMBER_', $from, $test_msg);
    echo $test_msg;

    $in_this = needleinversion(idfromurl($versions[$middle]));
    $in_next = needleinversion(idfromurl($versions[$middle +1]));
    if ($in_this AND $in_next) {
        echo "<font color=\"green\">OO</font><br>\n";
        binary_search(floor($middle +abs(($from - $middle) / 2)), $middle);
    } else {
        if (!$in_this AND !$in_next) {
            echo "<font color=\"red\">XX</font><br>\n";
            binary_search(floor($middle -abs(($from - $middle) / 2)), $middle);
        } else {
            $left_version = str_replace("/w/", "http://" . $server . "/w/", $versions[$middle +1]) . "</a> ";
            $right_version = str_replace("/w/", "http://" . $server . "/w/", $versions[$middle]) . "</a>";
            if ($in_this AND !$in_next) {
                echo "<font color=\"red\">X</font>\n";
                echo "<font color=\"green\">0</font><br>\n";
                $insertion_found = str_replace('LEFT_VERSION', $left_version, $messages['insertion_found']);
                echo str_replace('RIGHT_VERSION', $right_version, $insertion_found);
            } else {
                echo "<font color=\"green\">O</font>\n";
                echo "<font color=\"red\">X</font><br>\n";
                $deletion_found = str_replace('LEFT_VERSION', $left_version, $messages['deletion_found']);
                echo str_replace('RIGHT_VERSION', $right_version, $deletion_found);
            }
            echo "<br>";

        }
    }

}

function get_diff_link($index, $order = "prev") {
    global $versions, $server;

    $versionslink = str_replace("/w/", "http://" . $server . "/w/", $versions[$index]) . "</a>";
    $versionslink = str_replace("oldid", "diff=" . $order . "&oldid", $versionslink);
    return ($versionslink);
}

function wikitags_present() {
    global $needle;
    $tag_elements = array (
        '[',
        ']',
        '{',
        '}',
        '*',
        '#',
        '==',
        "''",
        '<',
        '>',
        '|',
        '__'
    );

    foreach ($tag_elements as $tag_element) {
        if (stristr($needle, $tag_element)) {
            return TRUE;
            break;
        }
    }

    return FALSE;
}

function check_options() {
    global $skipversions, $limit, $ignorefirst, $messages;

    $msg = str_replace('__VERSIONSTOSEARCH__', $limit, $messages['wrong_skips']);

    if ($skipversions >= $limit) {
        $msg = str_replace('__VERSIONSTOSKIP__', $skipversions, $msg);
        echo "<br />";
        echo "<script>\n";
        echo "document.getElementById('skipversions').focus();\n";
        echo "document.getElementById('skipversions').select();\n";
        echo "</script>";
        echo $msg;
        die();
    }

    if ($ignorefirst >= $limit) {
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

function print_translator($lang) {
    global $messages;
    if ($messages['translator'] != "") {
        echo "& <a href=\"" . $messages['translator_link'] . "\">$messages[translator]</a> (translation)";
    }
}
?>
 <p align="<?php echo $alignment ?>"> 
    <a href="http://validator.w3.org/check?uri=referer"><img border="0"
        src="http://www.w3.org/Icons/valid-html401-blue"
        alt="Valid HTML 4.01 Transitional" height="31" width="88"></a>
  </p>
    </body>
</html>