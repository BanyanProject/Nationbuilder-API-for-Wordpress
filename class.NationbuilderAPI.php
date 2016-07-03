<?php

require_once('OAuth2/Client.php');

class NationbuilderAPI {

	protected $slug;
	protected $base_api;
	protected $client_id;
	protected $client_secret;
	protected $access_token;

	public function __construct() {
		$this->slug = NB_SLUG;
		$this->base_api = "https://{$this->slug}.nationbuilder.com";
		$this->client_id = NB_CLIENT_ID;
		$this->client_secret = NB_CLIENT_SECRET;
		$this->access_token = NB_ACCESS_TOKEN;
	}
	
	public function get($query,$params=array()) {
		return $this->oauth()->fetch($this->base_api . $query, $params);	
	}

	public function post($query,$params) {

		$handle = curl_init();
				
		curl_setopt($handle, CURLOPT_URL, $this->base_api . $query . "?access_token=" . $this->access_token);
		curl_setopt($handle, CURLOPT_CUSTOMREQUEST,'POST');
		curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($params));
		curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json'));  
		curl_setopt($handle, CURLOPT_RETURNTRANSFER,true);

		return json_decode(curl_exec($handle),true);
	}

	public function put($query,$params) {

		$handle = curl_init();
				
		curl_setopt($handle, CURLOPT_URL, $this->base_api . $query . "?access_token=" . $this->access_token);
		curl_setopt($handle, CURLOPT_CUSTOMREQUEST,'PUT');
		curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($params));
		curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json'));  
		curl_setopt($handle, CURLOPT_RETURNTRANSFER,true);

		return json_decode(curl_exec($handle),true);		 
	}

	public function delete($query, $params=NULL) {

		$handle = curl_init();
				
		curl_setopt($handle, CURLOPT_URL, $this->base_api . $query . "?access_token=" . $this->access_token);
		curl_setopt($handle, CURLOPT_CUSTOMREQUEST,'DELETE');
		
		// DELETE action may not take params
		if (is_array($params))
			curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($params));
		
		curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json'));  
		curl_setopt($handle, CURLOPT_RETURNTRANSFER,true);

		return json_decode(curl_exec($handle),true);		 
	}
	
	protected function oauth()
	{				
		static $oauth;
		
		if (!isset($oauth))
		{
			$oauth = new OAuth2\Client($this->client_id, $this->client_secret);
			$oauth->setAccessToken($this->access_token);
		}
		
		return $oauth;				
	}
}

?>