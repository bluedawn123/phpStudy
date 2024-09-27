<h2>배열</h2>

<pre>
비교연산자는 true or false. true면 1, false는 0
xor 앞, 뒤 조건이 '다를때만!!!! 참!!' 앞조건도 참, 뒤 조건도 참이면 거짓이다. 앞이참 뒤가거짓, 앞이거짓, 뒤가참 ==> 참

</pre>

<?php
  $result = 1<3;  //비교연산자는 true or false. true면 1, false는 0
  echo $result == true;   //1
  echo $result == false;  //아무것도 안나옴.

  $first_name = '길동';
  $last_name = '홍';

  if($first_name == '길동' && $last_name == '홍'){
    echo '조건이 참이다.';
  } else {
    echo '조건이 거짓이다.';
  }
?>

