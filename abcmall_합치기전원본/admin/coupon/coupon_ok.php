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

$mysqli->autocommit(FALSE);//커밋이 안되도록 지정, 일단 바로 저장하지 못하도록

try{

  $coupon_name = $_POST['coupon_name'] ?? '';
  $coupon_image = $_FILES['coupon_image'] ??'';
  $coupon_type = $_POST['coupon_type'] ?? '';
  $coupon_price = $_POST['coupon_price'] ?? '0';
  $coupon_ratio = $_POST['coupon_ratio'] ?? '0';
  $use_min_price = $_POST['use_min_price'] ?? '0';
  $max_value = $_POST['max_value'] ?? '0';
  $status = $_POST['status'] ?? '';

  //쿠폰이미지 업로드
  if (isset($_FILES['coupon_image']) && $_FILES['coupon_image']['error'] == UPLOAD_ERR_OK)  {

    $fileUploadResult = fileUpload($_FILES['coupon_image']);

    if($fileUploadResult) {
        $couponImage = $fileUploadResult;
    } else {
        echo "<script>
            alert('파일 첨부할 수 없습니다.');
            history.back();
        </script>";
    }
  }
  //쿠폰 테이블에 입력
  $sql = "INSERT INTO coupons 
  (coupon_name, coupon_image, coupon_type, coupon_price, coupon_ratio, status, userid, max_value, use_min_price) 
  VALUES
  ('$coupon_name', '$couponImage', '$coupon_type', $coupon_price, $coupon_ratio, $status, '{$_SESSION['AUID']}', $max_value, $use_min_price)";

  $result = $mysqli->query($sql); 

  //입력성공하면 쿠폰등록 완료 경고창 띄우고 쿠폰목록 페이지로 이동
  if($result){
    echo "
      <script>
        alert('쿠폰 등록 완료');
        location.href = 'coupon_list.php';
      </script>
    ";
    $mysqli->commit();//디비에 커밋한다.
  }

 
}catch (Exception $e) {
    $mysqli->rollback();//저장한 테이블이 있다면 롤백한다.
    exit;
}

$mysqli->close();
?>