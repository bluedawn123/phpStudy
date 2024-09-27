<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>php기초</title>
</head>
<body>
  <?php
  echo "hello world";
  ?>
  <pre>
  한줄주석1 //
  여러줄 주석 /* */
  한줄주석2 쉘 스타일  #

  </pre>
  <h2>변수생성</h2>
  <pre>
    $변수명 
    $name = '홍길동'
    ★★문자와 변수를 연결할때 .을 쓴다. 
    ★★""(큰따옴표)가 자바스크립트의 백틱처럼 사용된다. 문자와 변수가 같이 사용될때 쓴다. echo "안녕! $name"; 이런식으로.
    ''(작은따옴표)는 안된다!
  </pre>

<p>
    <?php
    $hello = "안녕하세요";
    $name = '홍길동';
    // echo $name;
  
    // echo '안녕하세요! '.$name. '님';  => 안녕하세요! 홍길동님
    // echo "안녕! $name";  => 안녕! 홍길동
    // echo '안녕! $name';  => 안녕! $name
  
    echo  $name. "$hello.님";  //홍길동안녕하세요.님
  
  
    ?>
</p>




</body>
</html>