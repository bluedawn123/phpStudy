<!-- read.php에 있는 정보들이 일로 넘어와야 한다. -->
<?php
  require_once('config.php');

  $num = $_GET['no']; //num으로 no변수를 받음
  print_r($num);

  $sql = "SELECT * FROM msg_board WHERE no = $num ";
  $result = mysqli_query($mysqli, $sql);

  //데이터 확인. 4가지 방법중 하나!
  $data = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>심플 게시판</title>
</head>
<body>
  <h1>글 입력</h1>
  <form action="update_ok.php" method="POST">
    <input type="hidden" name="number" value="<?= $num; ?>">
    <div>
      <label for="username">이름 : </label>
      <input type="text" id="username" name="name" value="<?= $data['name']; ?>">
    </div>
    <div>
      <label for="usertitle">제목 : </label>
      <input type="text" id="usertitle" name="title" value="<?php echo $data['title']; ?>">
    </div>
    <div>
      <label for="usermsg">메세지 : </label>
      <textarea name="message" id="usermsg"><?php echo $data['message']; ?></textarea>  <!--원본글은 사이에 나와야함-->
    </div>
    <input type="submit" value="전송">
  </form>
  <hr>
  <a href="write.php">글쓰기</a>
</body>
</html>