<?header('Content-Type: text/html; charset=utf-8'); 
//shows the context articles linked to one given article mention it by printing one sentence where it is used

include("shared_inc/language.inc.php");
include("shared_inc/wiki_functions.inc.php");
include('next_inc/OfferingUser.php');	
include('next_inc/OfferPage.php');	
include('next_inc/GeoLocation.php');	
$inc_dir = "next_inc/lang";

//get the language file and decide whether rtl oder ltr is used
$user_lang = read_language();
get_language('en', $inc_dir); //not translated messages will be printed in English
get_language($user_lang, $inc_dir);



$is_debug = ($_REQUEST['debug']=="on" || $_REQUEST['debug']=="true" );
$offer_page = name_in_url("Wikipedia:Bilderangebote");
//$offer_page = name_in_url("Benutzer:Flominator/Fototest");

//$lang = "de";
//$project = "wikipedia";
global $server;
$server = "$lang.$project.org";
$page = "http://".$server."/w/index.php?action=raw&title=".$offer_page;
$offerpage = new OfferPage($page);

$article_to = $_REQUEST['article_to'];
if($article_to != "")
{
	echo '<h1>' . str_replace('_ARTICLE_TO_', $article_to, $messages['distance_to']) .'</h1>';
	$offerpage->ListUsersToRequest($article_to);
}

function print_debug($str)
{
	global $is_debug;
	if($is_debug)
	{
		echo $str;
	}
}









?>