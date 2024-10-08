<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');


$added_file = $_FILES['savefile'];
if($added_file['size'] > 1024000){
  $return_data = array('result'=>'size'); //연관배열이므로 json_encode써야함
  echo json_encode($return_data);
}

//파일 포맷 검사
if( strpos($_FILES['type'],'image') === false){
  $return_data = array('result'=>'image'); //연관배열이므로 json_encode써야함
  echo json_encode($return_data);
  exit;
}

//파일업로드
$save_dir = $_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/';
$filename = $added_file['name']; //

//새로운 파일명 만들기(난수와 시간조합)
$ext = pathinfo($filename, PATHINFO_EXTENSION); //파일명의 확장자만 추출.ex)jpg, png 이런거
$newFileName = date('YmdHis').substr(rand(), 0, 6);  //ex)202410091717123456 ..
$savefile = $newFileName.'.'.$ext;  ///ex)202410091717123456.jpg 이런식 ..

//
if(move_uploaded_file($added_file['temp_name'], $save_dir.$savefile) ){
  $sql = "INSERT INTO proudct_image_table (userid, filename) VALUES ('{$_SESSION['AUID']}', '$savefile')";
  $result = $mysqli->query($sql);
  $imgid = $mysqli->insert_id;   //테이블에 자동으로 저장되는 고유번호 id조회(수정은 안되도 조회는 가능.)

  $return_data = array('reslut' => '성공', 'imgid'=>$imgid, 'savefile'=> $savefile); //연관배열
  echo json_encode($return_data);
  exit;
}else{
  $return_data = array('reslut' => 'error'); //연관배열
  echo json_encode($return_data);
  exit;
}



?>