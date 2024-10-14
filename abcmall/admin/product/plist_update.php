<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$pid = $_GET['pid'];
// echo $pid; 배열로 온건 echo로 불가
//print_r($pid); Array ( [0] => 12 [1] => 13 [2] => 14 [3] => 15 )

//해당값이 없으면 빈배열
$ismain = $_GET['ismain'] ?? [];
$isnew = $_GET['isnew'] ?? [];
$isbest = $_GET['isbest'] ?? [];
$isrecom = $_GET['isrecom'] ?? [];
$status = $_GET['status'] ?? [];

// $sql = "UPDATE products SET ismain = $ismain[6], isnew = $isnew[6] WHERE pid = 6";
// $sql = "UPDATE products SET ismain = $ismain[7], isnew = $isnew[7] WHERE pid = 7";
// $sql = "UPDATE products SET ismain = $ismain[8], isnew = $isnew[8] WHERE pid = 8";
// $sql = "UPDATE products SET ismain = $ismain[9], isnew = $isnew[9] WHERE pid = 9";

foreach($pid as $p){
  $ismain[$p] = $ismain[$p] ?? 0;  //있으면 그거쓰고 없으면 0 씀
  $isnew[$p] = $isnew[$p] ?? 0;
  $isbest[$p] = $isbest[$p] ?? 0;
  $isrecom[$p] = $isrecom[$p] ?? 0;
  $status[$p] = $status[$p] ?? 0;

  $sql = "UPDATE products SET 
    ismain = $ismain[$p], 
    isnew = $isnew[$p], 
    isbest = $isbest[$p], 
    isrecom = $isrecom[$p], 
    status = $status[$p] 
    WHERE pid = $p";

  // echo $sql;
  $result = $mysqli->query($sql);
}

if($result){
  echo"
  <script>
    alert('일괄 수정되었습니다.');

    //변경사항을 바로 볼수 있도록.
    location.href = 'product_list.php';
  </script>
  ";
}else{
  echo"
  <script>
    alert('일괄 수정 실패.');
    history.back();
  </script>
  ";
}

echo "<pre>";
echo "pid";
print_r($pid);
echo "ismain";
print_r($ismain);
echo "isnew";
print_r($isnew);
echo "isbest";
print_r($isbest);
echo "isrecom";
print_r($isrecom);
echo "status";
print_r($status);
echo "</pre>";

?>