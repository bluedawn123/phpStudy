<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');

?>

<h1>게시판</h1>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">번호</th>
      <th scope="col">제목</th>
      <th scope="col">글쓴이</th>
      <th scope="col">작성일</th>
      <th scope="col">조회수</th>
      <th scope="col">추천수</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM board ORDER BY idx DESC LIMIT 10";
    $result = $mysqli->query($sql);
    //print_r($result->fetch_assoc());
    //Array ( [idx] => 1 [name] => 홍길동 [pw] => 1234 [title] => 안녕하세요 [content] => 반갑습니다 [date] => 2024-10-01 [hit] => [likes] => )
    $list = '';
    while ($row = $result->fetch_assoc()) {
      $title = $row['title'];

      //글자수 10개 넘을때 ...으로 만들기
      if (iconv_strlen($title) > 10) {
        $title = str_replace($title, iconv_substr($row['title'], 0, 10).'...', $title);
      }

      $list .= "
    <tr>
      <th scope=\"row\">{$row['idx']}</th>
      <td>". 
        (
          $row['lock_post'] == 1 ? 
        "<a href=\"page/lock_read.php?idx={$row['idx']}\">{$title}<i class=\"fa-solid fa-lock\"></i>" 
        : 
        "<a href=\"page/read.php?idx={$row['idx']}\">{$title}"
        ) 
        ."</a>
      </td>
      <td>{$row['name']}</td>
      <td>{$row['date']}</td>
      <td>{$row['hit']}</td>
      <td>{$row['likes']}</td>
    </tr>
    ";
    }

    ?>
    <?= $list; ?>

  </tbody>
</table>
<nav aria-label="Page navigation example">
  <ul class="pagination d-flex justify-content-center">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
<hr>
<a class="btn btn-primary" href="page/write.php" role="button">글쓰기</a>




<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');

?>