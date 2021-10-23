<?php 
    class DbConnect{
        
        private $con;

        function connect(){
            include_once dirname(__FILE__)  . '/Constants.php';

            $this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
           /// $this->con = new mysqli(CLEARDB_SERVER, CLEARDB_USERNAME, CLEARDB_PASSWORD, CLEARDB_DB);
            if(mysqli_connect_errno()){
                echo "Failed  to connect " . mysqli_connect_error(); 
                return null; 
            }
            return $this->con; 
        }
        
    }?>