<?php
  $title = 'Login';

  //logout 관련 이벤트 관리
  session_start(); //세션시작
  session_unset(); //등록된 세션변수 해지
  session_destroy(); //세션 자체 삭제


  include_once('header.php');
?>
  <main>
    <section>
      <h2>로그아웃</h2>  
      <p>로그아웃 되었습니다. </p>
      <a href="index.php">home</a>
    </section>
  </main>
  <?php
  include('footer.php');
?>