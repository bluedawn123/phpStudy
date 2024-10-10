<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$added_file = $_FILES['savefile'];



//파일 사이즈 검사
if($added_file['size'] > 10240000 ){
  $return_data = array('result'=>'size');//연관배열
  echo json_encode($return_data); //연관배열 -> 객체
  exit;
}

//파일 포멧 검사
if(strpos($added_file['type'], 'image') === false){
  $return_data = array('result'=>'image');//연관배열
  echo json_encode($return_data); //연관배열 -> 객체
  exit;
}

//파일 업로드
$save_dir = $_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/';
$filename = $added_file['name']; //insta.jpg
$ext = pathinfo($filename,PATHINFO_EXTENSION); //파일명의 확장자를 추출, jpg
$newFileName = date('YmdHis').substr(rand(), 0, 6);//202410091717123456
$savefile = $newFileName.'.'.$ext;//202410091717123456.jpg

if(move_uploaded_file($added_file['tmp_name'], $save_dir.$savefile)){
  $sql = "INSERT INTO product_image_table (userid, filename) VALUES ('{$_SESSION['AUID']}','$savefile')";
  $result = $mysqli->query($sql);
  $imgid = $mysqli->insert_id; //테이블에 자동으로 저장되는 고유번호 조회
  $return_data = array('result'=>'성공', 'imgid'=>$imgid, 'savefile'=>$savefile); //연관배열
  echo json_encode($return_data); //연관배열 -> 객체
  exit;
}else{
  $return_data = array('result'=>'error'); //연관배열
  echo json_encode($return_data); //연관배열 -> 객체
  exit;
}
$mysqli->close();
?>