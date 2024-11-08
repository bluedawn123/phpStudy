<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$pid = $_GET['pid'];
$ismain = $_GET['ismain'] ?? [];
$isnew = $_GET['isnew'] ?? [];
$isbest = $_GET['isbest'] ?? [];
$isrecom = $_GET['isrecom'] ?? [];
$status = $_GET['status'] ?? [];

foreach($pid as $p){
  $ismain[$p] =  $ismain[$p] ?? 0;
  $isnew[$p] =  $isnew[$p] ?? 0;
  $isbest[$p] =  $isbest[$p] ?? 0;
  $isrecom[$p] =  $isrecom[$p] ?? 0;
  $status[$p] =  $status[$p] ?? 0;

  $sql = "UPDATE products SET 
    ismain = $ismain[$p], 
    isnew = $isnew[$p], 
    isbest = $isbest[$p], 
    isrecom = $isrecom[$p], 
    status = $status[$p] 
  WHERE pid = $p";

  $result = $mysqli->query($sql);  
}

if($result){
  echo "<script>
    alert('일괄 수정 되었습니다.');
    location.href='product_list.php';
  </script>";
} else{
  echo "<script>
    alert('일괄 수정 실패');
    history.back();
  </script>";
}

