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
$pid = $_POST['pid'];
if (!isset($pid)) {
  echo "<script>alert('상품정보가 없습니다.'); 
  location.href = '../product/product_list.php';</script>";
}

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
$thumbnail = $_FILES['thumbnail'] ?? '';
$product_image_id = $_POST['product_image'];  //추가이미지의 imgid들 11,12,
$product_image_id = rtrim($product_image_id,','); //추가이미지의 imgid들 11,12


if(!empty($thumbnail)){ //비어있지 않다면, 첨부파일 있다면
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




$sql = "UPDATE products SET 
  name = '$name',
  cate = '$cate',
  content = '$contents',
  price = $price,
  sale_price = $sale_price,
  sale_ratio = '$sale_ratio',
  isnew = $isnew,
  isbest = $isbest,
  isrecom = $isrecom,
  ismain = $ismain,
  locate = '$locate',
  userid = '{$_SESSION['AUID']}',
  sale_end_date = '$sale_end_date',
  delivery_fee = $delivery_fee";

// thumbnail 값이 존재할 때만 thumbnail 컬럼을 업데이트
if (!empty($thumbnail)) {
  $sql .= ", thumbnail = '$thumbnail'";
}

$sql .= " WHERE pid = $pid";


//echo $sql;
$result = $mysqli->query($sql); //products테이블에 상품정보 입력(생성)

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