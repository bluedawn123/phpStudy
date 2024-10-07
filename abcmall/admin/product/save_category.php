<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

//넘겨온 데이터
$name = $_POST['name'];
$code = $_POST['code'];
$step = $_POST['step'];

//사용자가 넘겨온 데이터가 기존db에 유무를 확인해야함. (선조회 요구)
$sql = "SELECT cid FROM category WHERE step = $step and (name = '$name' or code = '$code')" ;
$result = $mysqli->query($sql);
$data = $result->fetch_object();

if($data && isset($data->cid)){ //데이터가 있고, 거기서 중복되는게 있는경우,
  $return_data = array('result'=>-1);  //★이건 연관배열. 이 연관배열을 json형식으로 변환해야함
  echo json_encode($return_data);
  exit;
} 
//중복이 안되면 테이블에 저장
$sql = "INSERT INTO category (code, name, step) VALUES ('$code', '$name', '$step')";
$result = $mysqli->query($sql);
  
if($result){
  $return_data = array('result'=>1);  //성공시
  echo json_encode($return_data);
}else{
  $return_data = array('result'=>0);  //실패시
  echo json_encode($return_data);
}


?>