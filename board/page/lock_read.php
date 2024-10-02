<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');

$idx = $_GET['idx'];
// print_r($num);

$sql = "SELECT pw FROM board WHERE idx = $idx ";
$result = $mysqli->query($sql);
$data = $result->fetch_assoc();
//print_r($data);

$orgpw = $data['pw'];
//echo $orgpw; 암호화된 기본 비번

//비번 확인해보기. 지금 입력한 비번
if(isset($_POST['pw_chk'])){
  $pwchk = $_POST['pw_chk'];
  
  //일치여부 확인 =>★ password_verify함수 사용. true or false로 일치여부 말해줌
  //참이면 본문을 볼수 있게끔, 아니면 안 보이게
  if(password_verify($pwchk, $orgpw)){
    echo "<script>
      alert('비밀번호가 일치합니다.');
      window.location.replace('read.php?idx={$idx}');
    </script>";

  }else{
    echo "<script>
      alert('비밀번호 오류입니다. 초기 페이지로 돌아갑니다.');
      window.location.replace('../index.php');
    </script>";

  }
}

?>


<h1>비밀번호 확인</h1>
<!-- Modal -->
<div class="modal fade" id="password_confirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" action="" method="POST">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">비밀번호 확인</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="password" class="form-control" name="pw_chk">
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




