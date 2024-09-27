<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>리퀘스트</title>
</head>
<body>
  <h1>Request</h1>
  <?php
    print_r($_POST); //Array ( [name] => 윤준호 [email] => yoon@junho.com )
    echo $_POST['name'];  //윤준호
    echo $_POST['email']; //윤준호yoon@junho.com

  ?>
  <p><?php echo $_POST['name']; ?>님의 이메일 주소는<?php echo $_POST['email']; ?> 입니다."</p>

</body>
</html>