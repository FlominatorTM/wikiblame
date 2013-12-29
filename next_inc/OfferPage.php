<?php

class OfferPage
{
	private $userOffers;
	public $server;
	public static $CONFIG_DIR = 'next_inc/proj';
	function __construct($server_in) 
	{
		global $messages;
		//echo "page=".$page;
		$this->server = $server_in;

		$ConfigFile = self::$CONFIG_DIR . '/' . $this->server . '.php';
		if(!file_exists($ConfigFile))
		{
			die(str_replace('_PROJECT_', $this->server, $messages['proj_not_supported']));
		}
		else
		{
			include($ConfigFile);
		}
		
		$offer_page_enc = name_in_url($OfferPageName);
		$page = "http://".$this->server."/w/index.php?action=raw&title=".$offer_page_enc;

		$page_src = removeheaders(get_request($this->server, $page, true ));

		//print_debug("page_src=".$page_src);
		//print_debug("<hr><hr>");
		$page_parts = explode('{{'.$TemplateName, $page_src);

		foreach($page_parts as $template)
		{
			//print_debug("<hr>");
			//print_debug("<h1>template</h1>$template");

			$usr = new OfferingUser($this->extractTemplateParameter($template, $TemplateUser));
			
			$location = new GeoLocation($this->extractTemplateParameter($template, $TemplateLocation), $this->server);
			$usr->SetLocation($location);
			print_debug("<b>".$location->name."</b>");
			$range = $this->extractTemplateParameter($template, $TemplateRange);
			// print_debug("<b>".$range."</b><br />");
			$usr->SetRange($range);
			
			//print_debug($usr->ToString());

			if($usr->IsValid())
			{
				print_debug("user $usr->name is valid: ".$usr->ToString());
				$this->userOffers[] = $usr;
			}
			echo $coordinates_xml;
		}
	}
	
	function ListUsersToRequest($locTo)
	{
		print_debug("$locTo->ToString()=>" . $locTo->ToString());
		foreach($this->userOffers as $usr)
		{
			$usr->SetDistance($locTo);
		}
		
		usort($this->userOffers , array("OfferingUser", "CompareDistance"));
		
		foreach($this->userOffers as $usr)
		{
			$resLine = $usr->LinkToUser($this->server) . "  (" . sprintf("%01.1f",$usr->distance)  . " km)";
			if($usr->IsInRange())
			{
				echo "<b>$resLine</b>";
			}
			else
			{
				echo "$resLine";
			}
			
			
			echo "<br>";
		}
	}
	
	static function GetAvailableServers()
	{
		return get_language_list(self::$CONFIG_DIR);
	}
	
	private function extractTemplateParameter($template_text, $parameter)
	{
		$str_return = "";
		if(stristr($template_text, $parameter))
		{
			$index_of_label = strpos($template_text, $parameter);
			$index_of_equal_sign = strpos($template_text, "=", $index_of_label);
			$index_of_pipe_sign = strpos($template_text, "|" , $index_of_label);
			$index_of_template_end_sign = strpos($template_text, "}" , $index_of_label);
			
			$index_of_sign_after_parameter = $index_of_pipe_sign ;
			
			
			if($index_of_sign_after_parameter == 0  
			|| $index_of_template_end_sign < $index_of_pipe_sign)
			{
				$index_of_sign_after_parameter  = $index_of_template_end_sign;
			}
			$length_of_location = $index_of_sign_after_parameter - $index_of_equal_sign -2;
			
			// print_debug("location_label = $parameter");
			// print_debug("index_of_label = $index_of_label");
			// print_debug("index_of_equal_sign = $index_of_equal_sign");
			// print_debug("index_of_pipe_sign = $index_of_pipe_sign");
			// print_debug("index_of_template_end_sign = $index_of_template_end_sign");
			// print_debug("index_of_sign_after_parameter= index_of_sign_after_parameter");
			
			// print_debug("length_of_location = $length_of_location");
			
			$str_return =  substr($template_text, $index_of_equal_sign+1, $length_of_location);
		}
		return $str_return ;
	}
}