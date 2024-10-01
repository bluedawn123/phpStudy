<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');
print_r($_GET);
$num = $_GET['idx'];

$sql = "DELETE FROM board WHERE idx = '$num' ";


$result = mysqli_query($mysqli, $sql);

if($result){
  echo "<script>
    alert('글삭제 성공');
    location.href = '../index.php';
  </script>";
}else{
  echo "<script>
    alert('글삭제 실패');
    location.href = '../index.php';
  </script>";
}

?>