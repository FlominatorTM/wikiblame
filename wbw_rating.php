<?header('Content-Type: text/html; charset=utf-8');  ?>
<?
//shows the entries from zukunft that have been removed
include("shared_inc/wiki_functions.inc.php");

//$article = "Benutzer:Flominator/Zukunft";

$edition = $_REQUEST['edition'];
$article = "Wikipedia:Wartungsbausteinwettbewerb/$edition";
$lang = "de";
$project = "wikipedia";
$server = "$lang.$project.org";


$wbw_page = 'http://'.$server.'/wiki/'. name_in_url($article);
//echo $wbw_page;
$html_page = get_request($server, $wbw_page, true );

$revision_prefix = "\"wgCurRevisionId\":";
$index_of_revision_id = strpos($html_page, $revision_prefix );
$end_of_revision_id = strpos($html_page, ",", $index_of_revision_id);

$oldid = substr($html_page, $index_of_revision_id + strlen($revision_prefix ), $end_of_revision_id -$index_of_revision_id - strlen($revision_prefix ) );


$team_paragraphs = explode("h6>", $html_page);

$points_per_team;//[] = array("Team"=> "Dummy", "Points"=>"-1");

for($iTeam = 1;$iTeam<count($team_paragraphs);$iTeam++)
{
	//echo "<hr>";
	//team name
	$team_name = str_replace("[Bearbeiten]", "", strip_tags($team_paragraphs[$iTeam]));
	//$points_per_team[0]["Points"] = 
	//echo "<h1>$team_name</h1>";
	
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


$wbw_page_raw = "http://".$server."/w/index.php?action=raw&title=".name_in_url($article);
$source_code_page = removeheaders(get_request($server, $wbw_page_raw, true )); 

$paragraphs = explode("\n======", $source_code_page);

for($iParagraph=0;$iParagraph<count($paragraphs );$iParagraph++)
{
	echo "<h1>Para $iParagraph before</h1>".htmlspecialchars($paragraphs[$iParagraph])."<hr>";

	for($i=0;$i<count($points_per_team);$i++)
	{
		$i_team_length = strlen($points_per_team[$i]["Team"]);
		if(substr($paragraphs[$iParagraph], 0, $i_team_length)==$points_per_team[$i]["Team"])
		{
			$paragraphs[$iParagraph] = update_one_team_paragraph($paragraphs[$iParagraph], $points_per_team[$i]);
			$i = count($points_per_team);
		}
	}
	echo "<h1>Para $iParagraph after</h1>".htmlspecialchars($paragraphs[$iParagraph])." <hr>";
}

echo "<h1>Zwischenstände</h1>";
echo "<textarea cols=\"80\" rows=\"25\">" . implode($paragraphs, "\n======"). "</textarea>";

function update_one_team_paragraph($one_paragraph, $point_set_this_team)
{
	global $article, $oldid;
	echo "count ".count($point_set_this_team);

	$result_template_name = "Wikipedia:Wartungsbausteinwettbewerb/Vorlage Ergebnis";
	$end_of_last_row = strrpos($one_paragraph, "-");

	$end_of_wbw_table = "{{Wikipedia:Wartungsbausteinwettbewerb/Vorlage|Ende der Wettbewerbstabelle=x}}" ;
	$offset = 0;
	if(stristr($one_paragraph, $end_of_wbw_table))
	{
		echo "ende gefunden";
		$end_of_last_row =  strpos($one_paragraph, $end_of_wbw_table);
		echo "end_of_last_row=$end_of_last_row";
		//echo "len of end:". strlen($end_of_wbw_table);
	}
	
	$beginning_of_template = $end_of_last_row;
	
	if(stristr($one_paragraph, $result_template_name))
	{
		echo "vorlage gefunden";
		$template_until_end = substr($one_paragraph, 0, $end_of_last_row);
		$beginning_of_template = strrpos($template_until_end, "{");
		echo "beginning_of_template=$beginning_of_template";
	}
	echo "count points:". count($point_set_this_team);
	$points_of_this_team =  $point_set_this_team["Points"];
	$result_param = "Ergebnis=$points_of_this_team";
	
	if($point_set_this_team["NumberMembers"] >= 4)
	{
		$result_param = "Rechnung+Ergebnis=<math>3\cdot \frac{". $point_set_this_team["TotalPoints"] ."}{". $point_set_this_team["NumberMembers"]."}=".$points_of_this_team."</math>";
	}
	
	$text_to_insert = "{{Wikipedia:Wartungsbausteinwettbewerb/Vorlage Ergebnis\n|Anker=".sprintf("%04d",$points_of_this_team)."|Zwischenergebnis=[http://de.wikipedia.org/w/index.php?title=".str_replace(" ", "_", $article)."&oldid=$oldid  ". strftime("%d.%m.")."]|$result_param}}\n";
	
	return substr($one_paragraph, 0, $beginning_of_template-1) . $text_to_insert. substr($one_paragraph, $end_of_last_row-1);
}
?>