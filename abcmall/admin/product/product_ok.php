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


$optionCate1 = $_POST['option_cate1'] ?? '';
$optionName1 = $_POST['optionName1'] ?? [];
$optionPrice1 = $_POST['optionPrice1'] ?? [];
$optionImage1 = $_FILES['optionImage1'] ?? [];

$optionCate2 = $_POST['option_cate2'] ?? '';
$optionName2 = $_POST['optionName2'] ?? [];
$optionPrice2 = $_POST['optionPrice2'] ?? [];
$optionImage2 = $_FILES['optionImage2'] ?? [];




//썸네일 등록하기
if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK)  {
  $fileUploadResult = fileUpload($_FILES['thumbnail']);
  if($fileUploadResult) {
      $thumbnail = $fileUploadResult;
  } else {
      echo "<script>
          alert('파일 첨부할 수 없습니다.');
          history.back();
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
  //추가 이미지 등록
  if($product_image_id){  
    //테이블 product_image_table에서 imgid의 값이 11,12인 데이터 행에서 pid 값을 $pid로 업데이트
    $update_sql = "UPDATE product_image_table SET pid=$pid WHERE imgid IN ($product_image_id)";
    $update_result = $mysqli->query($update_sql);
  }

  //옵션1 이미지 등록하기(서버 파일 전송)
  if (isset($_FILES['optionImage1']['name'][0]) && $_FILES['optionImage1']['error'][0] == UPLOAD_ERR_OK){
    for($i = 0; $i<count($_FILES['optionImage1']['name']); $i++){
              //파일 사이즈 검사
          if($_FILES['optionImage1']['size'][$i] > 10240000 ){
            echo "
            <script>
              alert('10MB이하만 첨부할 수 있습니다.');
              history.back();
            </script>
            ";
          }
          
          //파일 포멧 검사
          if(strpos($_FILES['optionImage1']['type'][$i], 'image') === false){
            echo "
            <script>
              alert('이미지만 첨부할 수 있습니다.');
              history.back();
            </script>
            ";
          }
          
          //파일 업로드
          $save_dir = $_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/option/';
          $filename = $_FILES['optionImage1']['name'][$i]; //insta.jpg
          $ext = pathinfo($filename,PATHINFO_EXTENSION); //파일명의 확장자를 추출, jpg
          $newFileName = date('YmdHis').substr(rand(), 0, 6);//202410091717123456
          $savefile = $newFileName.'.'.$ext;//202410091717123456.jpg
          
          if(move_uploaded_file($_FILES['optionImage1']['tmp_name'][$i], $save_dir.$savefile)){
            $upload_option_image1[] = '/abcmall/admin/upload/option/'.$savefile;  
          } else{
            echo "<script>
              alert('이미지를 첨부할 수 없습니다.');
            </script>";
          }
    }
  }

  //옵션2 이미지 등록하기(서버 파일 전송)
  if (isset($_FILES['optionImage2']['name'][0]) && $_FILES['optionImage2']['error'][0] == UPLOAD_ERR_OK){
    for($i = 0; $i<count($_FILES['optionImage2']['name']); $i++){
              //파일 사이즈 검사
          if($_FILES['optionImage2']['size'][$i] > 10240000 ){
            echo "
            <script>
              alert('10MB이하만 첨부할 수 있습니다.');
              history.back();
            </script>
            ";
          }
          
          //파일 포멧 검사
          if(strpos($_FILES['optionImage2']['type'][$i], 'image') === false){
            echo "
            <script>
              alert('이미지만 첨부할 수 있습니다.');
              history.back();
            </script>
            ";
          }
          
          //파일 업로드
          $save_dir = $_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/option/';
          $filename = $_FILES['optionImage2']['name'][$i]; //insta.jpg
          $ext = pathinfo($filename,PATHINFO_EXTENSION); //파일명의 확장자를 추출, jpg
          $newFileName = date('YmdHis').substr(rand(), 0, 6);//202410091717123456
          $savefile = $newFileName.'.'.$ext;//202410091717123456.jpg
          
          if(move_uploaded_file($_FILES['optionImage2']['tmp_name'][$i], $save_dir.$savefile)){
            $upload_option_image2[] = '/abcmall/admin/upload/option/'.$savefile;  
          } else{
            echo "<script>
              alert('이미지를 첨부할 수 없습니다.');
            </script>";
          }
    }
  }
  
  //product_options 테이블에 옵션1 추가
  $i = 0;
  foreach($optionName1 as $op){
    if($op){
      $opt_sql = "INSERT INTO product_options 
      (pid,cate, option_name,option_price,image_url) 
      VALUES 
      ($pid, '$optionCate1', '$op', $optionPrice1[$i], '$upload_option_image1[$i]')";

      $opt_result = $mysqli->query($opt_sql);

      $i++;
    }
  }
  //product_options 테이블에 옵션2 추가

  $i = 0;
  foreach($optionName2 as $op){
    if($op){
      $opt_sql = "INSERT INTO product_options 
      (pid,cate, option_name,option_price,image_url) 
      VALUES 
      ($pid, '$optionCate2', '$op', $optionPrice2[$i], '$upload_option_image2[$i]')";

      $opt_result = $mysqli->query($opt_sql);
      $i++;
    }
  }

  echo "
    <script>
      alert('상품 등록 완료');
      location.href = 'product_list.php';
    </script>
  ";
}
    $mysqli->commit();//디비에 커밋한다.
}catch (Exception $e) {
    $mysqli->rollback();//저장한 테이블이 있다면 롤백한다.
    //에러문구
    exit;
}

$mysqli->close();
?>