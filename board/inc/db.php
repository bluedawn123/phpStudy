<?php
$mysqli = new mysqli("localhost", "green212", "dejay*!2930", "green212");

if($mysqli->connect_error){
  echo "연결실패".$mysqli->connect_error;
  exit(); //스크립트종료(나가기)
} 