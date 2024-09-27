<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>01 Syntax</title>
</head>
<body>
  <h2>문법1</h2>
  <h3>1-1</h3>
  <?php
    echo "hello world";
  ?>
  
  <h3>1-2</h3>
  <?php
    echo " 'hello world' ";

  ?>

  <h3>1-3</h3>
  <p> <?= "hello world"  ?></p>
  <hr>

  <h3>1-4</h3>

  <h4>1-4-1</h4>
  <?php
    $name = '홍길동';
    echo  "$name"."님 안녕하세요";  //안녕하세요홍길동님
  ?>

  <h4>1-4-2</h4>
  <p>
    <?php 
    $name = "홍길동";
    echo "'$name'님 반갑습니다.";
    ?>
  </p>
  <h3>1-5</h3>
  <p>변수 x에 5, 변수 y에 7, 변수 sum에 x와 y의 합을 할당하고 출력</p>
  <?php

  function add($x, $y){
    $sum = $x + $y;
    return $sum;
  }

  $result = add(5,7);
  echo $result;

  ?>  
</body>
</html>

