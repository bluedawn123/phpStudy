<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$imgid = $_POST['imgid'];
$sql = "SELECT * FROM product_image_table WHERE imgid=$imgid";
$result = $mysqli->query($sql);
$data = $result ->fetch_object();

if($data->userid !== $_SESSION['AUID']){
  $return_data = array('result'=>'mine');
  echo json_encode($return_data);
  exit;
}

$del_sql = "DELETE FROM  product_image_table WHERE imgid=$imgid";
$del_result = $mysqli->query($del_sql);

if($del_result){
  $delete_file = $_SERVER['DOCUMENT_ROOT'].$data->filename;
  unlink($delete_file);
  $return_data = array('result'=>'ok');
  echo json_encode($return_data);
  exit;
}else{
  $return_data = array('result'=>'error');
  echo json_encode($return_data);
  exit;
}

$mysqli->close();

?>