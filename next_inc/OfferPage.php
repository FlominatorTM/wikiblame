<?php

class OfferPage
{
	private $userOffers;
	public $server;
	public $pageEncoded;
	public $templateName;
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
		
		$this->pageEncoded = name_in_url($OfferPageName);
		$page = "http://".$this->server."/w/index.php?action=raw&title=".$this->pageEncoded;

		$page_src = removeheaders(get_request($this->server, $page, true ));

		//print_debug("page_src=".$page_src);
		//print_debug("<hr><hr>");
		$this->templateName = $TemplateName;
		$page_parts = explode('{{'.$this->templateName, $page_src);

		foreach($page_parts as $template)
		{
			//print_debug("<hr>");
			//print_debug("<h1>template</h1>$template");

			$usr = new OfferingUser($this->extractTemplateParameter($template, $TemplateUser));
			
			$location = new GeoLocation($this->extractTemplateParameter($template, $TemplateLocation), $this->server);
			$usr->SetLocation($location);
			print_debug("<b>".$location->name."</b>");
			$range = $this->extractTemplateParameter($template, $TemplateRange);
			$dateFrom = trim($this->extractTemplateParameter($template, $TemplateDateFrom));
			$dateUntil = trim($this->extractTemplateParameter($template, $TemplateDateUntil));
			
			//echo "Ö $dateFrom Ö ! Ö $dateUntil Ö";
			$usr->SetDateRangeISO($dateFrom, $dateUntil);
			
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
		global $messages;
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
			
			if($usr->HasDuration())
			{
				echo " ";
				$now = time();

				if($usr->dateFrom < $now)
				{
					if($usr->dateTo < $now)
					{
						echo str_replace('_DATE_', strftime("%x", $usr->dateTo), $messages['until_date_over']);
					}
					else
					{
						echo str_replace('_DATE_', strftime("%x", $usr->dateTo), $messages['until_date']);
					}
				}
				else
				{
					$out = str_replace('_FIRST_DATE_', strftime("%x", $usr->dateFrom), $messages['between_dates']);
					echo str_replace('_SECOND_DATE_', strftime("%x", $usr->dateTo), $out);
				}
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