<?php
$hostname = 'localhost';
$username = 'abcmall';
$dbpassword = 'abcmall1234';
$dbname = 'abcmall';

// echo '연결완료';

$mysqli = new mysqli($hostname, $username, $dbpassword, $dbname);
if ($mysqli->connect_errno) {
    throw new RuntimeException('연결 전 에러: ' . $mysqli->connect_error);
}

/* Set the desired charset after establishing a connection */
$mysqli->set_charset('utf8mb4');
if ($mysqli->errno) {
    throw new RuntimeException('연결 후 에러: ' . $mysqli->error);
}


?>