<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');

$num = $_GET['idx'];
// print_r($num);

$sql = "SELECT * FROM board WHERE idx = $num ";
// $result = mysqli_query($mysqli, $sql);
$result = $mysqli->query($sql);

$data = $result->fetch_assoc();
//print_r($data);

$hit = $data['hit'] + 1;

//조회수 업데이트 => UPDATE 테이믈명 SET 컬럼명 = 값, 컬럼명 = 값 WHERE = 조건;
$hitsql = "UPDATE board SET hit = $hit WHERE idx = $num";
$mysqli->query($hitsql);

?>


<h1>글보기</h1>
<!-- 글제목 -->
<h2><?= $data['title']?></h2>
<p>
<?= $data['name']; ?> / <?= $data['date'];?> / 조회수 : <?= $hit;?> / 추천수 : <?= $data['likes'];?>
</p>
<hr>

<div>
<?= $data['content'];?>
</div>

<hr>
<div class="card" style="width: 25rem;">
  <div class="card-header">
    댓글 목록
  </div>  
  <ul class="list-group list-group-flush">
    <?php
    $sql = "SELECT * FROM reply WHERE b_idx = $num";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()) {
    ?>

    <li class="list-group-item d-flex justify-content-between">
      <div class="contents">
        <div class="content">
          <?= $row['content'] ?>
        </div>
        <small><?= $row['name'] ?>/<?= $row['date'] ?></small>
      </div>
      <div class="controls">
        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#reply_edit<?=$row['idx']?>">수정</button>
        <button class="btn btn-danger btn-sm">삭제</button>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="reply_edit<?=$row['idx']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form action="reply_modify_ok.php" class="modal-content" method="POST">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">댓글 수정</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"> <!--1번 댓글 수정 폼(양식)-->
              <label for="password01" class="form-label">비밀번호 : </label>
              <input type="password" id="password01" name="pw" class="form-control">
              <textarea name="content" class="form-control mt-3"> <?= $row['content'] ?> </textarea>
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
<h3>댓글달기</h3>
<form action="reply_ok.php" method="POST">
  <input type="hidden" name="idx" value="<?= $num; ?>"> <!--글번호 히든으로 넘김-->
  <div class="form-floating mb-3">
    <input type="text" class="form-control" id="name" placeholder="your name" name="name">
    <label for="name">Name : </label>
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