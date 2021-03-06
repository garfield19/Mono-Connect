<?php
session_start();
require_once ('../includes/Constants.php');
//$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$conn = mysqli_connect(CLEARDB_SERVER, CLEARDB_USERNAME, CLEARDB_PASSWORD, CLEARDB_DB);
require_once ('../vendor/autoload.php');
$account_id = $_SESSION['accountID'];

$client = new \GuzzleHttp\Client();

$reference = $_GET['reference'];

$myObj = new stdClass();

$myObj->reference = $reference;

$jsonData = json_encode($myObj);

$response = $client->request('POST', 'https://api.withmono.com/v1/payments/verify', [

'body' => $jsonData,

'headers' => [

'Accept' => 'application/json',

'Content-Type' => 'application/json',

'mono-sec-key' => 'test_sk_NzQxGXjwDo4x0S2VnVi4',

],

]);

$data = json_decode($response->getBody() , true);
$status = $data['data']['status'];
if ($status == "successful")
{
    $amount = $data['data']['amount'] / 100;
    $updateDebtSql = "UPDATE debt 
  SET amount = amount - $amount
  WHERE account_id = '$account_id'";
    //echo $amount;

    $insertTransaction = "INSERT INTO `transactions` (`account_id`, `amount`, `type`, `reference`) 
    VALUES ( '$account_id', '$amount','Repayment','$reference')";

    mysqli_query($conn, $updateDebtSql) or die(mysqli_error($conn));

    mysqli_query($conn, $insertTransaction) or die(mysqli_error($conn));

    header("location:https://mono-connect.herokuapp.com/home.php?status=$status");
}
else
{
    header("location:https://mono-connect.herokuapp.com/home.php?status=$status");
}

