<?header('Content-Type: text/html; charset=utf-8');  ?>
<h1>Zwischenstände</h1>
<?
//shows the entries from zukunft that have been removed
include("shared_inc/wiki_functions.inc.php");

//$article = "Benutzer:Flominator/Zukunft";

$edition = $_REQUEST['edition'];
$article = "Wikipedia:Wartungsbausteinwettbewerb/".name_in_url($edition);
$lang = "de";
$project = "wikipedia";
$server = "$lang.$project.org";
$is_debug = ($_REQUEST['debug']=="on" || $_REQUEST['debug']=="true" );

$wbw_page = "http://".$server."/w/index.php?title=$article";
$html_page = get_request($server, $wbw_page, true );

$revision_prefix = "\"wgCurRevisionId\":";
$index_of_revision_id = strpos($html_page, $revision_prefix );
$end_of_revision_id = strpos($html_page, ",", $index_of_revision_id);

$oldid = substr($html_page, $index_of_revision_id + strlen($revision_prefix ), $end_of_revision_id -$index_of_revision_id - strlen($revision_prefix ) );


$team_paragraphs = explode("h6>", $html_page);

$points_per_team;//[] = array("Team"=> "Dummy", "Points"=>"-1");

for($iTeam = 1;$iTeam<count($team_paragraphs);$iTeam++)
{
	//team name
	$team_name = str_replace("[Bearbeiten]", "", strip_tags($team_paragraphs[$iTeam]));
	
	$iTeam++;
	$points_of_this_team = 0;
	$list_of_article_points = explode("(", $team_paragraphs[$iTeam]);
	
	//user names
	$iEndOfFirstColumn = strpos($list_of_article_points[0], "</td>");
	$allUserNames = substr($list_of_article_points[0], 0, $iEndOfFirstColumn);
	$userLines = explode("<li><a href", $allUserNames);
	$numberOfTeamMembers = 0;
	foreach($userLines as $oneUserLine)
	{
		//echo "line is $oneUserLine";
		if(stristr($oneUserLine, "Benutzer"))
		{
			$numberOfTeamMembers++;
		}
	}
	//echo $allUserNames . " has members: $numberOfTeamMembers";
	
	//points
	foreach($list_of_article_points as $one_rated_article)
	{
		//echo "<hr>";
		//echo "UU". $one_rated_article ."UU\"</a>";
		$indexFirstPipe = strpos($one_rated_article, "|");
		if($indexFirstPipe > 0)
		{
			$indexFirstPipe++;
			$indexNextPipe = strpos($one_rated_article, "|", $indexFirstPipe);
			if($indexNextPipe >= 0)
			{
				//echo "first:" . $indexFirstPipe . " next: " . $indexNextPipe;
				$fPoints = substr($one_rated_article, $indexFirstPipe, $indexNextPipe-$indexFirstPipe);
				//echo "points: ". $fPoints;
				$points_of_this_team = $points_of_this_team+$fPoints;
			}
		}
	}
	$totalPointsOfThisTeam = $points_of_this_team;
	if($numberOfTeamMembers>3)
	{
		$points_of_this_team = 3* ($points_of_this_team / $numberOfTeamMembers);
	}
	$points_per_team[] = array("Team" => $team_name, "Points" => $points_of_this_team, "NumberMembers" => $numberOfTeamMembers, "TotalPoints" => $totalPointsOfThisTeam);
	//echo "Team:" . $team_name . "Points:" . $points_of_this_team;
	//echo $points_per_team[count($points_per_team)-1]["Team"]."//".$points_per_team[count($points_per_team)-1]["Points"];
}

foreach ($points_per_team as $nr => $inhalt)
{
	$points[$nr]  = strtolower( $inhalt['Points'] );
}

array_multisort($points, SORT_DESC, $points_per_team);

//print_r (  $points_per_team );

echo "<ol>";
for($i=0;$i<count($points_per_team);$i++)
{
	echo "<li>" . $points_per_team[$i]["Team"].":".$points_per_team[$i]["Points"]."</li>";
}
echo "</ol>";


$wbw_page_raw = $wbw_page. "&action=raw";
$source_code_page = removeheaders(get_request($server, $wbw_page_raw, true )); 

$paragraphs = explode("\n======", $source_code_page);

for($iParagraph=0;$iParagraph<count($paragraphs );$iParagraph++)
{
	if($is_debug) echo "<h1>Para $iParagraph before</h1>".htmlspecialchars($paragraphs[$iParagraph])."<hr>";

	for($i=0;$i<count($points_per_team);$i++)
	{
		$i_team_length = strlen($points_per_team[$i]["Team"]);
		if(substr($paragraphs[$iParagraph], 0, $i_team_length)==$points_per_team[$i]["Team"])
		{
			$paragraphs[$iParagraph] = update_one_team_paragraph($paragraphs[$iParagraph], $points_per_team[$i]);
			$i = count($points_per_team);
		}
	}
	if($is_debug) echo "<h1>Para $iParagraph after</h1>".htmlspecialchars($paragraphs[$iParagraph])." <hr>";
}

print_form($wbw_page, $paragraphs);
//echo "<a href=\"". $wbw_page . "&action=edit&summary=Zwischenstände aktualisiert\">bearbeiten</a><br>";

function print_form($wbw_page, $paragraphs)
{
	echo '<form method="post" action="'.$wbw_page.'&action=submit">';
	echo '<input type="submit" value="Update"/><br>';
	echo '<input type="hidden" name="wpSummary" value="Zwischenstände aktualisiert"/>';
	echo '<input type="hidden" name="wpDiff" value="Zwischenstände aktualisiert"/>';
	$time_on_wm_server = time() - 7*60*60 ; //change according to http://www.zeitzonen.de/central_standard_time_cst_-_usa.html
	echo '<input type="hidden" name="wpStarttime" value="'. strftime("%Y%m%d%H%M%S", $time_on_wm_server). '" />';
	echo '<input type="hidden" name="wpEdittime" value="" />';
	
	if(!$is_debug) $style="style=\"display: none;\"";
	echo "<textarea name=\"wpTextbox1\" cols=\"80\" rows=\"25\" $style >" . implode($paragraphs, "\n======"). "</textarea><br>";
	echo '</form>';
}

function update_one_team_paragraph($one_paragraph, $point_set_this_team)
{
	global $article, $oldid, $is_debug;

	$result_template_name = "Wikipedia:Wartungsbausteinwettbewerb/Vorlage Ergebnis";
	$end_of_template = strrpos($one_paragraph, "-"); //= end of the table rw

	$is_last_row = false;
	$end_of_wbw_table = "{{Wikipedia:Wartungsbausteinwettbewerb/Vorlage|Ende der Wettbewerbstabelle=x}}" ;
	$offset = 0;
	if(stristr($one_paragraph, $end_of_wbw_table))
	{
		if($is_debug) echo "ende gefunden";
		$end_of_template =  strpos($one_paragraph, $end_of_wbw_table);
		if($is_debug) echo "end_of_template=$end_of_template";
		$is_last_row = true;
		//echo "len of end:". strlen($end_of_wbw_table);
	}
	
	$beginning_of_template = $end_of_template;
	
	if(stristr($one_paragraph, $result_template_name))
	{
		if($is_debug) echo "vorlage gefunden";
		$template_until_end = substr($one_paragraph, 0, $end_of_template);
		$beginning_of_template = strrpos($template_until_end, "{");
		if($is_last_row )
		{
			//stuff between end of template and end of table
			$end_of_template = strpos($one_paragraph, "}", $beginning_of_template)+3;
		}
		//echo "beginning_of_template=$beginning_of_template";
	}
		
	$text_before = substr($one_paragraph, 0, $beginning_of_template-1);
	$text_after = substr($one_paragraph, $end_of_template-1);
	
	$text_to_insert = "{{Wikipedia:Wartungsbausteinwettbewerb/Vorlage Ergebnis\n|Anker=".sprintf("%04d",ceil($point_set_this_team["Points"]))."|Zwischenergebnis=[http://de.wikipedia.org/w/index.php?title=".str_replace(" ", "_", $article)."&oldid=$oldid ". strftime("%d.%m.")."]|" . GetResultParameter($point_set_this_team) ."}}\n";
	
	return  $text_before .   $text_to_insert .  $text_after;
}

function GetResultParameter($point_set_this_team)
{
	$points_of_this_team =  $point_set_this_team["Points"];
	$result_param = "Ergebnis=$points_of_this_team";
	
	if($point_set_this_team["NumberMembers"] >= 4)
	{
		$result_param = "Rechnung+Ergebnis=<math>3\cdot \frac{". $point_set_this_team["TotalPoints"] ."}{". $point_set_this_team["NumberMembers"]."}=".sprintf("%0.1f", $points_of_this_team)."</math>";
	}
	return $result_param;
}
?>