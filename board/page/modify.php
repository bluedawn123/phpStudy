<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');
$num = $_GET['idx'];

/*get방식으로 넘어온 값중 변수 idx값을 $idx에 할당
변수면 $sql에 board테이블에서 컬럼 idx의 값이 $idx인 행의데이터를 모두조회

변수명 $sql에 담긴 sql쿼리를 실행한 결과를ㄹ $result에 할당
변수명 $data에 $result값을 연관배열로 할당
아래 입력 항목에 기존 데이터를 출력
*/


$sql = "SELECT * FROM board WHERE idx = $num ";
// $result = mysqli_query($mysqli, $sql);
$result = $mysqli->query($sql);
$data = mysqli_fetch_assoc($result);

//print_r($data);
?>



<h1>글쓰기</h1>
<form action="modify_ok.php" method="POST">
  <input type="hidden" name="number" value="<?= $num; ?>">
  <div class="mb-3">
    <label for="username" class="form-label">이름 : <?= $data['name']; ?></label>
    <input value="<?= $data['name']; ?>" 
    type="text" name="name" class="form-control" id="username" placeholder="이름" required>
  </div>
  <div class="mb-3">
    <label for="title" class="form-label">제목 : <?= $data['title']?></label>
    <input  value="<?php echo $data['title']; ?>" 
    type="text" name="title" class="form-control" id="title" placeholder="글 제목" required>
  </div>
  <div class="mb-3">
    <label for="content" class="form-label">내용 : </label><?= $data['content'];?>
    <textarea value="<?php echo $data['content']; ?>" name="content" class="form-control" id="content" rows="3" required></textarea>
  </div>
  <button class="btn btn-primary">전송</button>

</form>







<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');

?>