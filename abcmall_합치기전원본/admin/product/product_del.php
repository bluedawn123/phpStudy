<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');


if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}

$pid = $_GET['pid'];
if (!isset($pid)) {
  echo "<script>alert('상품정보가 없습니다.'); location.href = '../product/product_list.php';</script>";
}

//products 테이블에서 pid 컬럼이 $pid와 같은 데이터 삭제, 썸네일 삭제
$thumbnail_sql = "SELECT thumbnail FROM products WHERE pid = $pid";
$thumbnail_result = $mysqli->query($thumbnail_sql);
$thumbnail_data = $thumbnail_result->fetch_object();
$thumbnail = $thumbnail_data->thumbnail;

unlink($_SERVER['DOCUMENT_ROOT'].$thumbnail);

$product_del_sql = "DELETE FROM products WHERE pid = $pid";
$product_del_result = $mysqli->query($product_del_sql);


//product_image_table 테이블에서 pid 컬럼이 $pid와 같은 데이터 삭제, 추가이미지 삭제
$addimage_sql = "SELECT filename FROM product_image_table WHERE pid = $pid";
$addimage_result = $mysqli->query($addimage_sql);
$addimages = [];

while($thumbnail_data = $addimage_result->fetch_object()){  
  $addimages[]= $thumbnail_data->filename;
}

foreach($addimages as $addimage){
  unlink($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/'.$addimage);
}

$addimage_del_sql = "DELETE FROM product_image_table WHERE pid = $pid";
$addimage_del_result = $mysqli->query($addimage_del_sql);


//product_options 테이블에서 pid 컬럼이 $pid와 같은 데이터 삭제, 옵션 이미지 삭제
$optimage_sql = "SELECT image_url FROM product_options WHERE pid = $pid";
$optimage_result = $mysqli->query($optimage_sql);
$optimages = [];

while($thumbnail_data = $optimage_result->fetch_object()){  
  $optimages[]= $thumbnail_data->image_url;
}

foreach($optimages as $optimage){
  unlink($_SERVER['DOCUMENT_ROOT'].$optimage);
}

$optimage_del_sql = "DELETE FROM product_options WHERE pid = $pid";
$optimage_del_result = $mysqli->query($optimage_del_sql);

//삭제 완료후 상품목록으로 이동
if($product_del_result){
  echo "<script>
    alert('상품 삭제 완료');
    location.href = 'product_list.php';
  </script>";
}
?>