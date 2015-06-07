<?php

class OfferPage
{
	private $userOffers;
	public $server;
	public $pageEncoded;
	public $TemplateName;
	public $revisionCurrent;
        private $TemplateUser;
        private $TemplateLocation;
        private $TemplateRange;
        private $TemplateDateFrom;
        private $TemplateDateUntil;
        private $UserPrefixMale;
        private $UserPrefixFemale;
        private $IndexUserColumn;
        private $IndexLocationColumn;
        
	public static $CONFIG_DIR = 'next_inc/proj';
	public static $CACHE_DIR = 'next_inc/cached';
	function __construct($server_in) 
	{
            
		global $messages, $is_debug;
	
		//echo "page=".$page;
		$this->server = $server_in;
		$cacheFile = self::$CACHE_DIR . '/' . $this->server . '.cache';

                if(!file_exists(self::$CACHE_DIR))
                {
                    mkdir(self::$CACHE_DIR, "0777");
                }
		$ConfigFile = self::$CONFIG_DIR . '/' . $this->server . '.php';
		if(!file_exists($ConfigFile))
		{
			die(str_replace('_PROJECT_', $this->server, $messages['proj_not_supported']));
		}
		else
		{
			include($ConfigFile);

			$this->templateName = $TemplateName;
                        $this->TemplateUser = $TemplateUser;
                        $this->TemplateLocation = $TemplateLocation;
                        $this->TemplateRange = $TemplateRange;
                        
                        if(isset($TemplateDateFrom))
                        {
                          $this->TemplateDateFrom = $TemplateDateFrom;
                        }
                        
                        if(isset($TemplateDateUntil))
                        {
                             $this->TemplateDateUntil = $TemplateDateUntil;
                        }
                        
                        if(isset($UserPrefixMale))
                        {
                            $this->UserPrefixMale = $UserPrefixMale;
                        }
                                                
                        if(isset($UserPrefixFemale))
                        {
                            $this->UserPrefixFemale = $UserPrefixFemale;
                        }
                        if(isset($IndexLocationColumn))
                        {
                            $this->IndexLocationColumn = $IndexLocationColumn;
                        }
                        if(isset($IndexUserColumn))
                        {
                            $this->IndexUserColumn = $IndexUserColumn;
                        }
                        
                        
		}
		
		$request_url="http://".$this->server."/w/api.php?action=query&prop=revisions&titles=".name_in_url($OfferPageName)."&format=xml";
		@$xml = simplexml_load_file($request_url);
		$this->revisionCurrent = $xml->query->pages->page->revisions->rev['revid'];
		$this->pageEncoded = name_in_url($OfferPageName);
		
		$useCache = $this->IsCachedVersionUpToDate();
		
                if($is_debug)
                {
                    $useCache = false;
                }
		$cacheIsFine = false;
		if($useCache)
		{
			print_debug("cache will be used");
			if(file_exists($cacheFile) && $fCacheHandle = fopen($cacheFile, "r"))
			{	
				// include_once("next_inc/GeoLocation.php");
				// include_once("next_inc/OfferingUser.php");
				print_debug("cache found and opened");
				if($this->userOffers = unserialize(fread($fCacheHandle, filesize($cacheFile))))
				{
					print_debug("cache read");
					fclose($fCacheHandle);
					
					foreach($this->userOffers as $cachedUser )
					{
						print_debug("user $cachedUser->name is valid: ".$cachedUser->ToString());
					}
					$cacheIsFine = true;
				}
			}			
			
		}

		if(!$cacheIsFine)
		{
			print_debug("cache is not fine");
			if(file_exists($cacheFile))
			{
				print_debug("deleting cache");
				unlink($cacheFile);
			}
			$page = "http://".$this->server."/w/index.php?action=raw&title=".$this->pageEncoded;

			$page_src = removeheaders(get_request($this->server, $page, true ));

			print_debug("page_src=".$page_src);
			print_debug("<hr><hr>");

                        if($this->server == "pl.wikipedia.org")
                        {
                            $this->GenerateUsersUsingList($page_src);
                        }
                        else
                        {
                            $this->GenerateUsersUsingTemplate($page_src);
                        }
			
			if($handleCacheFile = fopen($cacheFile, "w"))
			{
				print_debug("attempting to write cache");
				if(fputs($handleCacheFile, serialize($this->userOffers)))
				{
					print_debug("cache written");
					if(fclose($handleCacheFile))
					{
						$this->UpdateCachedRevision($this->revisionCurrent);
					}
					
				}
			}
			
		}
	}
        
        function GenerateUsersUsingList($page_src)
        {
            echo "<h1>hier</h1>";
            
            $page_parts = explode("|-", $page_src);
             print_debug("page_parts:" . count($page_parts));
            foreach($page_parts as $table_row)
            {
                print_debug("<b>row</b>:" . $table_row . "<br>");
                $cols = explode("||", $table_row);
                
                print_debug("cols has " . count($cols));
                if(count($cols)>= max($this->IndexUserColumn, $this->IndexLocationColumn) )
                {
                     print_debug("cols is big enough");
                    $user_column_small = strtolower($cols[$this->IndexUserColumn]);
                    print_debug("user_column_small:" . $user_column_small  . "<br>");
                    
                    if( strlen($user_column_small) > 0 
                        && 
                            (   stristr($user_column_small, "user")
                                || stristr($user_column_small, strtolower($this->UserPrefixMale) )
                                || stristr($user_column_small, strtolower($this->UserPrefixFemale) )
                            )
                        ) 
                    {
                        $usr_name = extract_link_target($cols[$this->IndexUserColumn], true);
                        $loc_name = extract_link_target($cols[$this->IndexLocationColumn]);
                        print_debug("usr:" . $usr_name ." loc:". $loc_name);
                        if($usr_name && $loc_name)
                        {
                            $usr = new OfferingUser($usr_name);
                            $location = new GeoLocation($loc_name, $this->server);
                            $usr->SetLocation($location);
                            if($usr->IsValid())
                            {
                                    print_debug("user $usr->name is valid: ".$usr->ToString());
                                    $this->userOffers[] = $usr;
                            }
                            else
                            {
                                print_debug("user $usr->name is <b>not</b> valid: ".$usr->ToString());
                            }
                        
                        }
                    }
                
                }
                 
            }
            
        }
  
        function GenerateUsersUsingTemplate($page_src)
        {
            $page_parts = explode('{{'.$this->TemplateName, $page_src);

            foreach($page_parts as $template)
            {
                    //print_debug("<hr>");
                    //print_debug("<h1>template</h1>$template");

                    $usr = new OfferingUser(extract_template_parameter($template, $this->TemplateUser));

                    $location = new GeoLocation(extract_template_parameter($template, $this->TemplateLocation), $this->server);
                    $usr->SetLocation($location);
                    print_debug("<b>".$location->name."</b>");
                    $range = extract_template_parameter($template, $this->TemplateRange);
                    $dateFrom = trim(extract_template_parameter($template, $this->TemplateDateFrom));
                    $dateUntil = trim(extract_template_parameter($template, $this->TemplateDateUntil));

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
            }
        }
	
	function UpdateCachedRevision($rev)
	{
		print_debug("updating cache revision file with $rev");
		$revisionFile = self::$CACHE_DIR. '/' . $this->server . '.rev';
		if($revFileHandle = fopen($revisionFile, "w"))
		{
			print_debug("file $revisionFile exists");
			if(fputs($revFileHandle, $rev))
			{
				fclose($revFileHandle);
				print_debug("file $revisionFile written");
				
			}
		}
	}
	function IsCachedVersionUpToDate()
	{
		print_debug("checking for state of cache");
		$isCacheUpToDate = false;
		$revFileHandle;
		$revisionFile = self::$CACHE_DIR . '/' . $this->server . '.rev';
		if(file_exists($revisionFile))
		{
			print_debug("file $revisionFile exists");
			if($revFileHandle = fopen($revisionFile, "r+"))
			{	
				print_debug("file $revisionFile was opened");
				$revisionOld = fgets($revFileHandle, 20);
				print_debug("file $revisionFile was read: $revisionOld");
				fclose($revFileHandle);
				
				$isCacheUpToDate = $revisionOld >= $this->revisionCurrent;
				print_debug("old: $revisionOld  new:  $this->revisionCurrent");
			}
		}
		return $isCacheUpToDate ;
	}
	
	function ListUsersToRequest($locTo)
	{
		global $messages;
		print_debug("locTo->ToString()=>" . $locTo->ToString());
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
	

}