<?php

/*

This file contains database config.phpuration assuming you are running mysql using user "root" and password ""

*/

date_default_timezone_set('Asia/Kolkata');



define('DB_SERVER', 'localhost');

define('DB_USERNAME', 'alutotra_betall1');

define('DB_PASSWORD', 'alutotra_betall1');

define('DB_NAME', 'alutotra_betall1');



// Try connecting to the Database

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);



//Check the connection

if($conn == false){

    dir('Error: Cannot connect');

    Echo"Fail";

}



?>