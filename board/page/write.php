<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');
?>


<h1>글쓰기</h1>
<form action="write_ok.php" method="POST">
  <div class="mb-3">
    <label for="username" class="form-label">이름 : </label>
    <input type="text" name="name" class="form-control" id="username" placeholder="이름" required>
  </div>
  <div class="mb-3">
    <label for="userpw" class="form-label">비밀번호 : </label>
    <input type="password" name="pw" id="userpw" class="form-control" aria-describedby="passwordHelpBlock" required>
  </div>
  <div class="mb-3">
    <label for="title" class="form-label">제목 : </label>
    <input type="text" name="title" class="form-control" id="title" placeholder="글 제목" required>
  </div>
  <div class="mb-3">
    <label for="content" class="form-label">내용 : </label>
    <textarea name="content" class="form-control" id="content" rows="3" required></textarea>
  </div>
  <div class="mb-3">
    <label class="form-check-label" for="lockpost">글 잠금</label>
    <input class="form-check-input" type="checkbox" id="lockpost" name="lockpost">
  </div>
  <button class="btn btn-primary">전송</button>

</form>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');

?>