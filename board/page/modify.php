<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');

  $idx = $_GET['idx'];
  $sql = "SELECT * FROM board WHERE idx = $idx";
  $result = $mysqli->query($sql);
  $data = $result->fetch_assoc();
?>
<h1>글수정</h1>
<form action="modify_ok.php" method="POST">
  <input type="hidden" name="idx" value="<?= $data['idx'];?>">
  <div class="mb-3">
    <label for="username" class="form-label">이름:</label>
    <input type="text" name="name" class="form-control" id="username" placeholder="이름을 입력해주세요." required value="<?= $data['name'];?>">
  </div> 
  <div class="mb-3">
    <label for="title" class="form-label">제목:</label>
    <input type="text" name="title" class="form-control" id="title" placeholder="글 제목" required value="<?= $data['title'];?>">
  </div>  
  <div class="mb-3">
    <label for="content" class="form-label">내용:</label>
    <textarea name="content" class="form-control" id="content" rows="3"><?= $data['content'];?></textarea required>
  </div>
  <button class="btn btn-primary">전송</button>
</form>
<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');
?>