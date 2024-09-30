<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>03 Array</title>
</head>
<body>
  <h2>배열</h2>
  <h3>1-1</h3>
  <p>빈 배열 $langs를 만들고 0번째 html, 1번째 css, 세번째 javascript를 할당하고 두번째 값을 출력한다.</p>  
  <?php
    $langs = array();   // 빈 배열 생성
    $langs[0] = 'html'; // 인덱스 번호 0에 값 할당
    $langs[1] = 'css';  // 인덱스 번호 1에 값 할당
    $langs[2] = 'javascript'; // 인덱스 번호 2에 값 할당

    echo $langs[1]; // 인덱스 번호 1에 해당하는 값 출력 (css)
    ?>

  <h3>1-2</h3>
  <p>배열 $langs를 만들고 0번째 html, 1번째 css, 세번째 javascript를 할당하고 두번째 값을 출력한다.</p>  
  <?php
    $langs = array('html', 'css', 'javascript'); // 배열 생성과 값 생성

    echo $langs[1];
  ?>


  <h3>1-3</h3>
  <p>배열 $langs의 값을 리스트 태그로 출력</p>
  <ul>
  <?php
  //$langs = ;   배열 생성과 값 생성

  //foreach활용

  ?>
  </ul>    
  <h3>1-4</h3>
  <p>빈 배열 langs를 생성하고, 연관배열의 키값 '구조'에 'html', 키값 '스타일'에 'css', 키값 '동적요소'에 javascript을 할당하고 출력한다.</p>

  <?php
    $langs = array();        
    //연관 배열 생성
    $langs['구조'] = 'html';
    $langs['스타일'] = 'css';
    $langs['동적요소'] = 'javascript';
    
    //foreach활용 key과 value 출력
    foreach($langs as $lang){
      echo "<li>{$lang}</li>";
    }

  ?>


  <h3>1-5</h3>
  <p>배열 langs를 생성하고, 연관배열의 키값 '구조'에 'html', 키값 '스타일'에 'css', 키값 '동적요소'에 javascript을 할당하고  javascript를 출력한다.</p>

  <?php
    // 배열 생성과 값 생성        
    //'동적요소'의 value 출력
    $langs = array();        
    //연관 배열 생성
    $langs['구조'] = 'html';
    $langs['스타일'] = 'css';
    $langs['동적요소'] = 'javascript';
    
    //'동적요소'의 value 출력
    echo "<li>{$langs['동적요소']}</li>";
  ?>
</body>
</html>

