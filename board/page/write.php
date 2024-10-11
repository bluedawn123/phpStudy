<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');
?>
<h1>글쓰기</h1>
<form action="write_ok.php" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="username" class="form-label">이름:</label>
    <input type="text" name="name" class="form-control" id="username" placeholder="이름을 입력해주세요." required>
  </div>
  <div class="mb-3">
    <label for="userpw" class="form-label">비밀번호:</label>
    <input type="password" name="pw" id="userpw" class="form-control" aria-describedby="passwordHelpBlock" required>
  </div>  
  <div class="mb-3">
    <label for="title" class="form-label">제목:</label>
    <input type="text" name="title" class="form-control" id="title" placeholder="글 제목" required>
  </div>  
  <div class="mb-3">
    <label for="content" class="form-label">내용:</label>
    <textarea name="content" class="form-control" id="content" rows="3"></textarea required>
  </div>
  <div class="mb-3">
    <label for="file" class="form-label">첨부파일:</label>
    <input type="file" name="attach" class="form-control" id="file">
  </div>    
  <div class="mb-3">
    <label for="lockpost" class="form-check-label">글 잠금</label>
    <input type="checkbox" name="lockpost" id="lockpost" class="form-check-input">
  </div>
  <button class="btn btn-primary">전송</button>
</form>
<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');
?>