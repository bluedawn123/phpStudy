<pre>
  새배열 생성
  $배열명 = array();

  값을 할당
  $배열명[0] = "값";
</pre>

<?php
  $fruits = array(); //새배열 생성;
  $fruits[0] = '사과';
  $fruits[1] = '고구마';
  $fruits[2] = '딸기';
  $fruits[3] = '바나나';
  $fruits[4] = 'orange';
  
  echo $fruits[0];
  //echo $fruits 자체가 출력하고자 하면 이렇게 하는게 아니라 var_dump($fruits);

  var_dump($fruits)
  /*
  array (size=5)
  0 => string '사과' (length=6)
  1 => string '고구마' (length=9)
  2 => string '딸기' (length=6)
  3 => string '바나나' (length=9)
  4 => string 'orange' (length=6)
  */
?>
<pre>

<hr>

<pre>
  변수, 함수의 값의 존재여부 파악하는 함수 => isset (준비되어있니?)
  isset(대상) => true or false

</pre>
<?php
  $langs = array('html', 'css', 'javascript');
  echo $langs[0];  //html

  if(isset ($langs[3]) ){
    echo '$langs라는 배열에는 인덱스 번호3의 값은 있습니다.';
  
  } else{
    echo '$langs라는 배열에는 인덱스 번호3의 값은 없습니다. ';

  }

?>

</pre>

<h2>반복문</h2>
<pre>
  for(초기값; 조건; 증감){
    반복할일
  }
</pre>

<ul>
  <?php
    for($i = 0; $i < count($langs); $i++){   //php에선 length대신 count를 쓴다. 
      echo '<li>'.$langs[$i].'</li>';
    }
  
  ?>
</ul>
<h3>forEach</h3>
<pre>
  foreach(배열 as 배열의각요소){
    반복할일
  }
</pre>

<ul>
  <?php
    foreach($langs as $lang){
      echo '<li>'.$lang.'</li>';
      
    }
  
  ?>
</ul>

<h2>연관 배열</h2>
<pre>
  $배열명['키'] = '값'
  $배열명 = array('키' => 값, '키' => 값,'키' => 값,...)
</pre>
<?php
  $fruits_arr = array();
  $fruits_arr['apple'] = 1000;
  $fruits_arr['banana'] = 2000;
  $fruits_arr['orange'] = 3000;

  var_dump($fruits_arr);
  /*
  array (size=3)
  'apple' => int 1000
  'banana' => int 2000
  'orange' => int 3000
  */

  $fruits2_arr = array('apple2' => 10000, 'banana2' => 20000, 'orange' => 30000);
  echo $fruits2_arr['apple2'];  //10000
  var_dump($fruits2_arr);
  /*
  array (size=3)
  'apple2' => int 10000
  'banana2' => int 20000
  'orange' => int 30000
  */

  echo '<ul>';

  foreach($fruits2_arr as $key => $value){
    echo '<li>'.$key.$value.'</li>';   //아래 참조
  }

  echo '</ul>'

  /*
  apple210000
  banana220000
  orange30000
  */


?>


























