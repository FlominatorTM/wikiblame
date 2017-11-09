<?php
require_once("shared_inc/language.inc.php");

$user_lang = read_language();

$article = isset ($_REQUEST['article']) ? $_REQUEST['article'] : ""; 
$articleenc = name_in_url($article);

$needle = isset ($_REQUEST['needle']) ? $_REQUEST['needle'] : ""; 

$lang = isset ($_REQUEST['lang']) ? $_REQUEST['lang'] : "";
if($lang=="")
{
	$lang=$user_lang; 
}

$project = isset ($_REQUEST['project']) ? $_REQUEST['project'] : "";
if($project=="")
{
	$project="wikipedia";
}

$limit = isset ($_REQUEST['limit']) ? $_REQUEST['limit'] : "";

if($limit=="")
{
	$limit = 50;
}


function purge($server, $article, $is_debug=false)
{
	$url = "https://".$server."/w/api.php";
	$data = array('action' => 'purge', 'titles' => $article);

	$result = curl_request($url, $data);

	if($is_debug)
	{
		echo "Purging via $purge_page returned $result";
	}
}

function name_in_url ($name)
{
	$name = str_replace(' ', '_', $name);
	$name = urlencode($name);
	return $name;
}

//fetches all versions
function get_history($server, $articleenc, $limit=50, $offset="")
{
	if($offset=="") 
	{ 
		$offset = strftime("%Y%m%d%H%M%S");
	}
	
	$historyurl = "https://".$server."/w/index.php?title=".$articleenc."&action=history&limit=$limit&offset=$offset";
	return curl_request($historyurl);
}

function curl_request($url, $post_data = null)
{
	static $ch;

	if(empty($ch))
	{
		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_MAXREDIRS => 5,
			CURLOPT_FAILONERROR => true,
			//https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
			CURLOPT_CAINFO => __DIR__ . '/ca-bundle.crt',
            CURLOPT_USERAGENT => _SERVER['SCRIPT_URI'] . 'by Flominator',
		));
	}
	curl_setopt($ch, CURLOPT_URL, $url);

	if(isset($post_data))
	{
		// CURLOPT_POSTFIELDS implies CURLOPT_POST
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	}
	else
	{
		// Reset method in case the handle performed a POST request before
		curl_setopt($ch, CURLOPT_HTTPGET, true);
	}

	return curl_exec($ch);
}

function create_images($was_found)
{
	if($was_found)
	{
		//$bild = imagecreatefrompng('shared_inc/ok.png');
		$hoch = 15;
		$breit = 25;
		$bild = imagecreate($breit, $hoch);
		$hg = imagecolorallocate($bild, 255,255,255);
		imagefilledrectangle($bild, 1, 1, $breit, $hoch, $hg);
		$font = 5;
		
		$farbe = imagecolorallocate($bild, 0,255,0);
		$meldung = "ok";
	}
	else
	{
		$hoch = 30;
		$breit = 50;
		$bild = imagecreate($breit, $hoch);
		$hg = imagecolorallocate($bild, 255,255,255);
		imagefilledrectangle($bild, 1, 1, $breit, $hoch, $hg);
		$font = 5;
		//$bild = imagecreatefrompng('shared_inc/no.png');
		$farbe = imagecolorallocate($bild, 255, 0,0);
		$meldung = "fehlt";
	}
	
	imagestring($bild, $font, 5, 5, $meldung, $farbe);
	imagepng($bild);
	imagedestroy($bild);	
}

function datedrop_with_months ($name, $varanf="", $intab=true, $jahranf="", $jahrbis="", $seljahr="", $selmon="", $seltag="", $the_months, $date_format)
{
	if($jahranf=="")	
	{
		$jahranf = date("Y");
	}
	
	if($jahrbis=="")	
	{
		$jahrbis = date("Y")+1;
	}
	
	if($seltag=="")
	{
		$seltag=date("dSSS");
	}
	
	if($selmon=="")
	{
		$selmon=date("m");
	}
	
	if($seljahr=="")
	{
		$seljahr=date("Y");
	}	

	if($intab==true)
	{
		$headers = "<tr>\n";
		$headers.="<td>\n";
		$headers.="$name\n";
		$headers.="</td>\n";
		$headers.="<td>\n";
		$trailers =  " </td>\n</tr>\n";
	}	
	
	$date_format = strtoupper($date_format);
	if($date_format=="" 
	|| !stristr($date_format, "DD")  
	|| !stristr($date_format, "MM")  
	|| !stristr($date_format, "YYYY")  
	)
	{
		$date_format = "DD-MM-YYYY";
	}
	
	echo $headers;
	
	$drop_down_text = str_replace("DD", dropdown ($varanf."tag", 1, 31, 1, "", "", $seltag), $date_format);
	$drop_down_text = str_replace("MM", array_drop ($varanf."mon", $the_months, 1, "", "", $the_months[($selmon-1)]), $drop_down_text);
	$drop_down_text = str_replace("YYYY", dropdown ($varanf."jahr", $jahranf, $jahrbis, 1, "", "", $seljahr), $drop_down_text);
	
	echo 	$drop_down_text;
	
	echo $trailers;	
}

/**
@brief creates a select box with integers
.

e.g. for use in datum form fields
@param $name name attribute of the form field
@param $start integer to begin at
@param $ende integer to end at
@param $ruck step size
@param $size size/length of the form field
@param $onchange javascript function to run on change
*/
function dropdown ($name, $start, $ende, $ruck=0, $size="", $onchange="", $selected="")
{
	$result = "";
	$vorne = "";
	for($i=0;$i<$ruck;$i++)
	{
		$vorne = $vorne." ";
	}
	
	if($size!='')
	{
		$result.= $vorne."<select name=\"$name\" size=\"$size\"";
	}
	else
	{
		$result.= $vorne."<select name=\"$name\" ";
	}
	
	if($onchange!="")
	{
		$result.= " onchange=\"$onchange\"";
	}
	
	$result.= ">\n";
	
	for($i=$start;$i<=$ende;$i++)
	{
		$result.= $vorne." <option value=\"$i\"";
		
		if(($selected!="")&&($i==$selected))
		{
			$result.= " selected";
		}
		$result.= ">$i</option>\n";
		
	}
		$result.= $vorne."</select>\n";
	return $result;
}

/**
@brief turns an array into a drop down field
@param $name 
@param $werte array with values
@param $size size/length of field
@param $startwert additional start value
*/
function array_drop ($name, $werte, $size="", $startwert="", $onchange="", $selected="")
{
	$vorne = " ";
	$result = "";
	if($size!='')
	{
		$result.= $vorne."<select name=\"$name\" size=\"$size\"";
	}
	else
	{
		$result.= $vorne."<select name=\"$name\" ";
	}
	
	
	
	if($onchange!="")
	{
		$result.= " onchange=\"$onchange\"";
	}
	
	$result.= ">\n";
	if($startwer!="")
	{
		$result.= $vorne." <option value=\"\">$startwert</option>\n";
	}
	for($i=0;$i<count($werte);$i++)
	{
		if($selected!="" && $werte[$i]==$selected)
		{
			$result.= $vorne." <option value=\"".($i+1)."\" selected>$werte[$i]</option>\n";
		}
		else
		{
			$result.= $vorne." <option value=\"".($i+1)."\">$werte[$i]</option>\n";
		}
	}
	$result.= $vorne."</select>\n";
	return $result;
}

function analyse_array($arr)
{
	echo "<dir>";
	echo count($arr)." Element(e)<br>";
	$keys = array_keys($arr);
	
	foreach($keys as $key)
	{
		echo "Array[".$key."]=".$arr[$key]."<br>";
		if(is_array($arr[$key]))
		{
			analyse_array($arr[$key]);
		}
	}
	echo "</dir>";
}

function chop_content($art_text)
{
	//echo "chopping text";
	$start_token = 'class="mw-content-ltr">';
	$end_token = '<div id="mw-navigation">';
	$content_begins = strpos($art_text, $start_token) + strlen($start_token);
	$content_ends = strpos($art_text, $end_token);
	$content = substr($art_text, $content_begins, $content_ends-$content_begins);
	//echo "<h1>start content</h1>$content<h1>end content</h1>";
	return str_replace('[bearbeiten]', '', $content);
}

function set_up_media_wiki_input_fields($summary, $button, $article="")
{
	global $server;
	$editTime = "";
	
	//switch to UTC http://stackoverflow.com/a/38665239/4609258
	$TZ=date_default_timezone_get();
	date_default_timezone_set('UTC');
		
	$UtcNow = time() - date('Z'); //http://php.net/manual/de/function.time.php#117251
	if($article!="" && $server != "")
	{
		$editTime = get_page_time_stamp($server, $article);
	}
	echo '<input type="submit" value="'.$button.'"/><br>';
	echo '<input type="hidden" name="wpSummary" value="'.$summary.'"/>';
	echo '<input type="hidden" name="wpWatchthis" value="1"/>';
	echo '<input type="hidden" name="wpDiff" value="'.$summary.'"/>';
	echo '<input type="hidden" name="wpStarttime" value="'. strftime("%Y%m%d%H%M%S", $UtcNow). '" />';
	echo '<input type="hidden" name="wpEdittime" value="'.$editTime.'" />';
	
	//and switch back to what it was before
	date_default_timezone_set($TZ);
}

function get_page_time_stamp($server, $article)
{

	$timeStampReturn = false;
	$queryURL = "https://".$server."/w/api.php?action=query&prop=revisions&format=xml&titles=".$article;
	$xml = simplexml_load_file($queryURL);

	if($xml)
	{	
		$timeStamp = $xml->query->pages->page[0]->revisions[0]->rev['timestamp'];
		$time = strtotime($timeStamp);
		$timeStampReturn = strftime("%Y%m%d%H%M%S", $time); //careful strftime will use local timezone
	}
	
	return $timeStampReturn;
}

 function extract_template_parameter($template_text, $parameter)
{
	$str_return = "";
	// print_debug("--------------------------------------------");
	// print_debug($template_text);
	// print_debug("--------------------------------------------");
	
	$split_parameters = explode('|', $template_text);
	
	foreach($split_parameters as $one_parameter_chunk)
	{
		$beginning_part = substr(trim($one_parameter_chunk), 0, strlen($parameter));
		if($beginning_part == $parameter)
		{
			//todo: this is somehow unfinished. 
			//$beginning_part is only used to determine if the parameter is present
			//in order to be more "corrent", it should be used instead of $template_text from here on
			$index_of_label = strpos($template_text, $parameter."=");
			if(!$index_of_label)
	{
				//looks like a blank before the equal sign
				$index_of_label = strpos($template_text, $parameter." =");
			}
			
		$index_of_equal_sign = strpos($template_text, "=", $index_of_label);
		$index_of_pipe_sign = strpos($template_text, "|" , $index_of_label);
		$index_of_template_end_sign = strpos($template_text, "}" , $index_of_label);
		
		$index_of_sign_after_parameter = $index_of_pipe_sign ;
		
		
		if($index_of_sign_after_parameter == 0  
		|| $index_of_template_end_sign < $index_of_pipe_sign)
		{
			$index_of_sign_after_parameter  = $index_of_template_end_sign;
		}
			$length_of_location = $index_of_sign_after_parameter - $index_of_equal_sign -1;
		
		 // print_debug("location_label = $parameter");
		 // print_debug("index_of_label = $index_of_label");
		 // print_debug("index_of_equal_sign = $index_of_equal_sign");
		 // print_debug("index_of_pipe_sign = $index_of_pipe_sign");
		 // print_debug("index_of_template_end_sign = $index_of_template_end_sign");
		 // print_debug("index_of_sign_after_parameter= index_of_sign_after_parameter");
		
			// print_debug("length_of_location = $length_of_location");
		
			return  trim(substr($template_text, $index_of_equal_sign+1, $length_of_location));
		}
	}
	return $str_return ;
}

function update_template_parameter($template_text, $parameter, $new_value)
{
    $ret = $template_text;
    $current_value = extract_template_parameter($template_text, $parameter);
    if($current_value!="")
    {
        $count = substr_count($template_text, $current_value);
        if($count==1)
        {
            $ret = str_replace($current_value, $new_value, $template_text);
        }
        else
        {
            die("update_template_parameter only supports parameter values present once - $current_value is present $count times");
        }
    }
    else
    {
        die("update_template_parameter only supports present parameters with a value");
    }
    return $ret;
}

function extract_link_target($source_part, $remove_namespace=false)
{
    $ret_val = false;
    
    if(stristr($source_part, "[[") && stristr($source_part, "]]"))
    {
        //echo "source-part= $source_part";
        $index_after_opening_brackets = strpos($source_part, "[[") + strlen("[[");
        //echo "index_opening_brackets= $index_opening_brackets";
        $index_before_closing_brackets = strpos($source_part, "]]");
       // echo "index_closing_brackets= $index_closing_brackets";
        $index_after_colon = strpos($source_part, ":") + strlen(":");;
        //echo "index_colon= $index_colon";
        $index_before_pipe = strpos($source_part, "|");
       // echo "index_pipe= $index_pipe";

        $beginning = $index_after_opening_brackets;
        //echo "beginning= $beginning";
        if($index_after_colon >1 && $remove_namespace==true)
        {
            $beginning = $index_after_colon;
        }
        //echo "beginning= $beginning";

        $ending = $index_before_closing_brackets;
        //echo "ending= $ending";
        if($index_before_pipe > 0 && $index_before_pipe < $ending)
        {
            $ending = $index_before_pipe;
        }
        //echo "ending= $ending";
        $ret_val = substr($source_part, $beginning, $ending-$beginning);
    }
    return $ret_val;
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
	
function print_debug($str)
{
    global $is_debug;
    if(isset($is_debug) && $is_debug)
    {
	echo $str."\n";
    }
}

function prevent_automatic_escaping_of_input_strings()
{
    // required to prevent automatic escaping of input strings
    // thanks to http://www.php.net/manual/de/security.magicquotes.disabling.php	
    if (get_magic_quotes_gpc()) 
    {
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
}

?>