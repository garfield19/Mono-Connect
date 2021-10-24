<?php
if (PHP_SAPI == 'cli-server')
{
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file))
    {
        return false;
    }
}
require __DIR__ . '/../vendor/autoload.php';
require '../includes/DbOperations.php';
session_start();
// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
// Set up dependencies
$dependencies = require __DIR__ . '/../src/dependencies.php';
$dependencies($app);
// Register middleware
$middleware = require __DIR__ . '/../src/middleware.php';
$middleware($app);
// Register routes
$routes = require __DIR__ . '/../src/routes.php';
$routes($app);
// Run app
$app->run();

//get accountID
function getAccountID($request)
{

    $code = $request->getBody();
    $db = new DbOperations;
    $result = $db->getAccountID($code);
    echo $result;
}

function withdrawLoan()
{
    $db = new DbOperations;
    $result = $db->withdrawLoan();
    echo $result;
}



//get loan offer
function getLoanOffer($request)
{
    $account_id = $request->getQueryParam("account_id");
    $db = new DbOperations;
    $result = $db->getLoanOffer($account_id);
    echo $result;
}

function getAccountData($request)
{
    $account_id = $request->getQueryParam("account_id");
    $db = new DbOperations;
    $result = $db->getAccountData($account_id);
    echo $result;
}

function getTransactions($request)
{
    $account_id = $request->getQueryParam("account_id");
    $db = new DbOperations;
    $result = $db->getTransactions($account_id);
    echo $result;
}

function payBackLoan($request)
{
    $account_id = $request->getQueryParam("account_id");
    $db = new DbOperations;
    $result = $db->payBackLoan($account_id);
    echo $result;
}

function loginUser($request)
{ 
    $db = new DbOperations;
    $result = $db->loginUser();
    echo json_encode($result);
}

//get loan offer
function getLoanPriviledge($request)
{
    $account_id = $request->getQueryParam("account_id");
    $db = new DbOperations;
    $result = $db->getLoanPriviledge($account_id);
    echo $result;
}

function getCurrentLoanOffer($request)
{
    $account_id = $request->getQueryParam("account_id");
    $db = new DbOperations;
    $result = $db->getCurrentLoanOffer($account_id);
    echo $result;
}

function getCurrentDebt($request)
{
    $account_id = $request->getQueryParam("account_id");
    $db = new DbOperations;
    $result = $db->getCurrentDebt($account_id);
    echo $result;
}

//get accountID
function getUserInformation($request)
{
    $account_id = $request->getQueryParam("account_id");
    $db = new DbOperations;
    $result = $db->getUserInformation($account_id);
    echo $result;
}

// insert members from test app
function signUpUser($request)
{
    $request_body = $request->getParsedBody();
    $db = new DbOperations;
    $result = $db->signUpUser($request_body);
    echo json_encode($result);
}


