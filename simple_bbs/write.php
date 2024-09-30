<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>심플 게시판</title>
</head>
<body>
  <h1>글 입력</h1>
  <form action="insert.php" method="POST">
    <div>
      <label for="username">이름 : </label>
      <input type="text" id="username" name="name">
    </div>
    <div>
      <label for="usertitle">제목 : </label>
      <input type="text" id="usertitle" name="title">
    </div>
    <div>
      <label for="usermsg">메세지 : </label>
      <textarea name="message" id="usermsg"></textarea>
    </div>
    <input type="submit" value="전송">
  </form>
  <hr>
  <a href="write.php">글쓰기</a>
</body>
</html>