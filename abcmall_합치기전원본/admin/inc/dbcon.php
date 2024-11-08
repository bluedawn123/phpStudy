<?php
$hostname = 'localhost';
$username = 'abcmall';
$dbpassword = 'abcmall1234';
$dbname = 'abcmall';

$mysqli = new mysqli($hostname, $username, $dbpassword, $dbname);

if ($mysqli->connect_errno) { 
    throw new RuntimeException('연결에러: ' . $mysqli->connect_error);
}

/* Set the desired charset after establishing a connection */
$mysqli->set_charset('utf8mb4');
if ($mysqli->errno) {
    throw new RuntimeException('연결후 에러: ' . $mysqli->error);
}
?>