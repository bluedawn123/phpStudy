<?php
// $hostname = 'localhost';
// $username = 'abcmall';
// $dbpassword = 'abcmall1234';
// $dbname = 'abcmall';

//13.125.124.102
$hostname = '13.125.124.102';
$username = 'abcmall';
$dbpassword = '12345';
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