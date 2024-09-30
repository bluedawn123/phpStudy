<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>03 조건문</title>
</head>
<body>
  <h2>조건문</h2>
  <h3>1-1</h3>
  <p>변수명 a가 b보다 크다면 '참입니다.' 출력</p>
  <?php
    $a = 1; 
    $b = 0;

    if($a > $b){
      echo "참입니다.";
    }else{
      echo "거짓입니다.";
    }
  ?>


  <h3>1-2</h3>
  <p>변수명 a와 b가 다르다면 '두 값은 다릅니다.' 출력</p>
  <?php
    if($a =! $b){
      echo "두 값은 다릅니다..";
    }else{
      echo "두 값은 같은 값입니다.";
    }
  ?>  


  <h3>1-3</h3>
  <p>변수명 a와 b가 같다면 '같다' 아니면 '다르다' 출력</p>
  <?php

  if($a == $b){
    echo "두 값은 같습니다..";
  }else{
    echo "두 값은 다른 값입니다.";
  }
  ?>    


  <h3>1-4</h3>
  <p>변수명 a와 b가 같다면 '같다', 아니고 a가 b보다 크다면 'a가 크다', 그것도 아니라면 'b가 크다' 출력</p>
  <?php

  if($a == $b){
    echo "두 값은 같습니다..";
  }else if($a > $b){
    echo "a가 크다";
  }else{
    echo "b가 크다";
  }
  ?>     
</body>
</html>

