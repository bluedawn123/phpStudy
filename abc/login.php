<?php
  $title = 'Login';

  include_once('header.php');
  // require_once('header.php');

?>
  <main>
    <section>
      <h2>LogIn</h2>
      <form action="login_ok.php" method="POST">
        <div>
          <label for="useremail">Email:</label>
          <input type="email" name="useremail" id="useremail" placeholder="your email">
        </div>
        <div>
          <label for="userpw">password:</label>
          <input type="password" name="userpw" id="userpw" placeholder="your password">
        </div>
        <button>로그인</button>
      </form>
    </section>
  </main>
  <?php
  include('footer.php');
?>