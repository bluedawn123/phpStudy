<?php
  $title = 'Mypage';
  session_start(); //세션관련 함수 시작
  include_once('header.php');
  
?>
  <main>
    <section>
      <h2>My page</h2>  
      <?php
          if(isset($_SESSION['useremail'])){
      ?>
      <p><?= $_SESSION['useremail'] ?>님의 회원정보 입니다.</p>      
      <?php
          } else{
            ?>
            <p>로그인 먼저 해주세요.</p>   
            <?php
          }
      ?>
    </section>
  </main>
  <?php
  include('footer.php');
?>