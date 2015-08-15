<?php

/**
 * GeoPeekerApiWrapper
 *
 * @author     Christopher Lewis <chris@geopeeker.com>
 *
 *  Example Usage:
 *
 * 	$public_key = '12f0b42a5c5dad851c5995f6ddd346812';
 * 	$private_key = '4be6a55c3d72f077f675101d1b4132f7';
 * 
 * 	$wrapper = new GeoPeekerApiWrapper($public_key, $private_key);
 * 	$response = $wrapper->doPeek('example.com', 'en', null, 1000, array(0 => 'virginia'), array(0 => '640x960'));
 *
 *  Example Response (formated to make it easier to read):
 * 
 * 		 {
 * 		  "success": 1,
 *		  "locations": {
 *		    "virginia": {
 *		      "ip": "93.184.216.34",
 *		      "ping": "2",
 *		      "dns": "DNS Recordsexample.com name server b.iana-servers.net.\nexample.com name server a.iana-servers.
 *					  net.\nA Recordsexample.com has address 93.184.216.34\nCNAME Recordsexample.com has no CNAME 
 *    				  record\nMX Recordsexample.com has no MX record\nTXT Recordsexample.com descriptive text 
 *					  \"v=spf1 -all\"\nexample.com descriptive text \"$Id: example.com 4380 2015-08-12 20:14:21Z 
 *				      davids $\"\nSOA Recordsexample.com has SOA record sns.dns.icann.org. noc.dns.icann.org. 
 *					  2015081206 7200 3600 1209600 3600\n",
 *		      "renders": {
 *		        "640x960": {
 *		          "original": "https://www.geopeeker.com/uploads/api/55ccb0a24abdb_en_640x960_4.png",
 *		          "thumb": "https://www.geopeeker.com/uploads/api/55ccb0a24abdb_en_640x960_4_thumb.png",
 *		          "source": "https://www.geopeeker.com/uploads/api/55ccb0a24abdb_en_640x960_4_source.txt"
 *		        }
 *		      }
 *		    }
 *		  }
 *		}
 */

class GeoPeekerApiWrapper
{
	public static $API_PATH = 'https://api.geopeeker.com/api/router';

	private $private_key;

	private $public_key;

	/**
	 * Instantiate the wrapper
	 *
	 * @param string $public_key Your public API key, found in the GeoPeeker Account interface
	 *
	 * @param string $private_key Your private API key, also found in the GeoPeeker Account interface
	 *
	 * @return void
	 */
	public function __construct($public_key, $private_key)
	{
		$this->private_key = $private_key;
		$this->public_key = $public_key;
	}

	/**
	 * Query a url and return its IP address and ping timing from a given set of locations
	 *
	 * @param string $url URL to query
	 *
	 * @param array $locations Pass as many of the following options as you require: 
	 *	                       singapore, brazil, virginia, california, ireland, 
	 *                         australia, germany, india, sweden, uk, japan, canada
	 *
	 * @return string Returns json-encoded response of IP and Ping information for passed set of locations
	 */
	public function getIpAndPing($url, $locations)
	{
		//Create package
		$package = array('url' => $url, 'locations' => $locations, 
			'get_render' => false, 'get_dns' => false, 'get_ip_and_ping' => true);
		
		return $this->sendRequest($package);
	}

	/**
	 * Query a url and generate renders based on a passed locations
	 *
	 * @param string $url URL to query
	 *
	 * @param string $language Desired language to render in. Possible options:
	 *						   ar (Arabic), en (English), fr (French), de (German), 
	 *						   pt (Portuguese), pa (Punjabi), es (Spanish)
	 *
	 * @param string $user_agent Custom user agent string
	 *
	 * @param int $render_delay Number in milliseconds to wait for page to load before capturing render
	 *
	 * @param array $locations Pass as many of the following options as you require: 
	 *	                       singapore, brazil, virginia, california, ireland, 
	 *                         australia, germany, india, sweden, uk, japan, canada
	 *
	 * @param array $resolutions Pass up to two resolutions at a time.
	 *							 Valid options for Pro users:
	 *							 320x480, 320x568, 375x687, 414x736, 768x1024, 1024x768, 1280x800
	 *
	 *							 Valid options for Enterprise users:
	 *							 320x480, 320x568, 375x687, 414x736, 768x1024, 1024x768, 1280x800, 1440x900, 
	 *						     1680x1050, 1920x1080
	 *
	 * @return string Returns json-encoded response that includes paths to renders. 
	 *			      NOTE: Renders will be available for only 15 minutes. It is recommended that you make 
	 *				  copies if you require them for later use.
	 */
	public function getRender($url, $language = null, $user_agent = null, $render_delay = 2500, 
		$locations = array(), $resolutions = array())
	{
		//Create package
		$package = array('url' => $url, 'language' => 'en', 'user_agent' => $user_agent, 
			'render_delay' => $render_delay, 'locations' => $locations, 'resolutions' => $resolutions,
			'get_render' => true, 'get_dns' => false, 'get_ip_and_ping' => false);

		return $this->sendRequest($package);
	}

	/**
	 * Query a url and return DNS information from a given set of locations
	 *
	 * @param string $url URL to query
	 *
	 * @param array $locations Pass as many of the following options as you require: 
	 *	                       singapore, brazil, virginia, california, ireland, 
	 *                         australia, germany, india, sweden, uk, japan, canada
	 *
	 * @return string Returns json-encoded response that includes DNS information for each passed location
	 */
	public function getDns($url, $locations)
	{
		//Create package
		$package = array('url' => $url, 'locations' => $locations, 'get_render' => false, 'get_dns' => true, 'get_ip_and_ping' => false);
		
		return $this->sendRequest($package);
	}

	/**
	 * Query a url and return renders, IP address, Ping, and DNS information for each passed location
	 *
	 * @param string $url URL to query
	 *
	 * @param string $language Desired language to render in. Possible options:
	 *						   ar (Arabic), en (English), fr (French), de (German), 
	 *						   pt (Portuguese), pa (Punjabi), es (Spanish)
	 *
	 * @param string $user_agent Custom user agent string
	 *
	 * @param int $render_delay Number in milliseconds to wait for page to load before capturing render
	 *
	 * @param array $locations Pass as many of the following options as you require: 
	 *	                       singapore, brazil, virginia, california, ireland, 
	 *                         australia, germany, india, sweden, uk, japan, canada
	 *
	 * @param array $resolutions Pass up to two resolutions at a time.
	 *							 Valid options for Pro users:
	 *							 320x480, 320x568, 375x687, 414x736, 768x1024, 1024x768, 1280x800
	 *
	 *							 Valid options for Enterprise users:
	 *							 320x480, 320x568, 375x687, 414x736, 768x1024, 1024x768, 1280x800, 1440x900, 
	 *						     1680x1050, 1920x1080
	 *
	 * @return string Returns json-encoded response that includes all the goodies
	 *			      NOTE: Renders will be available for only 15 minutes. It is recommended that you make 
	 *				  copies if you require them for later use.
	 */
	public function doPeek($url, $language = null, $user_agent = null, $render_delay = 1000, 
		$locations = array(), $resolutions = array())
	{
		//Create package
		$package = array('url' => $url, 'language' => 'en', 'user_agent' => $user_agent, 
			'render_delay' => $render_delay, 'locations' => $locations, 'resolutions' => $resolutions);
		
		return $this->sendRequest($package);
	}

	/**
	 * Send request to API and return the response
	 *
	 * @param array $package Contains the package that will be be sent to the API
	 *
	 * @return string Returns json-encoded response from API
	 */
	protected function sendRequest($package)
	{
		//Convert to json
		$json_package = json_encode($package);

		$size = strlen($json_package);

		//Build our request
		$ch = curl_init(self::$API_PATH . "/peek/");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $this->public_key . ':' . $this->private_key);
		curl_setopt($ch, CURLOPT_REFERER, 'https://geopeeker.com');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_package);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . $size,
		));

		$response = curl_exec($ch);

		return $response;
	}
}