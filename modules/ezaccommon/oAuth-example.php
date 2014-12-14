<?php
// @see http://oauth.googlecode.com/svn/code/php/OAuth.php
require 'oAuth.php';
// Establish an OAuth consumer based on consumer key and secret
$key ='Jgjmunstxqc7LQV4bVBNXckdsW8vfuqP';
$secret = '2HRzPZ33TMfuSPMdvZtGTF5LmbNujAh3';
$consumer = new OAuthConsumer($key, $secret, NULL); 
// Setup OAuth request
$api_endpoint = 'https://www.mydrupalsite.com/my_endpoint/resource_name';
$params = array('param1' => 'value1');
$request = OAuthRequest::from_consumer_and_token($consumer, NULL, 'POST', $api_endpoint, $params);
// Sign the constructed OAuth request using HMAC-SHA1
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
// Make signed OAuth request to the API server
$output = array();
foreach($params as $key => $item) {
  $output[] = $key . '=' . urlencode($item);
}
$url = $api_endpoint . '?' .  implode('&', $output);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FAILONERROR, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $request->to_header())); 
curl_setopt($curl, CURLOPT_POST, 1);                                       
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
$response = curl_exec($curl);
curl_close($curl);
?>