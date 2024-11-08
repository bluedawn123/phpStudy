<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/inc/header.php');
?>

<div class="container">
  <h2>회원 로그인</h2>
  <form action="login_ok.php" method="POST">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="userid" name="userid" placeholder="User ID">
      <label for="userid">User ID</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="userpw" name="userpw" placeholder="Password">
      <label for="userpw">Password</label>
    </div>
    <button class="btn btn-primary mt-3">로그인</button>
  </form>
</div>

<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/inc/footer.php');
?>
