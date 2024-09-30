<?php
  $title = 'Login';
  session_start(); //세션관련 함수 시작

  //세션 생성
  $_SESSION['useremail'] = $_POST['useremail'];


  include_once('header.php');
  // require_once('header.php');
  
  print_r($_POST); //Array ( [useremail] => yoon@hong.com [userpw] => 123123 )
  //login.php에서 입력한 정보가 나온다. 

  

  
?>
  <main>
    <section>
      <h2>LogIn 완료</h2>  
      <p><?= $_POST['useremail'] ?>님 반갑습니다.</p>
    </section>
  </main>
  <?php
  include('footer.php');
?>