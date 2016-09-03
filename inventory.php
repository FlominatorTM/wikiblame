<?php header('Content-Type: text/html; charset=utf-8');  ?>
<?php 

// $LastChangedDate$
// $Rev$
//shows the entries from zukunft that have been removed
include("shared_inc/wiki_functions.inc.php");

//$article = "Benutzer:Flominator/Zukunft";
$cat = $_REQUEST['cat'];
$other_cat_enc = urlencode($_REQUEST['other_cat']);
$template = urlencode($_REQUEST['template']);
$template_missing = $_REQUEST['template_missing'] == "true";
$catenc = urlencode($cat); //Wikipedia%3AZukunft
$articleenc = name_in_url($article);
$lang = "de";
$project = "wikipedia";
$server = "$lang.$project.org";
$number_of_current_entries = 0;

$plainfuture_text = retrieve_current_list($catenc, $template, $other_cat_enc, $template_missing);	
//echo "<hr>$plainfuture_text<hr>";
echo '<form method="post" action="https://'.$server.'/w/index.php?action=submit&title='. $articleenc .'" target="_blank">'."\n";
echo "<textarea  name=\"wpTextbox1\">";
echo "\n== Einbindungen ==\n";
echo $plainfuture_text;
echo "\n&nbsp;Anzahl: $number_of_current_entries";
echo "</textarea><br>";
echo '<input type="hidden" value="1" name="wpSection" />';
$timeStamp = get_page_time_stamp($server, $articleenc);
set_up_media_wiki_input_fields("Inventar-Seite mit inventory.php aktualisiert", "Inventar-Seite aktualisieren", $timeStamp);
echo "</form>\n";

$plain_text = get_plain_text_from_article($articleenc);

$entries_removed = compare_lists($plain_text, $plainfuture_text);
$entries_added= compare_lists($plainfuture_text, $plain_text);

echo '<form method="post" id="diff_form" action="https://'.$server.'/w/index.php?action=submit&title='. urlencode('Wikipedia:Spielwiese') .'" target="_blank">'."\n";
echo "<textarea  name=\"wpTextbox1\">";
echo ":via [[".$article."]]\n";
echo "\n===weg===\n";

foreach($entries_removed AS $removed)
{
	echo "$removed\n";
}
echo "\n Änderungen: ". count($entries_removed);

echo "\n===dazu===\n";

foreach($entries_added AS $added)
{
	echo "$added\n";
}
echo "\n Änderungen: ". count($entries_added);
echo "</textarea><br>";
echo '<input type="hidden" value="new" name="wpSection" />';
set_up_media_wiki_input_fields("Änderungen", "Änderungen anschauen");
echo "</form>\n";

function get_plain_text_from_article($articleenc)
{
	global $server;
	$page = "https://".$server."/w/index.php?action=raw&title=".$articleenc;
	return file_get_contents($page);
}

function compare_lists($needles, $haystack)
{
	//echo "entering compare_lists";
	echo '<!--- it seems that some output every once in a while keeps the browser';
	echo ' from stopping to load the page. Therefor here there will be a lot of dots ';
	echo " that pop up while the script is working it's ass off: ";
	$results = array();
	//$hits = 0;
	$paragraphsRemoved = explode("\n",$needles);
	 //echo "<h2> haystack</h2><textarea>$haystack</textarea>";
	 //echo "<h2> needles</h2><textarea>$needles</textarea>";
	foreach($paragraphsRemoved AS $newLine)
	{
		set_time_limit(120);
		echo ".";
		$onlyOneNewArticle = explode("]]:", $newLine);
		if(	stristr( $onlyOneNewArticle[0], "*" ) 
		 &&	!stristr($haystack, $onlyOneNewArticle[0] )
		 &&	!stristr($haystack, str_replace('_', ' ', $onlyOneNewArticle[0] ))
		 &&	!stristr(str_replace('_', ' ',$haystack),  $onlyOneNewArticle[0] )
		)
		{
			//echo str_replace('_', ' ', $newLine) ."\n";
			$results[] = str_replace('_', ' ', $newLine);
			//$hits++;
		}
	}
	//echo "$hits hits";
	//echo "leaving compare_lists";
	echo '-->';
	return $results;
}

function retrieve_current_list($catenc, $template, $other_cat_enc="", $template_not_present=false)
{
	global $cat, $number_of_current_entries;

	$all_namespaces ="ns%5B-2%5D=1&ns%5B0%5D=1&ns%5B2%5D=1&ns%5B4%5D=1&ns%5B6%5D=1&ns%5B8%5D=1&ns%5B10%5D=1&ns%5B12%5D=1&ns%5B14%5D=1&ns%5B100%5D=1&ns%5B828%5D=1&ns%5B-1%5D=1&ns%5B1%5D=1&ns%5B3%5D=1&ns%5B5%5D=1&ns%5B7%5D=1&ns%5B9%5D=1&ns%5B11%5D=1&ns%5B13%5D=1&ns%5B15%5D=1&ns%5B101%5D=1&ns%5B829%5D=1";
	$url ="https://tools.wmflabs.org/catscan2/catscan2.php?language=de&categories=$catenc%0D%0A$other_cat_enc&doit=1&format=tsv&$all_namespaces&depth=15&sortby=title";
	
   
   if($template!="")
	{
		
      if(!$template_not_present)
      {
         $url.="&templates_yes=$template";
      }
      else
		{
			$url.="&templates_no=$template";
		}
  	}

	ini_set('user_agent', 'script by de_user_Flominator'); 
    $csv_list = file_get_contents($url); 

	echo "$url<br/>";
	if(!$csv_list)
	{
		var_dump($http_response_header);
		die("<b>error while retrieving list from wmflabs</b>");
	}
	
	//echo strlen($csv_list);

	//echo "<h1>csv</h1>$csv_list";

	$rows = explode("\n", $csv_list);
	$bulleted_list = "";

	//echo count($rows) . "rows";
	foreach($rows AS $row)
	{
		//echo "$row<br>";
		$cols = explode("\t", $row);

		if($cols[1]!="" && $cols[1] != 'title')
		{
			
			$lemma = str_replace('_', ' ', $cols[1]);
			
			if(stristr($lemma, 'Kategorie:') || stristr($lemma, 'Datei:') || stristr($lemma, 'Vorlage:'))
			{
				$lemma = ':'.$lemma;
			}
			
			$bulleted_list.="* [[".$lemma."]]: [[:Kategorie:$cat|$cat]]\n";
			$number_of_current_entries = $number_of_current_entries + 1;
		}
	}
	return $bulleted_list;
}

function retrieve_current_list_old($catenc, $template="", $other_cat_enc="", $template_not_present=false)
{
	global $number_of_current_entries;
	$catpage ="https://toolserver.org/~daniel/WikiSense/CategoryIntersect.php?wikilang=de&wikifam=.wikipedia.org&basecat=$catenc&basedeep=3&go=Scannen&format=wiki&userlang=de";
	if($template!="")
	{
		$catpage.="&mode=ts&templates=$template";
		if($template_not_present)
		{
			$catpage.="&untagged=on";
		}
	}
	else if($other_cat_enc!="")
	{
		$catpage.="&mode=cs&tagcat=$other_cat_enc";
	}
	else 
	{
	$catpage.="&mode=al";
	}
	
	$page_content = file_get_contents($catpage);
	$number_of_current_entries = count(explode("*", $page_content))-1;
	echo "<!-- $catpage -->";
	return $page_content;
}

function chop_content_local($art_text)
{
	//echo "chopping text";
	$content_begins = strpos($art_text, '<!-- start content -->');
	$content_ends = strpos($art_text, '<!-- end content -->');
	$content = substr($art_text, $content_begins, strlen($art_text)-$content_ends);
	return str_replace('[bearbeiten]', '', $content);
}

?>