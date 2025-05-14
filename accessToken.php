<?php
//YOU MPESA API KEYS
// Consumer Key & Secret from Daraja (Sandbox)
$consumerKey = "1hK8pU624F0cnYGuamcefNJ9tXzYzbMSfpKl28bJA9w0fwns";
$consumerSecret = "AVF60BlmQVQZmGerOLJm0P4obWHRbrL48umQfl64JAKVb9WO84MqtNeOleK7rnLo";

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