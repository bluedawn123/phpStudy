<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');
  $idx = $_GET['idx'];

  $sql = "SELECT pw FROM board WHERE idx = $idx";
  $result = $mysqli->query($sql);
  $data = $result->fetch_assoc();
  //print_r($data);
  $orgpw = $data['pw'];
  //echo $orgpw;

  if(isset($_POST['pw_chk'])){
    $pwchk =  $_POST['pw_chk'];

    if(password_verify($pwchk, $orgpw)){ //일치 여부 확인
      echo "<script>
        window.location.replace('read.php?idx={$idx}');
      </script>";
    } else{
      echo "<script>
        window.location.replace('../index.php');
      </script>";
    }
  }
?>
<h1>비밀번호 확인</h1>

<!-- Modal -->
<div class="modal fade" id="password_confirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" method="POST" class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">비밀번호 확인</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="password" name="pw_chk" class="form-control">
        
      </div>
      <div class="modal-footer">        
        <input type="submit" value="확인" class="btn btn-primary">         
      </div>
    </form>
  </div>
</div>

<script>
const myModal = new bootstrap.Modal('#password_confirm', {
  keyboard: false
})
const modalToggle = document.getElementById('password_confirm'); 
myModal.show(modalToggle);
</script>


<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');
?>