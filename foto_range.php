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

$server = "$lang.$project.org";

$article_to = $_REQUEST['article_to'];
if($article_to != "")
{
	echo '<h1>' . str_replace('_ARTICLE_TO_', $article_to, $messages['distance_to']) .'</h1>';
	$locTo = new GeoLocation($article_to, $server);
	if($locTo->IsValid())
	{
		$offerpage = new OfferPage($server);
		$offerpage->ListUsersToRequest($locTo);
	}
	else
	{
		echo str_replace('_LOCATION_', $requested, $messages['no_coordinates']);
	}
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