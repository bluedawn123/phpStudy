<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');
error_reporting(E_ALL);
ini_set('display_errors',1);

$name = $_POST['name'];
$code = $_POST['code'];
$step = $_POST['step'];

if(isset($_POST['pcode'])){
  $pcode = $_POST['pcode'];
}

//중복 여부 파악
$sql = "SELECT cid FROM category WHERE step=$step and (name = '$name' or code = '$code')";
$result = $mysqli->query($sql);
$data = $result ->fetch_object();

if($data && isset($data->cid)){
  $return_data = array('result'=>-1);
  echo json_encode($return_data); //연관배열을 json 형식으로 변환
  exit;
}
//테이블에 저장
$sql = "INSERT INTO category (pcode, code, name, step) VALUES ('$pcode', '$code', '$name', $step)";
$result = $mysqli->query($sql);

if($result){
  $return_data = array('result'=>1); //성공
  echo json_encode($return_data); 
}else{
  $return_data = array('result'=>0);//실패
  echo json_encode($return_data); 
}

$mysqli->close();

?>