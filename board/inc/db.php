<?php
$mysqli = new mysqli("localhost", "greenart", "123123", "greenart");

// Check for errors
if($mysqli->connect_error){
  echo "연결실패".$mysqli->connect_error;
  exit(); //종료
} 

?>