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
    // $db = new DbOperations;
    // $result = $db->getAccountID($code);
    echo $code;
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

// insert members from test app
function insertTestMembers($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['tgl_data']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->insertTestMembers($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['test_id'] = $reqW->{'test_id'};
            $message['sync_flag'] = 1;
            $message['sync_time'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
    }
    echo json_encode($a);
}


//download Field Mapping
function downloadFieldMapping($request)
{
    $last_synced_time = $request->getQueryParam("last_synced_time");
     $staff_id = $request->getQueryParam("staff_id");
    $db = new DbOperations;
    $result = $db->downloadFieldMapping($staff_id,$last_synced_time);
    echo json_encode($result);
}


// upload lmr
function uploadLMR($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['lmr_list']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->uploadLMR($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['unique_lmr_id'] = $reqW->{'unique_lmr_id'};
            $message['last_synced'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
    }
    echo json_encode($a);
}

//download question weight
function downloadLMR($request)
{
    $last_synced_time = $request->getQueryParam("last_synced_time");
     $staff_id = $request->getQueryParam("staff_id");
    $db = new DbOperations;
    $result = $db->downloadLMR($staff_id,$last_synced_time);
    echo json_encode($result);
}


//download question weight
function downloadQuestionWeight($request)
{
    $last_synced_time = $request->getQueryParam("last_synced_time");
    $db = new DbOperations;
    $result = $db->downloadQuestionWeight($last_synced_time);
    echo json_encode($result);
}



//download answer point
function downloadAnswerPoint($request){
    $last_synced_time = $request->getQueryParam("last_synced_time");
    $db = new DbOperations;
    $result = $db->downloadAnswerPoint($last_synced_time);
    echo json_encode($result);
}



//insert members test scores
function insertTestData($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['test_data']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->insertTestData($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['test_id'] = $reqW->{'test_id'};
            $message["question"] = $reqW->{'question'};
            $message['sync_flag'] = 1;
            $message['sync_time'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
    }
    echo json_encode($a);
}

//insert members total scores
function insertScoreData($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['score_data']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->insertScoreData($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['test_id'] = $reqW->{'test_id'};
            $message['sync_time'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
    }
    echo json_encode($a);
}

//insert members interview scores
function insertInterviewData($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['interview_data']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->insertInterviewData($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['test_id'] = $reqW->{'test_id'};
            $message["question"] = $reqW->{'question'};
            $message['sync_time'] = date('Y-m-d H:i:s');
            //array_push($a, $message);
        }
    }
    echo json_encode($a);
}

//insert test answers
function insertTGLAnswersData($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['tgl_answers']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->insertTGLAnswersData($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['test_id'] = $reqW->{'test_id'};
            $message['sync_time'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
    }
    echo json_encode($a);
}


//insert test answers grade
function insertInterviewTGLAnswersGrade($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['tgl_answers_grade']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->insertInterviewTGLAnswersGrade($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['test_id'] = $reqW->{'test_id'};
            $message['sync_time'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
    }
    echo json_encode($a);
}

//download location data
function downloadLocationData($request)
{
    $staff_id = $request->getQueryParam("staff_id");
    $last_synced_time = $request->getQueryParam("last_synced_time");
    $db = new DbOperations;
    $result = $db->downloadLocationData($staff_id, $last_synced_time);
    echo json_encode($result);
}

//download location constants
function downloadLocationConstants()
{
    $db = new DbOperations;
    $result = $db->downloadLocationConstants();
    echo json_encode($result);
}

//upload location data
function uploadLocationData($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['location_list']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->uploadLocationData($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['unique_location_id'] = $reqW->{'unique_location_id'};
            $message['last_synced'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
    }
    echo json_encode($a);
}

//get TFM Check List
function downloadTFMChecklist()
{
    $db = new DbOperations;
    $result = $db->downloadTFMChecklist();
    echo json_encode($result);
}

//get TFM App Variables
function downloadTFMAppVariables()
{
    $a = $b = array();

    $b["variable_id"] = "T-10000000000000AA";
    $b["kkg_min_old"] = "1";
    $b["kkg_min_new"] = "2";
    $b["kkg_max_old"] = "3";
    $b["kkg_max_new"] = "3";
    $b["ma_min_old"] = "3";
    $b["ma_min_new"] = "3";
    $b["ma_max_old"] = "5";
    $b["ma_max_new"] = "5";
    $b["max_field_size_multiplier"] = "0.60";

    array_push($a, $b);
    print (json_encode($a));
}

//get TFM input records
function downloadTFMInputRecordController($request)
{
    $staff_id = $request->getQueryParam("staff_id");
    $last_synced_time = $request->getQueryParam("last_synced_time");
    $db = new DbOperations;
    $result = $db->downloadTFMInputRecordController($staff_id,$last_synced_time );
    print (json_encode($result));
}

//get TG records
function downloadTGOutputRecordController($request)
{
    $staff_id = $request->getQueryParam("staff_id");
    $last_synced_time = $request->getQueryParam("last_synced_time");
    $db = new DbOperations;
    $result = $db->downloadTGOutputRecordController($staff_id,$last_synced_time );
    print (json_encode($result));
}



//get TFM input records
function downloadAppsList($request)
{
    $last_sync_down_apps_list = $request->getQueryParam("last_sync_down_apps_list");
    $db = new DbOperations;
    $result = $db->downloadAppsList($last_sync_down_apps_list);
    print (json_encode($result));
}

//get TFM output records
function downloadTFMOutputRecordController($request)
{
    $staff_id = $request->getQueryParam("staff_id");
    $last_synced_time = $request->getQueryParam("last_synced_time");
    $db = new DbOperations;
    $result = $db->downloadTFMOutputRecordController($staff_id);
    print (json_encode($result));
}

//sync up picture
function syncUpPicture($request){
    $uploadedFiles = $request->getUploadedFiles();
    
    $myFile = $uploadedFiles['file'];
    if ($myFile->getError() === UPLOAD_ERR_OK) {
        $uploadFileName = $myFile->getClientFilename();
        
        if((substr($uploadFileName, 0, 1) === 'f')){
            $myFile->moveTo('images/failed_test_face/' . $uploadFileName);
        }else if((substr($uploadFileName, 0, 1) === 'i')){
            $myFile->moveTo('images/test_id_cards/' . $uploadFileName);
        }else if(strpos($uploadFileName, "large") !== false){
            $myFile->moveTo('images/large_test_face/' . $uploadFileName);
        }else if(strpos($uploadFileName, "thumb") !== false){
            $myFile->moveTo('images/small_test_face/' . $uploadFileName);
        }else{
            $myFile->moveTo('images/test_outliers/' . $uploadFileName);
        }
        
         $success = true;  
     $message = "Successfully Uploaded";  
    }else{
         $success = false;  
      $message = "Error while uploading";  
    }
    
    $response["success"] = $success;  
$response["message"] = $message;  
echo json_encode($response);  

}


//sync up tfm picture
function syncTFMPicture($request){
    $uploadedFiles = $request->getUploadedFiles();
    
    $myFile = $uploadedFiles['file'];
    if ($myFile->getError() === UPLOAD_ERR_OK) {
        $uploadFileName = $myFile->getClientFilename();
        
         if((substr($uploadFileName, 0, 1) === 'f')){
            $myFile->moveTo('images/failed_tfm_face/' . $uploadFileName);
        }else if((substr($uploadFileName, 0, 1) === 'i')){
            $myFile->moveTo('images//tfm_id_cards/' . $uploadFileName);
        }else if(strpos($uploadFileName, "Large") !== false){
            $myFile->moveTo('images/large_tfm_face/' . $uploadFileName);
        }else if(strpos($uploadFileName, "thumb") !== false){
            $myFile->moveTo('images/small_tfm_face/' . $uploadFileName);
        }else{
            $myFile->moveTo('images/tfm_outliers/' . $uploadFileName);
        }
        
       // $myFile->moveTo('tfm_pictures/' . $uploadFileName);
         $success = true;  
     $message = "Successfully Uploaded";  
    }else{
         $success = false;  
      $message = "Error while uploading";  
    }
    
    $response["success"] = $success;  
$response["message"] = $message;  
echo json_encode($response);  

}

//sync up TFM trustgroup data
function trustGroupDataSyncUp($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['tg_table_data']);
    //$staff_id = json_decode($request_body['staff_id']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->trustGroupDataSyncUp($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['unique_ik_number'] = $reqW->{'unique_ik_number'};
            $message['sync_flag'] = 1;
            //$message['last_sync_up_time_tfm_data'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
        else
        {
            $message = array();
            $message['unique_ik_number'] = $reqW->{'unique_ik_number'};
            $message['sync_flag'] = 0;
            //$message['last_sync_up_time_tfm_data'] = date('Y-m-d H:i:s');
            array_push($a, $message);

        }
    }
    echo json_encode($a);
}

//sync up TFM members data
function tfmDataSyncUp($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['members_table_data']);
    //$staff_id = json_decode($request_body['staff_id']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->tfmDataSyncUp($reqW);
        date_default_timezone_set('Africa/Lagos');
        if ($result == "1")
        {
            $message = array();
            $message['unique_member_id'] = $reqW->{'unique_member_id'};
            $message['sync_flag'] = 1;
            $message['last_sync_up_time_tfm_data'] = date('Y-m-d H:i:s');
            array_push($a, $message);
        }
        else
        {
            $message = array();
            $message['unique_member_id'] = $reqW->{'unique_member_id'};
            $message['sync_flag'] = 0;
            $message['last_sync_up_time_tfm_data'] = date('Y-m-d H:i:s');
            array_push($a, $message);

        }
    }
    echo json_encode($a);
}

//insert field mapping data
function insertFieldMappingData($request)
{
    $request_body = $request->getParsedBody();
    $req = json_decode($request_body['wordlist']);
    $db = new DbOperations;
    $a = array();
    for ($i = 0;$i < count($req);$i++)
    {
        $reqW = $req[$i];
        $result = $db->insertFieldMappingData($reqW);
        date_default_timezone_set('Africa/Lagos');

        if ($result = "1")
        {
            $message = array();
            $message["unique_id"] = $reqW->{'unique_id'};
            $message["status"] = '1';
            $message["last_synced"] = date("Y-m-d H:i:s");
            array_push($a, $message);
           

        }


    }
    echo json_encode($a);
}

