<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$userid = $_POST['userid'];

//중복 id 개수 조회
$id_sql = "SELECT COUNT(*) AS cnt FROM members WHERE userid='$userid '";
$id_result = $mysqli->query($id_sql);
$id_data = $id_result->fetch_assoc();
$row_num = $id_data['cnt'];  //중복 1, 중복x 0

if($row_num >= 1){
  $return_data = array('result'=>'error');
  echo json_encode($return_data);
}else if($row_num == 0){ 
  $return_data = array('result'=>'ok');
  echo json_encode($return_data);
}

$mysqli->close();
?>