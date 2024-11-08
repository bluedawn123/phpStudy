<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/file_upload_func.php');


if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}
$cid = $_POST['cid'];
if (!isset($cid)) {
  echo "<script>alert('쿠폰정보가 없습니다.'); 
  location.href = 'coupon_list.php';</script>";
}

$coupon_name = $_POST['coupon_name'];
$coupon_image =  $_FILES['coupon_image'] ?? '';
$coupon_type = $_POST['coupon_type'];
$coupon_price = $_POST['coupon_price'] ?? 0;
$coupon_ratio = $_POST['coupon_ratio'] ?? 0;
$status = $_POST['status'];
$max_value = $_POST['max_value'] ?? 0;
$use_min_price = $_POST['use_min_price'] ?? 0;

//쿠폰 썸네일 변경 되었다면
if(isset($_FILES['coupon_image']) && $_FILES['coupon_image']['error'] == UPLOAD_ERR_OK){
  
  $fileUploadResult = fileUpload($_FILES['coupon_image']);

  if($fileUploadResult) {
      $thumbnail = $fileUploadResult;
  } else {
      echo "<script>
          alert('파일 첨부할 수 없습니다.');
          history.back();
      </script>";
  }

}


//쿠폰 썸네일의 값이 없으면
$sql = "UPDATE coupons SET 
  coupon_name = '$coupon_name',
  coupon_type = '$coupon_type',
  coupon_price = $coupon_price,
  coupon_ratio = $coupon_ratio,
  status = $status,
  max_value = $max_value,
  use_min_price = $use_min_price
  ";

// thumbnail 값이 존재할 때만 thumbnail 컬럼을 업데이트

if (isset($_FILES['coupon_image']) && $_FILES['coupon_image']['error'] == UPLOAD_ERR_OK)  {
  $sql .= ", coupon_image = '$thumbnail'";
}

$sql .= " WHERE cid = $cid";

$result = $mysqli->query($sql); 

if($result){
  echo "
    <script>
      alert('쿠폰 수정 완료');
      location.href = 'coupon_list.php';
    </script>
  ";
} else{
  echo "
    <script>
      alert('쿠폰 수정 실패');
      history.back();
    </script>
  ";
}