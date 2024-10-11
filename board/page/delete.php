<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/db.php');

  $idx = $_GET['idx'];
  $sql = "DELETE FROM board WHERE idx = $idx";

  if($mysqli->query($sql) === true){
    echo "<script>
      alert('글삭제 완료');
      location.href = '../index.php';
    </script>";
  }else{
    echo "<script>
      alert('글삭제 실패');
      location.href = '../index.php';
    </script>";
  }
?>