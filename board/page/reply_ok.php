<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/db.php');

  $idx = $_POST['idx']; //게시글의 글번호
  $userpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $name = $_POST['name'];
  $content = $_POST['content'];
  $sql = "INSERT INTO reply (b_idx, name, password, content) VALUES ($idx, '$name', '$userpw', '$content')";

  $result = $mysqli->query($sql);
  if($result){
    echo "<script>
      alert('작성 완료');
      location.href = '../index.php';
    </script>";
  }else{
    echo "<script>
      alert('작성 실패');
      location.href = '../index.php';
    </script>";
  }
?>