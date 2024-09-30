<?php
  setcookie('city', 'seoul', time()-60);
  //print_r($_COOKIE); Array ( [city] => seoul )
  //print_r($_COOKIE['city']); seoul

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>cookie</title>
</head>
<body>
  <h1>쿠키 삭제</h1>
  <pre>
    쿠키의 값은 seoul 입니다. 
    쿠키가 없습니다. 
  </pre>
  <?php  
    if (isset($_COOKIE['city'])) {
      echo "쿠키의 값은 " . $_COOKIE['city'] . "입니다.";
  } else {
      echo "쿠키가 없습니다.";
  }
  ?>
</body>
</html>