<?header('Content-Type: text/html; charset=utf-8'); 
  
require_once("shared_inc/wiki_functions.inc.php");
$comment_choices = array("keine", "Text eingeben", "Diskussionsseite", "Doppelbewertung wünschen", "an A-Schiri weitergeben");

$forwardText = "Weitergabe an A-Schiri";
?><!-- checks the similarity of two revisions and helps to rate articles and maintenance template contest, called by http://de.wikipedia.org/wiki/Benutzer:Flominator/WaWeWeWi.js -->
<html>
 <head>
 <title><? echo $article?></title>
 </head>
 <body><h2>Willkommen beim wirklich wundervollen webbasierten Wartungsbaustein-Wegmach-Wertungs-Wizzard</h2>
<script>
function SetComment(selectedComment)
{
	var commentBox = document.getElementById('commentText');
	commentBox.value = "";
	switch (selectedComment)
	{
	  case "<?echo $comment_choices[1]?>": //enter text
	  { 
		commentBox.readOnly = false;
		break;
	  }
	  case "<?echo $comment_choices[2]?>": //talk page
	  { 
		commentBox.readOnly = true;
		commentBox.value = "[[Wikipedia Diskussion:WBWA#<? echo $articleenc; ?>]]";
		break;
	  }
	  case "<?echo $comment_choices[3]?>":
	  { 
		commentBox.readOnly = true;
		commentBox.value = "Doppelbewertung erwünscht";
		break;
	  }
	  case "<?echo $comment_choices[4]?>":
	  { 
		commentBox.readOnly = false;
		commentBox.value = "<?echo $forwardText ?>";
		break;
	  }
	  default: //"keine"
	  {
		commentBox.readOnly = true;
		break;
	  }
    }
}
</script>
<?

$src_old_cut = $_REQUEST['old_cut'];
$src_new_cut = $_REQUEST['new_cut'];
echo "<!--". strlen($src_old_cut )." -->";;

$template_names = array("Überarbeiten", "Belege fehlen", "Lückenhaft", "Neutralität","NurListe", "Unverständlich", "Defekte Weblinks", "Geographische Lage gewünscht", "Veraltet", "Widerspruch", "Internationalisierung (Deutschlandlastig, Österreichlastig, Schweizlastig)", "(Portal-)Qualitätssicherung", "Redundanz", "Gemeinfreie Quellen (Meyers, Pierer-1857, Brockhaus, ...)", "Bilderwunsch", "Überbildert", "Fachbereichs-Wartungsliste");
$template_shortcuts = array("ü", "q", "lü", "pov", "nl", "uv", "dw", "geo", "alt", "ws", "inter", "qs", "red", "gq", "bw", "übb", "fwl");
$rater = $_REQUEST['rater'];
$server= $lang.".".$project.".org";

$oldid = getint('oldid');
$diff = getint('diff');

order_old_and_diff(&$oldid, &$diff);

$difflink = "http://$lang.$project.org/w/index.php?title=$articleenc&diff=$diff&oldid=$oldid";
$afterlink = "http://$lang.$project.org/w/index.php?title=$articleenc&oldid=$diff";
$beforelink= "http://$lang.$project.org/w/index.php?title=$articleenc&oldid=$oldid";
echo "[<a href=\"$beforelink\">vorher</a>]&nbsp;";
echo "[<a href=\"$difflink\">Diff-Link</a>]&nbsp;";
echo "[<a href=\"$afterlink\">nachher</a>]&nbsp;";
echo "<br>";

if($src_old_cut=="")
{
	ask_to_cut_org($oldid, $diff);
}
else
{
	$src_old = remove_textarea_overhead($src_old_cut);
	//compare_old_from_form_with_original($src_old, $oldid, $article);
	//$src_new = removeheaders(get_source_code($article, $diff));
	$src_new = remove_textarea_overhead($src_new_cut);
	
	$len_old = strlen($src_old);
	$len_new = strlen($src_new);

	$len_diff = $len_new - $len_old;
	$virtualFactor = 1;

	//similar_text($src_old , $src_new , $percent_case_sensitive);

	$similarity = get_similarity($src_old, $src_new);
	$changedPercentDecimal = ((100 - $similarity) / 100);
	$changeSummand = ($len_new  / 1000) * $changedPercentDecimal;
	$additionSummand  = 0;
	

	$v = "";
	if($len_diff > 20)
	{
		$v=$len_old;
		$additionSummand  = $len_diff  / 300;
	}

	$nodiff = "";
	$removalSummand = 0;
	if($v=="")
	{
		$nodiff= "|nodiff=x";
		$removalSummand = ($len_new / 500) * $changedPercentDecimal;
	}
	
	$template = $_REQUEST['template']-1;
	$virt = "";
	if($template_shortcuts[$template]=="virt")
	{
		$virtualFactor = 2;
		$virt = "|virt=x";
	}
	
	$quality = getint('percent_quality');
	$qualityFactor = 1;
	$ql = "";
	if($quality!=100)
	{
		$qualityFactor = $quality/100;
		$ql = "|ql=" .$qualityFactor ;
	}
	
	$comments = $_REQUEST['commentText'];
	$anm = "";
	$wasForwarded = stristr($comments, $forwardText);

	$freeSummand = get_additional_points();
	
	$expectedPointResult = (($changeSummand + $additionSummand + $removalSummand + $freeSummand) / $virtualFactor) * $qualityFactor;
		
	echo "Ähnlichkeit ohne Groß- und Kleinschreibung: " . $similarity  ."&nbsp;%\n<br>";
	echo "Differenz: " . $len_diff . " Bytes<br>";
	echo "zu erwartende Punktzahl: ". round($expectedPointResult,1 ); 
	
	if($comments !="")
	{
		if($wasForwarded) //a referee should rate this one
		{
			$v="0";
			$len_new="0";
			$similarity="";
			$freeSummand="";
			$nodiff="";
			$virt="";
			$ql="";
		}
		$anm = "|anm=" . $comments;
		
	}
	
	
	echo "<textarea cols=\"150\">{{WBWB|wb=".$template_shortcuts[$template]."|v=$v|n=$len_new|ä=".$similarity."|frei=".$freeSummand."|sr=$rater". $nodiff.$virt.$ql.$anm."}}</textarea>";
	

}

function getint($field)
{
	return $_REQUEST[$field]+1-1;
}

function get_additional_points()
{
	$add = 0;
	$add+= getint('num_sources') * 0.5;
	$add+=degressive_rating(getint('num_coord'));
	$add+=degressive_rating(getint('num_dw'));
	$add+=image_rating(getint('num_upload'));
	return $add;
}

function image_rating($num_cases)
{
	$points_return = 0.0;
	switch($num_cases)
	{
		case "":
		case "0":
		{
			break;
		}
		case "1":
		{
			$points_return+=  4;
			break;
		}
		case "2":
		{
			$points_return+=  7;
			break;
		}
		case "3":
		{
			$points_return+=  9;
			break;
		}
		default:
		{
			$points_return+= 9;
			$points_return+= ($num_cases-3); 
			break;
		}
	}
	return $points_return;
}


function degressive_rating($num_cases)
{
	$first_improvement = 0.4;
	$every_other_improvement = 0.15;
	$points_return = 0.0;
	switch($num_cases)
	{
		case "":
		case "0":
		{
			break;
		}
		case "1":
		{
			$points_return+=  $first_improvement;
			break;
		}
		default:
		{
			$points_return+= $first_improvement;
			$points_return+= ($every_other_improvement) * ($num_cases-1); 
			break;
		}
	}
	return $points_return;
}


function get_similarity($src_old, $src_new)
{
	similar_text(strtolower($src_old), strtolower($src_new) , $percent_case_insensitive);
	return sprintf("%01.2f",$percent_case_insensitive);
}

function compare_old_from_form_with_original($src_old, $oldid, $article)
{
	$src_old_reload = removeheaders(get_source_code($article, $oldid));
	echo "old form: " . strlen($src_old) . "reloaded: " . strlen($src_old_reload);

	$hex_src = hex_chars($src_old);
	$hex_src_reload = hex_chars($src_old_reload);

	$hex_src_hex_ex = explode("|{", $hex_src['hex']);
	$hex_src_reloaded_hex_ex = explode("|{", $hex_src_reload['hex']);
	
	$hex_src_chr_ex = explode("|{", $hex_src['chars']);
	$hex_src_reloaded_chr_ex = explode("|{", $hex_src_reload['chars']);
	
	echo "<pre>";
	
	for($i=0;$i<count($hex_src_chr_ex);$i++)
	{
		if($hex_src_chr_ex[$i] != $hex_src_reloaded_chr_ex[$i])
		{
			echo "<b>";
		}
		echo "#".$i."   ".$hex_src_chr_ex[$i] . "(" . $hex_src_hex_ex[$i] . ")";
		echo        "   ".$hex_src_reloaded_chr_ex[$i] . "(" . $hex_src_reloaded_hex_ex[$i] . ")<br>\n";
	}
	echo "</pre>";

	echo "<h1>old</h1> $src_old ";
	echo "<h1>old reloaded</h1> $hex_src_reload";
}

function order_old_and_diff($oldid, $diff)
{
	if($diff<$oldid )
	{
		$tempId = $diff;
		$diff = $oldid;
		$oldid = $tempId;
	}
}

function remove_textarea_overhead($text)
{
	$text = preg_replace('(\r\n|\r|\n)',chr(10),$text);
	$text = stripslashes($text);
	return $text;
}
function ask_to_cut_org($oldid, $diff)
{
	global $src_old, $article, $diff, $lang, $project, $template_names, $rater, $comment_choices, $server, $forwardText;
	$this_url = "article=$article&oldid=$oldid&diff=$diff&rater=$rater&project=$project&lang=$lang";
	$src_old = removeheaders(get_source_code($article, $oldid));
	$src_new = removeheaders(get_source_code($article, $diff));
	$other_remove_link = "Falls viel an Tabellen geändert wurde, willst du vielleicht <a href=\"?article=$article&oldid=$oldid&diff=$diff&rater=$rater&project=$project&lang=$lang&remove_table=true\">kosmetische Tabellensyntax entfernen</a>";
	if($_REQUEST['remove_table']=="true")
	{
		$src_old = remove_table_attributes($src_old);
		$src_new = remove_table_attributes($src_new);
		$other_remove_link = "Tabellensyntax wurde entfernt. Willst du sie vielleicht doch <a href=\"?$this_url&remove_table=false\">wieder einfügen</a>?";
	}
	if(max(strlen($src_old), strlen($src_new))>110000 )
	{
		echo "<br><br>Mindestens eine der beiden Versionen ist zu lang, um sie per WaWeWeWi auswerten zu lassen. 
		Bitte <a href=\"?$this_url&old_cut=empty&commentText=$forwardText".urlencode(" - zu lang")."\">gib sie an den A-Schiri weiter</a>.";
	}
	else
	{
		echo "<form method=\"post\"   enctype=\"multipart/form-data\">
		Entferne zunächst eventuelle Wartungsbausteine aus dieser mangelhaften Version:<br />
		
		<textarea id=\"old_cut\" name=\"old_cut\" cols=\"80\" rows=\"25\">".($src_old)."</textarea><br/>"
		. "<a href='#' onclick=\"javascript:document.getElementById('new_cut').style['display']='block'\">Hier klicken, um die verbesserte Version zu bearbeiten, um z.B. Nichtteilnehmer-Beiträge zu entfernen&nbsp;</a><br><br>" 
		."<textarea style=\"display: none;\" id=\"new_cut\" name=\"new_cut\" cols=\"80\" rows=\"25\">".($src_new)."</textarea><br/>
		
		<!-- <input name=\"old_cut\" value=\"".htmlentities($src_old)."\">-->
		<input type=\"hidden\" name=\"diff\" value=\"$diff\">
		<input type=\"hidden\" name=\"article\" value=\"$article\">
		<input type=\"hidden\" name=\"lang\" value=\"$lang\">
		<input type=\"hidden\" name=\"project\" value=\"$project\">
		<input type=\"hidden\" name=\"oldid\" value=\"$oldid\">"
		. "<label for=\"template\">Wartungsbaustein&nbsp;</label>" .	 array_drop ("template",  $template_names) ."<br>"
		. "<label for=\"num_sources\">Anzahl verschiedene Belege&nbsp;</label>" 
		. "<input name=\"num_sources\" id=\"num_sources\"><br>" 
		. "<label for=\"num_dw\">Anzahl reparierter Weblinks&nbsp;</label>" 
		. "<input name=\"num_dw\" id=\"num_dw\"><br>" 
		. "<label for=\"num_upload\">Anzahl neu hochgeladener Bilder&nbsp;</label>" 
		. "<input name=\"num_upload\" id=\"num_upload\"><br>" 
		. "<label for=\"num_coord\">Anzahl hinzugefügter Koordinaten&nbsp;</label>" 
		. "<input name=\"num_coord\" id=\"num_coord\"><br>" 
		. "<label for=\"percent_quality\">Korrekturfaktor (in Prozent)&nbsp;</label>" 
		. "<input name=\"percent_quality\" id=\"percent_quality\" value=\"100\"><br>" 
		. "$other_remove_link <br />"
		. "<label for=\"comment\">Anmerkung&nbsp;</label>" .	 array_drop ("comment", $comment_choices, "", "", "SetComment(this.options[this.selectedIndex].text)", $comment_choices[0]) ."<br>"
		. "<input name=\"commentText\"  id=\"commentText\" readonly size=\"100\"><br>" 
		. "<label for=\"rater\">Schiedsrichter&nbsp;</label><br>"	
		. "<input name=\"rater\"  id=\"rater\" value=\"$rater\"><br>"
		."<input type=\"submit\" value=\"Auswerten\"></form>";
	}
}

function hex_chars($data) {
    $mb_chars = '';
    $mb_hex = '';
    for ($i=0; $i<mb_strlen($data, 'UTF-8'); $i++) {
        $c = mb_substr($data, $i, 1, 'UTF-8');
        $mb_chars .= '{'. ($c). '}';
       
        $o = unpack('N', mb_convert_encoding($c, 'UCS-4BE', 'UTF-8'));
        $mb_hex .= '{'. hex_format($o[1]). '}';
    }
    $chars = '';
    $hex = '';
    for ($i=0; $i<strlen($data); $i++) {
        $c = substr($data, $i, 1);
        $chars .= '|{'. ($c). '}';
        $hex .= '|{'. hex_format(ord($c)). '}';
    }
    return array(
        'data' => $data,
        'chars' => $chars,
        'hex' => $hex,
        'mb_chars' => $mb_chars,
        'mb_hex' => $mb_hex,
    );
}
function hex_format($o) {
    $h = strtoupper(dechex($o));
    $len = strlen($h);
    if ($len % 2 == 1)
        $h = "0$h";
    return $h;
}
function get_source_code($article, $rev)
{
	$articleenc = name_in_url($article);
	global $server;
	$url = "http://".$server."/w/index.php?title=".$articleenc."&action=raw&oldid=$rev";
	//echo $url;
	
	//echo "<br><br>Suche nach $needle in $article";
	if(!$article_text = get_request($server, $url))
	{
		//echo "error";
		die("klappt nicht");
	}
	return $article_text;
}

function remove_table_attributes($src_text)
{
	$table_parts = explode("|", str_replace("\n!", "\n|", $src_text));
	$table_syntax = array("style=", "class=", "width=", "height=", "align=", "bgcolor=", "rowspan=", "colspan=", "valign=");
	$syntax_terminators = array("\n");
	
	for($i=0;$i<count($table_parts);$i++)
	{
		foreach($table_syntax as $one_syntax_word)
		{
			if(stristr(strtolower($table_parts[$i]), $one_syntax_word))
			{
				$table_parts[$i] = "";
			}
		}
	}
	return join("|",$table_parts); 
}

?>
</body>
</html>