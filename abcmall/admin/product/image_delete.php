<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$imgid = $_POST['imgid'];

//유저 아이디 추출하려고.
$sql = "SELECT * FROM product_image_table WHERE imgid=$imgid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

// if($data->userid !== $_SESSION['AUID']){
//   $return_data = array('result'=>'mine');
//   echo json_encode($return_data);
//   exit;
// }

$del_sql = "DELETE from product_image_table WHERE imgid=$imgid";
$del_result = $mysqli->query($del_sql);

if($del_result){
  //삭제할 파일의 경로 지정
  $delete_file = $_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/'.$data->filename;
  unlink($delete_file);

  $return_data = array('result'=>'okay');
  echo json_encode($return_data);
  exit;

}else{
  $return_data = array('result'=>'error');
  echo json_encode($return_data);
  exit;
}

$mysqli->close();

?>
