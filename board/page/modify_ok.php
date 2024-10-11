<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/db.php');
  
  $idx = $_POST['idx'];
  $username = $_POST['name'];
  $title = $_POST['title'];
  $content = $_POST['content'];

  $sql = "UPDATE board set name='$username', title='$title', content='$content' WHERE idx = $idx";
  $result = $mysqli->query($sql);

  if($result){
    echo "<script>
      alert('수정성공');
      location.href = '../index.php';
    </script>";
  }else{
    echo "<script>
      alert('수정실패');
      location.href = '../index.php';    
    </script>";
  }
?>