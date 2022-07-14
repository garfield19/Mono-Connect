<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '{{BASE_API_URL}}/virtual-account-numbers',
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
    "phonenumber": 08109328188,
    "firstname": "Angela",
    "lastname": "Ashley",
    "narration": "Angela Ashley-Osuzoka"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer {SEC_KEY}'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
