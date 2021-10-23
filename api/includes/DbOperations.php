<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class DbOperations
{
    private $con;
    private $client;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        require_once dirname(__FILE__) . '/Constants.php';
        $db = new DbConnect;
        $this->con = $db->connect();
        $this->client = new \GuzzleHttp\Client();

    }

    //update loan offer
    private function updateLoanOffer($con, $accountID, $amount)
    {

        $ins = "INSERT INTO `loan_offers`(`account_id`, `loan_offer`) 
         VALUES ( ?, ?)
          ON DUPLICATE KEY UPDATE 
          `loan_offer`  =?";

        $stmt3 = $this
            ->con
            ->prepare($ins);
        $stmt3->bind_param("sss", $accountID, $amount, $amount);
        if ($stmt3->execute())
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    //pay back loan
    public function payBackLoan($account_id)
    {
        //convert from naira to kobo
        $amountInKobo = $this->getCurrentDebt($account_id) * 100;

        $randomTenDigits = rand(1111111111, 9999999999);

        $myObj = new stdClass();

        $myObj->amount = $amountInKobo;
        $myObj->reference = $randomTenDigits;
        $myObj->description = "Loan replayment";
        $myObj->type = "onetime-debit";
        $myObj->redirect_url = "http://localhost/app/api/callback/verify-payment.php";

        $jsonData = json_encode($myObj);

        $response = $this
            ->client
            ->request('POST', 'https://api.withmono.com/v1/payments/initiate', [

        'body' => "$jsonData",

        'headers' => [

        'Accept' => 'application/json',

        'Content-Type' => 'application/json',

        'mono-sec-key' => 'test_sk_NzQxGXjwDo4x0S2VnVi4',

        ],

        ]);

        return $response->getBody();
    }


    //update debt
    private function updateDebt($con, $accountID, $amount)
    {

        $ins = "INSERT INTO `debt`(`account_id`, `amount`) 
         VALUES ( ?, ?)
          ON DUPLICATE KEY UPDATE 
           `amount`                =?";

        $stmt3 = $this
            ->con
            ->prepare($ins);
        $stmt3->bind_param("sss", $accountID, $amount, $amount);
        if ($stmt3->execute())
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    //add new transaction
    private function addTransaction($con, $accountID, $amount, $type)
    {
        $ins = "INSERT INTO `transactions`(`account_id`, `amount`, `type`) 
         VALUES ( ?, ?,?)";

        $stmt3 = $this
            ->con
            ->prepare($ins);
        $stmt3->bind_param('sss', $accountID, $amount, $type);
        if ($stmt3->execute())
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    //retrieve loan offer from DB
    public function getCurrentLoanOffer($account_id)
    {
        $stmt = $this
            ->con
            ->prepare("SELECT loan_offer FROM loan_offers WHERE account_id = ?");
        $stmt->bind_param('s', $account_id);
        $stmt->execute();
        $stmt->bind_result($loan_offer);
        $a = "";
        while ($stmt->fetch())
        {
            $a = $loan_offer;
        }
        return $a;

    }


    //retrieve current debt from DB
    public function getCurrentDebt($account_id)
    {
        $stmt1 = $this
            ->con
            ->prepare("SELECT amount FROM debt WHERE account_id = ?");
        if ($stmt1 === false)
        {
            die($this
                ->con
                ->error);
        }
        $stmt1->bind_param('s', $account_id);
        $stmt1->execute();
        $stmt1->bind_result($debt);
        $a = "";
        date_default_timezone_set('Africa/Lagos');
        while ($stmt1->fetch())
        {
            $a = $debt;
        }

        return $a;

    }

    //get account data
    public function getAccountData($account_id)
    {
        $stmt1 = $this
            ->con
            ->prepare("SELECT a.loan_offer, b.amount from loan_offers a join debt b on a.account_id = b.account_id WHERE a.account_id = ?");
        if ($stmt1 === false)
        {
            die($this
                ->con
                ->error);
        }
        $stmt1->bind_param('s', $account_id);
        $stmt1->execute();
        $stmt1->bind_result($loan_offer, $debt);

        $myObj = new stdClass();
        while ($stmt1->fetch())
        {
            $_SESSION['loanOffer'] = $loan_offer;
            $myObj->loan_offer = $loan_offer;
            $myObj->debt = $debt;
        }

        return json_encode($myObj);

    }

    //withdraw loan
    public function withdrawLoan()
    {
        $account_id = trim($_POST["account_id"]);
        $amount = trim($_POST["amount"]);

        //return if amount is higher than loan offer or user has a pending debt
        if ($this->getCurrentLoanOffer($account_id) < $amount || $this->getCurrentDebt($account_id) > 0)
        {

            $debt = $this->getCurrentDebt($account_id);
            $myObj = new stdClass();
            $myObj->status = '0';
            $myObj->debt = $debt;

            return json_encode($myObj);
        }

        $debt = $amount + $amount * 0.01;

        $debtUpdate = $this->updateDebt($this->con, $account_id, $debt);
        $trasactionUpdate = $this->addTransaction($this->con, $account_id, $amount, 'Withdrawal');

        if ($debtUpdate == 1 && $trasactionUpdate == 1)
        {
            $myObj = new stdClass();
            $myObj->status = '1';
            $myObj->debt = $debt;

        }
        else
        {
            $myObj = new stdClass();
            $myObj->status = '0';
            $myObj->debt = $this->getCurrentDebt($account_id);
        }

        return json_encode($myObj);

    }


    //get updated loan offer from mono
    public function getLoanOffer($account_id)
    {
        date_default_timezone_set('Africa/Lagos');

        //date range is today and 6 months ago
        $today = date('d-m-Y', time());
        $sixMonthsAgo = date('d-m-Y', strtotime('-6 months'));

        $response = $this
            ->client
            ->request('GET', "https://api.withmono.com/accounts/$account_id/transactions?start=$sixMonthsAgo&end=$today&paginate=false", ['headers' => ['Accept' => 'application/json', 'mono-sec-key' => 'test_sk_NzQxGXjwDo4x0S2VnVi4', ],

        ]);

        $data = json_decode($response->getBody());
        $transactionDataArray = $data->data;

        $credits = 0;
        $debits = 0;
        $count = 0;

        foreach ($transactionDataArray as $transactionData)
        {
            $count++;
            if ($transactionData->type == 'debit')
            {
                $debits += $transactionData->amount;
            }
            else
            {
                $credits += $transactionData->amount;
            }
        }

        //convert from kobo to naira
        $creditsInNaira = $credits / 100;
        $debitsInNaira = $debits / 100;

        //get approximated average debit and credit
        $averageDebits = floor($debitsInNaira / $count);
        $averageCredit = floor($creditsInNaira / $count);

        //get difference
        $difference = $averageCredit - $averageDebits;

        $offer = $difference > 0 ? floor($averageCredit * 0.50) : floor($averageCredit * 0.20);

        $this->updateLoanOffer($this->con, $account_id, $offer);

        return $offer;
    }

    //Get account id
    public function getAccountID($code)
    {
        $response = $this
            ->client
            ->request('POST', 'https://api.withmono.com/account/auth', ['body' => $code, 'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json', 'mono-sec-key' => 'test_sk_NzQxGXjwDo4x0S2VnVi4', ],

        ]);
        return $response->getBody();
    }

    //Get user information
    public function getUserInformation($account_id)
    {
        $response = $this
            ->client
            ->request('GET', "https://api.withmono.com/accounts/$account_id/identity", ['headers' => ['Accept' => 'application/json', 'mono-sec-key' => 'test_sk_NzQxGXjwDo4x0S2VnVi4', ],

        ]);

        return $response->getBody();
    }

    //Register user
    public function signUpUser($data)
    {
        $fullName = trim($_POST["name"]);
        $phoneNumber = trim($_POST["phone"]);
        $email = trim($_POST["email"]);
        $address1 = trim($_POST["address1"]);
        $address2 = trim($_POST["address1"]);
        $password = trim($_POST["password"]);
        $accountID = trim($_POST["id"]);

        $ins = "INSERT INTO `users`(`account_id`, `email`, 
         `phone_number`, `password`,
         `address_1`,`address_2`,`full_name`) 
         VALUES ( ?, ?, ?, ?, ?,?,?)
          ";

        $stmt3 = $this
            ->con
            ->prepare($ins);
        $stmt3->bind_param("sssssss", $accountID, $email, $phoneNumber, $password, $address1, $address2, $fullName);
        if ($stmt3->execute())
        {
            $this->updateLoanOffer($this->con, $accountID, '0');
            $this->updateDebt($this->con, $accountID, '0');
            $_SESSION['accountID'] = $accountID;
            $_SESSION['isLoggedIn'] = true;
            return 1;
        }
        else
        {
            return 0;
        }

    }


    //get loan privilegde
    public function getLoanPriviledge($account_id)
    {
        $mcount = 0;
        $stmt = $this
            ->con
            ->prepare("select count(*) as count from loan_offers where account_id = ?");
        $stmt->bind_param("s", $account_id);
        $stmt->execute();
        $stmt->bind_result($count);

        while ($stmt->fetch())
        {
            $mcount = $count;
        }

        return $mcount;

    }


    //login user
    public function loginUser()
    {

        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        $mAccount_id = "";
        $stmt = $this
            ->con
            ->prepare("select account_id from users where email = ? and password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->bind_result($account_id);

        while ($stmt->fetch())
        {
            $mAccount_id = $account_id;
        }

        if ($mAccount_id != "")
        {

            $_SESSION['accountID'] = $mAccount_id;
            $_SESSION['isLoggedIn'] = true;
            return "1";
        }
        else
        {
            return "0";
        }

    }

}

