<?php
  require_once('config.php');

  $sql = "SELECT * FROM msg_board ORDER BY no DESC";
  $result = mysqli_query($mysqli, $sql);
  //★실행결과를 배열로 변경하는 함수

  // $list = '';
  // while($data = mysqli_fetch_row($result)){
  //   $list .= "<li><a href=\"\">{$data[1]}</a></li>";  $data[1]이 제목이니깐..
  // }

  // $list = '';
  // while($data = mysqli_fetch_assoc($result)){
  //   $list .= "<li><a href=\"\">{$data['title']}</a></li>";  
  // }

  // $list = '';
  // while($data = mysqli_fetch_array($result)){
  //   $list .= "<li><a href=\"\">{$data['title']}</a></li>";  
  // }

  $list = '';
  while($data = mysqli_fetch_object($result)){
    $list .= "<li><a href=\"read.php?no={$data->no}\">{$data->title}</a></li>";  
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>심플 게시판</title>
</head>
<body>
  <h1>심플 게시판</h1>
  <ul>
    <?= $list; ?>
  </ul>
  <hr>
  <a href="write.php">글쓰기</a>
</body>
</html>