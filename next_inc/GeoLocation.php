<?php

class GeoLocation
{
	public $lon = -1;
	public $lat = -1;
	public $iso = "";
	public $name = "";
	public $server;
	function __construct($article, $server_in)
	{
		$this->server = $server_in;
		$this->name = $article;
		$this->getCoordinates();
	}
	
	private function getCoordinates()
	{
		if($this->name != "")
		{
			$page="http://".$this->server."/w/api.php?action=query&prop=coordinates&titles=".name_in_url($this->name)."&format=xml";
			print_debug($page);
			$request_url = $page; 
			@$xml = simplexml_load_file($request_url);
			
			if($xml)
			{
				//echo "<pre>"; var_dump($xml); echo "</pre>";
				print_debug($xml->query->pages->page->coordinates->co['lon']."");
				if($xml->query->pages->page->coordinates->co['lon']!="")
				{
					$this->lon = "".$xml->query->pages->page->coordinates->co['lon']; //without "" some XML object would be linked
					$this->lat = "".$xml->query->pages->page->coordinates->co['lat'];
				}
			}
		}
	}
	
	function ToString()
	{
		return "Location $this->name at $this->lat/$this->lon";
	}
	
	function IsValid()
	{
		return $this->name != "" && $this->lat != -1 && $this->lon != -1;
	}
	
	function GetDistanceTo($locTo)
	{
		return $this->calculateDistance($this->lat, $this->lon, $locTo->lat, $locTo->lon);
	}
	
		/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	/*::                                                                         :*/
	/*::  This routine calculates the distance between two points (given the     :*/
	/*::  latitude/longitude of those points). It is being used to calculate     :*/
	/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
	/*::                     													 :*/
	/*::  Definitions:                                                           :*/
	/*::    South latitudes are negative, east longitudes are positive           :*/
	/*::                                                                         :*/
	/*::  Passed to function:                                                    :*/
	/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
	/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
	/*::    unit = the unit you desire for results                               :*/
	/*::           where: 'M' is statute miles                                   :*/
	/*::                  'K' is kilometers (default)                            :*/
	/*::                  'N' is nautical miles                                  :*/
	/*::  Worldwide cities and other features databases with latitude longitude  :*/
	/*::  are available at http://www.geodatasource.com                          :*/
	/*::                                                                         :*/
	/*::  For enquiries, please contact sales@geodatasource.com                  :*/
	/*::                                                                         :*/
	/*::  Official Web site: http://www.geodatasource.com                        :*/
	/*::                                                                         :*/
	/*::         GeoDataSource.com (C) All Rights Reserved 2013		   		     :*/
	/*::                                                                         :*/
	/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	private function calculateDistanceCommercial($lat1, $lon1, $lat2, $lon2, $unit="K") {

	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K") {
		return ($miles * 1.609344);
	  } else if ($unit == "N") {
		  return ($miles * 0.8684);
		} else {
			return $miles;
		  }
	}
	
	private function calculateDistance($startLat, $startLon, $endLat, $endLon)
	{
		//http://www.kurztutorial.info/php5/spezial/geokoordinaten/geokoordinaten.php
		print_debug("calculateDistance($startLat, $startLon, $endLat, $endLon)");
		$dist = 0.0;
		$x1 =  doubleval($startLon);
		$x2 = doubleval($endLon);
		$y1 = doubleval($startLat);
		$y2 = doubleval($endLat);
		// e = ARCCOS[ SIN(Breite1)*SIN(Breite2) + COS(Breite1)*COS(Breite2)*COS(Länge2-Länge1) ]
		
		print_debug("dist = acos(sin($x1=deg2rad($x1))*sin($x2=deg2rad($x2))+cos($x1)*cos($x2)*cos(deg2rad($y2) - deg2rad($y1)))*(6378.137);  ");
		$dist = acos(sin($x1=deg2rad($x1))*sin($x2=deg2rad($x2))+cos($x1)*cos($x2)*cos(deg2rad($y2) - deg2rad($y1)))*(6378.137);  
		print_debug("dist: $dist");
		return $dist;
	}
	
}