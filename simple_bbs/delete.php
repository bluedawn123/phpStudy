<?php

require_once('config.php');
print_r($_GET);
$num = $_GET['no'];

$sql = "DELETE FROM msg_board WHERE no = '$num' ";


$result = mysqli_query($mysqli, $sql);

if($result){
  echo "<script>
    alert('글삭제 성공');
    location.href = 'index.php';
  </script>";
}else{
  echo "<script>
    alert('글삭제 실패');
    history.back();
  </script>";
}

?>