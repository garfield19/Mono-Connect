<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => ' https://api.flutterwave.com/v3/virtual-account-numbers',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "email": "dharmie19@gmail.com",
    "is_permanent": false,
    "bvn": ,
    "tx_ref": "VA12",
    "phonenumber": 08143731476,
    "firstname": "Damilola",
    "lastname": "Oyediran",
    "narration": "Damilola Side Hustle" 
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer FLWSECK-1dc38e4e25c8f6fe5b15a7f3c4cb8874-X'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
