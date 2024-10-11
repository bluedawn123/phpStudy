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

/*
if($_POST['cate1']){
  $cate1  = $_POST['cate1'];
 } else {
  $cate1  = "";
}

$cate1 = $_POST['cate1'] ? $_POST['cate1'] : '';
$cate1 = $_POST['cate1'] ?? '';  //널 병합 연산자 ??
  $_POST['cate1']가 존재하면(null이 아니면), $_POST['cate1']의 값을 반환합니다.
  $_POST['cate1']가 존재하지 않거나 null이면, 빈 문자열('')을 반환합니다.
*/

$cate1 = $_POST['cate1'] ?? '';  //널 병합 연산자 ??
$cate2 = $_POST['cate2'] ?? ''; 
$cate3 = $_POST['cate3'] ?? ''; 

$cate = $cate1.$cate2.$cate3;
$name = $_POST['name'];
$delivery_fee = $_POST['delivery_fee'];
$price = $_POST['price'];
$sale_price = $_POST['sale_price'] ?? 0;
$sale_ratio = $_POST['sale_ratio'] ?? 0;

$ismain = $_POST['ismain'] ?? 0;
$isnew = $_POST['isnew'] ?? 0;
$isbest = $_POST['isbest'] ?? 0;
$isrecom = $_POST['isrecom'] ?? 0;
$locate =  $_POST['locate'] ?? 0;

$sale_end_date = $_POST['sale_end_date']?? 0;
$contents = rawurldecode($_POST['contents']);
$thumbnail = $_FILES['thumbnail']??'';
$product_image_id = $_POST['product_image'];  //추가이미지의 imgid들 11,12,
$product_image_id = rtrim($product_image_id,','); //추가이미지의 imgid들 11,12


if(isset($_FILES['thumbnail'])){
  //파일 사이즈 검사
  if($thumbnail['size'] > 10240000 ){
   echo "
    <script>
      alert('10MB이하만 첨부할 수 있습니다.');
      history.back();
    </script>
   ";
  }
  
  //파일 포멧 검사
  if(strpos($thumbnail['type'], 'image') === false){
    echo "
    <script>
      alert('이미지만 첨부할 수 있습니다.');
      history.back();
    </script>
   ";
  }
  
  //파일 업로드
  $save_dir = $_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/';
  $filename = $thumbnail['name']; //insta.jpg
  $ext = pathinfo($filename,PATHINFO_EXTENSION); //파일명의 확장자를 추출, jpg
  $newFileName = date('YmdHis').substr(rand(), 0, 6);//202410091717123456
  $savefile = $newFileName.'.'.$ext;//202410091717123456.jpg
  
  if(move_uploaded_file($thumbnail['tmp_name'], $save_dir.$savefile)){
    $thumbnail = '/abcmall/admin/upload/'.$savefile;  
  } else{
    echo "<script>
      alert('이미지를 첨부할 수 없습니다.');
    </script>";
  }
}

$sql = "INSERT INTO products 
(name, cate, content, thumbnail, price, sale_price, sale_ratio, isnew, isbest, isrecom, ismain, locate, userid, sale_end_date, delivery_fee) 
VALUES
('$name', '$cate', '$contents', '$thumbnail', $price, $sale_price, '$sale_ratio', $isnew, $isbest, $isrecom, $ismain, $locate, '{$_SESSION['AUID']}', '$sale_end_date', $delivery_fee)";

//echo $sql;
$result = $mysqli->query($sql); //products테이블에 상품정보 입력(생성)
$pid = $mysqli->insert_id; //상품 등록시 자동으로 생성되는 상품의 고유번호 미리 확인

if($result){ //상품이 products테이블에 등록되면
  if($product_image_id){  
    //테이블 product_image_table에서 imgid의 값이 11,12인 데이터 행에서 pid 값을 $pid로 업데이트
    $update_sql = "UPDATE product_image_table SET pid=$pid WHERE imgid IN ($product_image_id)";
    $update_result = $mysqli->query($update_sql);
  }
  echo "
    <script>
      alert('상품 등록 완료');
      location.href = 'product_list.php';
    </script>
  ";
}



$mysqli->close();
?>