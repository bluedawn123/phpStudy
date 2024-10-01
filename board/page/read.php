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
<div class="d-flex justify-content-between align-items-center">
  <a href="../index.php" class="btn btn-secondary">목록</a>
  <div>
    <a href="delete.php?idx=<?= $data['idx'] ?>" class="btn btn-danger">삭제</a>
    <a href="update.php?idx=<?= $data['idx'] ?>" class="btn btn-info">수정</a>
    <a href="" class="btn btn-info">추천</a>
  </div>
</div>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');

?>