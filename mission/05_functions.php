<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>05 함수</title>
</head>
<body>
  <h2>함수</h2>
  <h3>1-1</h3>
  <p>echo 'hello world'를 실행하는 함수 myFunction을 작성하고 실행</p>
  <?php  

  ?>
  <h3>1-2</h3>
  <p>함수 myFunc 매개변수 x, y를 입력하고 첫번째 매개변수 x의 값을 echo하는 함수를 작성, myFunction 함수에 인수 10,20입력하여 실행</p>
  <?php  

  ?>
  <h3>1-3</h3>
  <p>sum 함수에 인수 10, 20을 입력하여 실행하면 합계를 출력하는 sum 함수를 작성</p>
  <?php
  //함수는 입력, 할일,  출력
  //sum 함수 작성


    $result = sum(10,20);
    echo $result;
    ?>
  <h3>1-4</h3>
  <p>변수명 $lang을 출력하는 부분에서 에러가 발생하고 있다. 함수안에서 $lang 변수를 사용할 수 있도록 수정.</p>
  <?php
    $lang = 'php';

    function study($a, $b){
     //$lang 변수를 사용할 수 있도록 코드 작성

      echo $lang;
        $result = $a . $b;
        return $result;
    }
    $result = study('웹','프로그래밍');
    echo $result;
    ?>
</body>
</html>

