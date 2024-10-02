<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');
//print_r($_POST);
$num = $_POST['number'];
$username = $_POST['name'];
$title = $_POST['title'];
$content = $_POST['content'];


//db 수정 ""UPDATE 테이블명 SET 컬렴명 = 값, 컬럼명 = 값 WHERE no = $num";";
$sql = "UPDATE board SET name = '$username', title = '$title', content='$content' WHERE idx = $num";


$result = $mysqli->query($sql);

if($result){
  echo "<script>
    alert('글수정 성공');
    location.href = '../index.php';
  </script>";
}else{
  echo "<script>
    alert('글수정 실패');
    location.href = '../index.php';
  </script>";
}
?>