<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>02 String</title>
</head>
<body>
  <h2>문자열</h2>
  <h3>1-1</h3>
  <p>'Hello World!'문자열의 개수를 출력</p>
  <?php
    $string = "hello world!";
    echo strlen($string);  // 12
    echo strlen('가나다라'); //12
    echo mb_strlen('가나다라'); //4
    echo mb_strlen('abcde'); //5
    echo iconv_strlen('가나다라'); //4
  ?>
  <hr>

  <h3>1-2</h3>
  <p>'Hello World!'문자열에서 world를 universe로 변경</p>
  <?php
    $oldtext = 'hello world!';
    $newtxt = str_replace('world', 'universe', $oldtext);
    echo $newtxt;
  ?>
  <hr>



  <h3>1-3</h3>
  <p>'   Hello World!'문자열에서 앞의 공백 제거</p>
  <?php
    $text = 'Hello world!';
    $newtxt = ltrim($text);
    echo $newtxt;
  ?>
  <hr>


  <h3>1-4</h3>
  <p>'   Hello World!     '문자열에서 앞, 뒤의 공백 제거</p>
  <?php
    $text = '    Hello world!    ';
    $newtxt = trim($text);
    echo $newtxt;
  ?>
  <hr>


  <h3>1-5</h3>
  <h3>1-5-1</h3>
  <p>'Hello_World' 문자열을 배열로 변경하여 변수 strArr에 할당하고 출력</p>
  <?php
    $text = 'Hello_World';
    $strArr = str_split($text);
    //지시화면과 같이 출력되도록 작성
    print_r($strArr); //Array ( [0] => H [1]...=> l [10] => d )
  ?> 
  <hr>

  <h3>1-5-2</h3>
  <p>'Hello_World' 문자열을 배열로 변경하여 변수 strArr에 할당하고 출력</p>
  <?php
    //지시화면과 같이 출력되도록 작성
    var_dump($strArr);
  ?>
  <hr>

</body>
</html>

