<?php

require_once('config.php');
//print_r($_POST);
$num = $_POST['number'];
$username = $_POST['name'];
$title = $_POST['title'];
$message = $_POST['message'];

// $sql = "INSERT INTO msg_board (title, message, name) VALUES('$title', '$message', '$username')";

//db 수정 ""UPDATE msg_board SET 컬렴명 = 값, 컬럼명 = 값 WHERE no = $num";";
$sql = "UPDATE msg_board SET name = '$username', title = '$title', message='$message' WHERE no = $num";
// echo $sql; UPDATE msg_board SET name = '윤태선', title = '안녕하세요2', message='아빠다' WHERE no = 3

$result = mysqli_query($mysqli, $sql);

if($result){
  echo "<script>
    alert('글수정 성공');
    location.href = 'index.php';
  </script>";
}else{
  echo "<script>
    alert('글수정 실패');
    history.back();
  </script>";
}
?>