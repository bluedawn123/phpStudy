<?php
$mysqli = new mysqli("localhost", "greenart", "green12345", "greenart");

if($mysqli->connect_error){
  echo "연결실패".$mysqli->connect_error;
  exit(); //스크립트종료(나가기)
} 