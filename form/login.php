<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>로그인</title>
</head>
<body>
  <h1>Login FOrm</h1>
  <form action="request.php" method="POST">
    <div>
      <label for="name">Name</label>
      <input type="text" name="name" id="name" placeholder="Your Name">
    </div>
    <div>
      <label for="email">email</label>
      <input type="email" name="email" id="email" placeholder="Your Email">
    </div>
    <button>로그인</button>
  </form>
  <form action="search.php">
    <input type="text" name="keyword">
    <input type="submit" value="검색">
  </form>
</body>
</html>