<?php

require_once('config.php');

print_r($_POST); //Array ( [name] => 홍길동 [title] => 안녕하세요 [message] => 너무 졸려요 )

$username = $_POST['name'];
$title = $_POST['title'];
$message = $_POST['message'];
$sql = "INSERT INTO msg_board (title, message, name) VALUES('$title', '$message', '$username')";

$result = mysqli_query($mysqli, $sql);

if($result){
  echo "<script>
    alert('글쓰기 성공');
    location.href = 'index.php';
  </script>";
}else{
  echo "<script>
    alert('글쓰기 실패');
    history.back();
  </script>";
}
?>