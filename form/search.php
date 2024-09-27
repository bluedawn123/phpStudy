<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>search</title>
</head>
<body>
  <h1>검색결과</h1>
  <?php
    print_r($_GET);  //Array ( [keyword] => dfsfsfsfsf )
  ?>
  <p>당신의 입력한 검색어는 <?php echo $_GET['keyword']; ?>의 결과입니다. </p>
</body>
</html>