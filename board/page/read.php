<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');
  $idx = $_GET['idx'];

  $sql = "SELECT * FROM board WHERE idx = $idx";
  $result = $mysqli->query($sql);
  $data = $result->fetch_assoc();
  //print_r($data);
  $hit = $data['hit'] + 1;

  // 업데이트
  // UPDATE 테이블명 SET 컬럼명 = 값, 컬럼명 = 값 WHERE 조건;
  $hitSql = "UPDATE board SET hit = $hit WHERE idx = $idx";
  $mysqli->query($hitSql);
?>
<h1>글보기</h1>
<!-- 글제목 -->
<h2></h2>
<p>
  <?= $data['name']; ?> / 
  <?= $data['date']; ?>  / 
  조회수 :<?= $hit; ?> / 
  추천수 : <?= $data['likes']; ?>
</p>
<hr>
<!-- 글본문 -->
<div>
  <?= $data['content']; ?>
  <?php
    echo $data['is_img'];

    if($data['is_img'] == 1){
      echo "<br><img src=\"{$data['file']}\" width=\"300\">";
    } else {
      echo "<hr>";
      echo "첨부파일: <a href=\"{$data['file']}\">다운로드</a>";
    }
  ?>    
</div>
<hr>
<div class="d-flex justify-content-between align-items-center">
  <a href="../index.php" class="btn btn-secondary">목록 </a>
  <div>
    <a href="delete.php?idx=<?= $data['idx']; ?>" class="btn btn-danger">삭제</a>
    <a href="modify.php?idx=<?= $data['idx']; ?>" class="btn btn-info">수정</a>
    <a href="thumbup.php?idx=<?= $data['idx']; ?>" class="btn btn-info">추천</a>
  </div>
</div>
<hr>
<div class="card" style="width: 25rem;">
  <div class="card-header">
    댓글 목록
  </div>
  <ul class="list-group list-group-flush">
    <?php
      $sql = "SELECT * FROM reply WHERE b_idx = $idx";        
      $result = $mysqli->query($sql);

      while($row = $result->fetch_assoc()){
    ?>
    <li class="list-group-item d-flex justify-content-between">
      <div class="contents">
        <div class="content">
          <?= $row['content'] ?>
        </div>
        <small><?= $row['name'] ?>/<?= $row['date'] ?></small>
      </div>
      <div class="controls">
        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#reply_edit<?= $row['idx'] ?>">수정</button>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reply_delete<?= $row['idx'] ?>">삭제</button>
      </div>
      <!-- Edit Modal -->
      <div class="modal fade" id="reply_edit<?= $row['idx'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form action="reply_modify_ok.php" method="POST" class="modal-content">
            <input type="hidden" name="r_no" value="<?= $row['idx'] ?>">
            <input type="hidden" name="b_no" value="<?= $idx ?>">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">댓글 수정</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <label for="password01" class="form-label">비밀번호: </label>
              <input type="password" id="password01" name="pw" class="form-control">
              <textarea name="content" class="form-control mt-3"><?= $row['content'] ?></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
              <button type="submit" class="btn btn-primary">확인</button>
            </div>
          </form>
        </div>
      </div>
      <!-- Delete Modal -->
      <div class="modal fade" id="reply_delete<?= $row['idx'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form action="reply_delete_ok.php" method="POST" class="modal-content">
            <input type="hidden" name="r_no" value="<?= $row['idx'] ?>">
            <input type="hidden" name="b_no" value="<?= $idx ?>">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">댓글 삭제</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <label for="password01" class="form-label">비밀번호: </label>
              <input type="password" id="password01" name="pw" class="form-control">              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
              <button type="submit" class="btn btn-primary">확인</button>
            </div>
          </form>
        </div>
      </div>      
    </li>
    <?php
      }
    ?>
  </ul>
</div>
<hr>
<h3>댓글 달기</h3>
<form action="reply_ok.php" method="POST">
  <input type="hidden" name="idx" value="<?= $idx; ?>">
  <div class="form-floating mb-3">
    <input type="text" class="form-control" id="name" placeholder="Your name" name="name" >
    <label for="name">Name:</label>
  </div>
  <div class="form-floating mb-3">
    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
    <label for="floatingPassword">Password</label>
  </div>
  <div class="form-floating mb-3">
    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="content"></textarea>
    <label for="floatingTextarea2">Comments</label>
  </div>  
  <button class="btn btn-primary btn-sm">확인</button>
</form>

<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');
?>