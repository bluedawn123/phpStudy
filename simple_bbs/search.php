<?php
 require_once('config.php');
 $keyword = $_GET['keyword'];

 $sql = "SELECT * FROM msg_board WHERE title LIKE '%$keyword%' ORDER BY no DESC";

 $result = mysqli_query($mysqli, $sql);

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
  <title>검색결과 - 심플 게시판</title>
</head>
<body>
  <h1>검색 결과</h1>
  <hr>
  <ul>
    <?= $list; ?>
  </ul>
  <hr>
  <a href="write.php">글쓰기</a>
</body>
</html>