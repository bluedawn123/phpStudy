<?php
  require_once('config.php');

  $num = $_GET['no']; //num으로 no변수를 받음
  print_r($num);

  $sql = "SELECT * FROM msg_board WHERE no = $num ";
  $result = mysqli_query($mysqli, $sql);

  //데이터 확인. 4가지 방법중 하나!
  $data = mysqli_fetch_row($result);
  print_r($data);

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글 상세 - 심플 게시판</title>
</head>
<body>
  <h2>글 상세</h2>
  <h3>글 제목 : <?= $data[1]?></h3>
  <h4>글쓴이 : <?= $data[3]?></h4>
  <h5>날짜 : <?= $data[4]?></h5>
  <div>
    <!-- 글 상세 출력 -->
    <?= $data[2]?>
  </div>
  <hr>
  <a href="index.php">글목록</a>
</body>
</html>