<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'alutotra_betall1');
define('DB_PASSWORD', 'alutotra_betall1');
define('DB_NAME', 'alutotra_betall1');

function getDBConnection() {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
