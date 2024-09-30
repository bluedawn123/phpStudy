<?php
  session_start(); //세션관련 함수 시작
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Session</title>
</head>
<body>
  <h1>세션</h1>
  <pre>
    세션 생성
    $_SESSION['key'] = '값'
  </pre>
  <?php
    $_SESSION['city'] = 'seoul'; //세션값 확인
    $_SESSION['gu'] = 'jongro';

    print_r($_SESSION);  //Array ( [city] => seoul [gu] => jongro ) 아파치 프로그램 안에서 볼수있따. xampp/temp/...
    echo $_SESSION['city'];
  ?>
  <h2>세션 확인</h2>
  <pre>
    $_SESSION['key']
  </pre>
  <h2>세션 삭제</h2>
  <pre>
    세션변수 할당 해지 => session_unset();
    세션 아이디 삭제 => session_destroy(); => 세션 자체(아이디) 삭제
    <?php
    session_unset();
    //echo $_SESSION['city'];  Undefined array key "city" in C:\xampp\htdocs\session\index.php on line 34
    print_r($_SESSION);

    session_destroy();
    print_r($_SESSION)

    ?>
  </pre>
</body>
</html>