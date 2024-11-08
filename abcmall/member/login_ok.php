<?php
session_start();
$session_id = session_id();

include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$userid = $_POST['userid'];
$userpw = $_POST['userpw'];
$password = hash('sha512',$userpw);

$sql = "SELECT * FROM members WHERE userid='$userid' and passwd = '$password'";
$result = $mysqli->query($sql);
$data = $result ->fetch_object();

if($data){
  $_SESSION['UID'] = $data->userid;
  $_SESSION['UNAME'] = $data->username;

  $update_sql = "UPDATE cart SET userid = '$userid' WHERE ssid = '$session_id'";
  $update_result = $mysqli->query($update_sql);


  echo "<script>
    alert('$data->username 님 반갑습니다.');
    location.href='../index.php';
  </script>";

}else{
  echo "<script>
    alert('아이디 또는 비번이 맞지 않습니다.');
    history.back();
  </script>";
}



?>