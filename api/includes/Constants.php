<?php 
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'easy_loans');

//Get Heroku ClearDB connection information
// $cleardb_url = parse_url(getenv("mysql://b4b7c8a2ad059a:6267b6bf@us-cdbr-east-04.cleardb.com/heroku_0ad790080f03aa7?reconnect=true"));
 define('CLEARDB_SERVER', 'us-cdbr-east-04.cleardb.com');
 define('CLEARDB_USERNAME', 'b4b7c8a2ad059a');
define('CLEARDB_PASSWORD', '6267b6bf');
define('CLEARDB_DB', 'heroku_0ad790080f03aa7');

    define('SECRET_KEY','test_sk_NzQxGXjwDo4x0S2VnVi4');
    
    ?>