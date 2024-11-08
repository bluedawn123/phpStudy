<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$pid = $_POST['pid'];
$opts = $_POST['opts'];
$price = $_POST['price'];
$cnt = $_POST['cnt'];

if(isset($_SESSION['UID'])){
  $userid = $_SESSION['UID'];
  $ssid = '';
} else{
  $userid = '';
  $ssid = session_id();
}

$pid_sql = "SELECT COUNT(*) AS cnt FROM cart 
WHERE pid=$pid AND (userid = '$userid' or ssid = '$ssid')";
$pid_result = $mysqli->query($pid_sql);
if($pid_result){
  $data = $pid_result->fetch_object();
  if($data->cnt > 0){
    $data = array('result'=>'중복');
  } else{
    $sql = "INSERT INTO cart 
      (pid, userid, ssid, options, price, cnt) VALUES 
      ($pid, '$userid', '$ssid', '$opts',$price, $cnt)";

      $result = $mysqli->query($sql);

      if($result){
        $data = array('result'=>'ok');
      } else{
        $data = array('result'=>'fail');
      }
  }
}

echo json_encode($data); 

?>