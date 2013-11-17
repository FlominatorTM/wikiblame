<?header('Content-Type: text/html; charset=utf-8');  ?><h1>Zwischenstände</h1>
<?

$is_debug = ($_REQUEST['debug']=="on" || $_REQUEST['debug']=="true" );

include("shared_inc/wiki_functions.inc.php");
$server = "$lang.$project.org";

$wbw_page = "http://".$server."/w/index.php?title="."Wikipedia:Wartungsbausteinwettbewerb/".name_in_url($_REQUEST['edition']);
$purge_page = "http://".$server."/w/api.php?action=purge&titles=Wikipedia:Wartungsbausteinwettbewerb/".name_in_url($_REQUEST['edition']);

$purge = post_request($server, $purge_page, "", "");

if($is_debug)
{
	echo "Purging returned $purge";
}


$points_per_team = rate_teams($server, $wbw_page);

sort_and_print_score_list($points_per_team);
print_form($wbw_page, update_paragraphs(get_source_code_paragraphs($server, $wbw_page), $points_per_team));

function extract_user_name_column($list_of_article_points)
{
	global $is_debug;
	$i = 0;
	$firstColumn = $list_of_article_points[$i];
	$list_of_article_points[$i]=""; //remove first column
	
	while(!stristr($firstColumn, "</td>"))
	{
		if($is_debug) echo "table didn't end in first column, adding next<br>";
		$i++;
		if($i==count($list_of_article_points)) 
		{
			die("no table end found");
		}
		$firstColumn = $firstColumn . $list_of_article_points[$i];
		$list_of_article_points[$i] = "";
	}
	$iEndOfFirstColumn = strpos($firstColumn, "</td>");
	if($is_debug) echo "end of first column:" . $iEndOfFirstColumn. "<br>";
	return  substr($firstColumn, 0, $iEndOfFirstColumn);
}

function rate_teams($server, $wbw_page)
{
	global $is_debug, $html_page;
	$html_page = get_request($server, $wbw_page, true );
	$team_paragraphs = explode("h6>", $html_page);
	$points_per_team;//[] = array("Team"=> "Dummy", "Points"=>"-1");

	for($iTeam = 1;$iTeam<count($team_paragraphs);$iTeam++)
	{
		//team name
		$team_name = str_replace("[Bearbeiten]", "", strip_tags($team_paragraphs[$iTeam]));
		if($is_debug) echo "Team=$team_name <br>";
		$iTeam++; // ignore next part (end of h6-Tag)
		
		$list_of_article_points = explode("(", $team_paragraphs[$iTeam]);
			
		$userNameColumn = extract_user_name_column(&$list_of_article_points); //by ref!!!
		$numberOfTeamMembers = get_number_of_users($userNameColumn);
		
		$points_of_this_team = count_points_of_team($list_of_article_points);

		$totalPointsOfThisTeam = $points_of_this_team;
		if($numberOfTeamMembers>3)
		{
			$points_of_this_team = 3* ($points_of_this_team / $numberOfTeamMembers);
		}
		$points_per_team[] = array("Team" => $team_name, "Points" => $points_of_this_team, "NumberMembers" => $numberOfTeamMembers, "TotalPoints" => $totalPointsOfThisTeam);
		//echo "Team:" . $team_name . "Points:" . $points_of_this_team;
		//echo $points_per_team[count($points_per_team)-1]["Team"]."//".$points_per_team[count($points_per_team)-1]["Points"];
		if($is_debug) echo "<hr>";
	}
	return $points_per_team;
}

function get_number_of_users($allUserNames)
{
	global $is_debug;
	if($is_debug) echo "allUserNames=".htmlspecialchars($allUserNames);
	$userLines = explode("<li><a href", $allUserNames);
	$numberOfTeamMembers = 0;
	foreach($userLines as $oneUserLine)
	{
		if ($is_debug) echo "line is $oneUserLine <br>";
		$oneLineLower = strtolower($oneUserLine);
		if(stristr($oneUserLine, "benutzer") ||stristr($oneUserLine, "user"))
		{
			$numberOfTeamMembers++;
		}
	}
	if($is_debug) echo "Team has " + $numberOfTeamMembers + " members";
	return $numberOfTeamMembers;
}

function count_points_of_team ($list_of_article_points)
{
	$points_of_this_team = 0;
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
	return $points_of_this_team;
}
	
function sort_and_print_score_list($points_per_team)
{
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
}

function get_source_code_paragraphs($server, $wbw_page)
{
	$wbw_page_raw = $wbw_page. "&action=raw";
	$source_code_page = removeheaders(get_request($server, $wbw_page_raw, true )); 

	$paragraphs = explode("\n======", $source_code_page);
	return $paragraphs;
}

function update_paragraphs($paragraphs, $points_per_team)
{
	global $is_debug;
	for($iParagraph=0;$iParagraph<count($paragraphs );$iParagraph++)
	{
		if($is_debug) echo "<h1>Para $iParagraph before</h1>".htmlspecialchars($paragraphs[$iParagraph])."<hr>";

		for($i=0;$i<count($points_per_team);$i++)
		{
			$i_team_length = strlen($points_per_team[$i]["Team"]);
			if($is_debug) echo "i_team_length=$i_team_length";
																											// no offset last time ... strange
			$clean_team_name_from_source_code = substr(htmlspecialchars(strip_tags($paragraphs[$iParagraph])), 1, $i_team_length);
			if($is_debug) echo "comparing \"" . $clean_team_name_from_source_code  . "\" to  \"<b>" . $points_per_team[$i]["Team"]."\"</b><br>";
			if($clean_team_name_from_source_code==$points_per_team[$i]["Team"])
			{
				if($is_debug) echo "found team " . $points_per_team[$i]["Team"];
				$paragraphs[$iParagraph] = update_one_team_paragraph($paragraphs[$iParagraph], $points_per_team[$i]);
				$i = count($points_per_team);
			}
		}
		if($is_debug) echo "<h1>Para $iParagraph after</h1>".htmlspecialchars($paragraphs[$iParagraph])." <hr>";
	}
	return $paragraphs;
}
	
function print_form($wbw_page, $paragraphs)
{
	echo '<form method="post" action="' . str_replace('http', 'https', $wbw_page) . '&action=submit">';
	set_up_media_wiki_input_fields("Zwischenstände aktualisiert", "Aktualisieren");
	
	if(!$is_debug) $style="style=\"display: none;\"";
	echo "<textarea name=\"wpTextbox1\" cols=\"80\" rows=\"25\" $style >" . implode($paragraphs, "\n======"). "</textarea><br>";
	echo '</form>';
}

function remove_existing_result_template($one_paragraph)
{
	global $is_debug;
	$result_template_name = "{{Wikipedia:Wartungsbausteinwettbewerb/Vorlage Ergebnis";
	$clean_paragraph = $one_paragraph;
	if(stristr($one_paragraph, $result_template_name))
	{
		if($is_debug) echo "vorlage gefunden";
		$beginning_of_template = strpos($one_paragraph, $result_template_name);
		if(substr($one_paragraph,$beginning_of_template-1, 1)=="\n")
		{
			if($is_debug) echo "newline found and removed";
			$beginning_of_template--;
		}
		$end_template_marker = "}}";
		$end_of_template = strpos($one_paragraph, $end_template_marker, $beginning_of_template)+ strlen($end_template_marker);
		$clean_paragraph = substr($one_paragraph, 0, $beginning_of_template) .  substr($one_paragraph, $end_of_template);
		
		if($is_debug)
		{
			echo "before removing: II" . $one_paragraph . "II<br>";
			echo "after removing: II".  $clean_paragraph  . "II<br>";
		}
	}
	return $clean_paragraph;
}

function get_place_for_template_insertion($one_paragraph)
{
	global $is_debug;
	$end_of_wbw_table = "\n<!-- ############" ;
	$index_to_insert_result_template = strrpos($one_paragraph, "-")-2; //= end of the table row is \n|-
	
	if(stristr($one_paragraph, $end_of_wbw_table))
	{
		$index_to_insert_result_template =  strpos($one_paragraph, $end_of_wbw_table);
	}
	if ($is_debug) echo "insertion at  $index_to_insert_result_template";
	return $index_to_insert_result_template;
}

function get_result_template($point_set_this_team)
{
	global $wbw_page;
	$oldid = get_old_id();
	$anchor = sprintf("%04d",ceil($point_set_this_team["Points"]));
	$permalink = "[".$wbw_page."&oldid=".$oldid . strftime(" %d.%m.")."]";

	$points_of_this_team =  $point_set_this_team["Points"];
	$result_param = "Ergebnis=$points_of_this_team";
	if($point_set_this_team["NumberMembers"] >= 4)
	{
		$result_param = "Rechnung+Ergebnis=<math>3\cdot \frac{". $point_set_this_team["TotalPoints"] ."}{". $point_set_this_team["NumberMembers"]."}=".sprintf("%0.1f", $points_of_this_team)."</math>";
	}
	
	$text_to_insert = "\n{{Wikipedia:Wartungsbausteinwettbewerb/Vorlage Ergebnis\n|Anker=$anchor|Zwischenergebnis=$permalink|".$result_param."}}";
	return $text_to_insert;
}

function get_old_id()
{
	global $is_debug, $html_page;
	$revision_prefix = "\"wgCurRevisionId\":";
	$index_of_revision_id = strpos($html_page, $revision_prefix );
	$end_of_revision_id = strpos($html_page, ",", $index_of_revision_id);

	$oldid = substr($html_page, $index_of_revision_id + strlen($revision_prefix ), $end_of_revision_id -$index_of_revision_id - strlen($revision_prefix ) );
	if($is_debug) echo "oldid=". $oldid;
	return $oldid;
}
function update_one_team_paragraph($one_paragraph, $point_set_this_team)
{
	global $is_debug;
	$one_paragraph = remove_existing_result_template($one_paragraph);
	$index_for_insertion = get_place_for_template_insertion($one_paragraph);
	$result_template = get_result_template($point_set_this_team);
		
	//$text_before = substr($one_paragraph, 0, $index_for_insertion);
	//$text_after = substr($one_paragraph, $index_for_insertion);
	return str_insert($result_template, $one_paragraph, $index_for_insertion);
	if($is_debug) 
	{
		$separator = "II";
	}
	return  $text_before .  $separator . $result_template .  $separator  .$text_after;
}

function str_insert($insertstring, $intostring, $offset) 
{
   $part1 = substr($intostring, 0, $offset);
   $part2 = substr($intostring, $offset);
 
   $part1 = $part1 . $insertstring;
   $whole = $part1 . $part2;
   return $whole;
}
 
?>