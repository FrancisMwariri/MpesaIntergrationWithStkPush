<?php
//YOU MPESA API KEYS
// Consumer Key & Secret from Daraja (Sandbox)
$consumerKey = "Enter Your Cunsumer Key";
$consumerSecret = "Enter Your Consumer Secret";

// Access Token
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$headers = ['Content-Type:application/json; charset=utf8'];

$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$result = json_decode($result);
$access_token = $result->access_token;
curl_close($curl);
