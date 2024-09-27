<h2>while</h2>
<pre>
  초기값
  while(조건){
    할일
    증감
  }
</pre>

<?php
 $i = 0;
  while($i <= 5){
    echo $i.'<br>';
    $i++;
  }


  $langs = array('html', 'css', 'javascript');
  $i = 0;
  
  echo '<ul>';
  while( $i < count($langs) ){ // '<'로 수정
    echo '<li>'.$langs[$i].'</li>';
    $i++;
  }
  echo '</ul>';

?>



<h2>Do while</h2>
<pre>
  do{
    할일
    while(조건);
  }
</pre>

<?php

$a = 0;
do{
  echo $a++.'<br>';
}while($a <= 5);

$langs = array('html', 'css', 'javascript');
$i = 0;

echo '<ul>';
do {
  echo '<li>'.$langs[$i].'</li>'; // 출력 후에 $i 증가
  $i++;
} while($i < count($langs)); // 조건문 수정 없음
echo '</ul>';
?>


<h2>foreach</h2>
<pre>
  foreach(원본 as 각원소){
    할일;
  }

</pre>
<?php
  $nums = array(0,2,4,6,8);
  foreach($nums as $num){
    echo "변수 \$num 의 현재값은 {$num} 입니다.<br>";
  }
?>