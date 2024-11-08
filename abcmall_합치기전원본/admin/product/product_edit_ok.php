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
$thumbnail = $_FILES['thumbnail'];
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


//썸네일 변경 되었다면
if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK){
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


//썸네일의 값이 없고
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

if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK)  {
  $sql .= ", thumbnail = '$thumbnail'";
}

$sql .= " WHERE pid = $pid";


$result = $mysqli->query($sql); //products테이블에 상품정보 입력(생성)





if($result){ //상품이 products테이블에 등록되면

  //추가 이미지가 변동되면
  if($product_image_id){  
    //테이블 product_image_table에서 imgid의 값이 11,12인 데이터 행에서 pid 값을 $pid로 업데이트
    $update_sql = "UPDATE product_image_table SET pid=$pid WHERE imgid IN ($product_image_id)";
    $update_result = $mysqli->query($update_sql);
  }

  //옵션1 변경 되었다면
  if($optionCate1){

    //poid 조회
    $poid_sql = "SELECT poid FROM product_options WHERE cate='$optionCate1' and pid = $pid";
    $poid_result = $mysqli->query($poid_sql);
    $poids = [];
    while($poid_date = $poid_result->fetch_object()){
      $poids[] = $poid_date-> poid;
    }

    $i = 0;
    foreach($optionName1 as $op){
      if($op){
        $sql = "UPDATE product_options SET 
          cate = '$optionCate1',
          option_name = '$op',
          option_price = $optionPrice1[$i]
        ";

        //옵션1 이미지가 변경 되었다면
        if (isset($_FILES['optionImage1']) && $_FILES['optionImage1']['error'][$i] == UPLOAD_ERR_OK)  {

            $uploadfile = $_FILES['optionImage1'];

            //파일 사이즈 검사
            if($uploadfile['size'][$i] > 10240000 ){
              echo "
              <script>
                alert('10MB이하만 첨부할 수 있습니다.');
                history.back();
              </script>
              ";
            }
            
            //파일 포멧 검사
            if(strpos($uploadfile['type'][$i], 'image') === false){
              echo "
              <script>
                alert('이미지만 첨부할 수 있습니다.');
                history.back();
              </script>
              ";
            }
            
            //파일 업로드
            $save_dir = $_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/';
            $filename = $uploadfile['name'][$i]; //insta.jpg
            $ext = pathinfo($filename,PATHINFO_EXTENSION); //파일명의 확장자를 추출, jpg
            $newFileName = date('YmdHis').substr(rand(), 0, 6);//202410091717123456
            $savefile = $newFileName.'.'.$ext;//202410091717123456.jpg
            
            if(move_uploaded_file($uploadfile['tmp_name'][$i], $save_dir.$savefile)){
              $optImageUrl = '/abcmall/admin/upload/'.$savefile;  
            } else{
              echo "<script>
                alert('이미지를 첨부할 수 없습니다.');
              </script>";
            }

          $sql .= ", image_url = '$optImageUrl'";
        }
        $sql .= " WHERE cate = '$optionCate1' and poid = $poids[$i]";   
        $opt1_result = $mysqli->query($sql); 
        $i++;
      }
    }  
  }

  //옵션2 변경 되었다면, 옵션2의 이미지가 변경되면
  if($optionCate2){
    //poid 조회
    $poid_sql = "SELECT poid FROM product_options WHERE cate='$optionCate2' and pid = $pid";
    $poid_result = $mysqli->query($poid_sql);
    $poids = [];
    while($poid_date = $poid_result->fetch_object()){
      $poids[] = $poid_date-> poid;
    }

    $i = 0;
    foreach($optionName2 as $op){
      if($op){
        $sql = "UPDATE product_options SET 
          cate = '$optionCate2',
          option_name = '$op',
          option_price = $optionPrice2[$i]
        ";

        //옵션2 이미지가 변경 되었다면
        if (isset($_FILES['optionImage2']) && $_FILES['optionImage2']['error'][$i] == UPLOAD_ERR_OK)  {

            $uploadfile = $_FILES['optionImage2'];

            //파일 사이즈 검사
            if($uploadfile['size'][$i] > 10240000 ){
              echo "
              <script>
                alert('10MB이하만 첨부할 수 있습니다.');
                history.back();
              </script>
              ";
            }
            
            //파일 포멧 검사
            if(strpos($uploadfile['type'][$i], 'image') === false){
              echo "
              <script>
                alert('이미지만 첨부할 수 있습니다.');
                history.back();
              </script>
              ";
            }
            
            //파일 업로드
            $save_dir = $_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/upload/';
            $filename = $uploadfile['name'][$i]; //insta.jpg
            $ext = pathinfo($filename,PATHINFO_EXTENSION); //파일명의 확장자를 추출, jpg
            $newFileName = date('YmdHis').substr(rand(), 0, 6);//202410091717123456
            $savefile = $newFileName.'.'.$ext;//202410091717123456.jpg
            
            if(move_uploaded_file($uploadfile['tmp_name'][$i], $save_dir.$savefile)){
              $optImageUrl = '/abcmall/admin/upload/'.$savefile;  
            } else{
              echo "<script>
                alert('이미지를 첨부할 수 없습니다.');
              </script>";
            }

          $sql .= ", image_url = '$optImageUrl'";
        }
        $sql .= " WHERE cate = '$optionCate2' and poid = $poids[$i]";    
        $opt2_result = $mysqli->query($sql); 
        $i++;
      }
    }  
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