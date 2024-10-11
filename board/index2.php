<?php
  include_once('inc/header.php');
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
        $sql = "SELECT * FROM board ORDER BY idx DESC LIMIT 10" ;        
        $result = $mysqli->query($sql);
        
         //print_r($result->fetch_assoc());

        while($row = $result->fetch_assoc()){
        ?>
          <tr>
            <th scope="row"><?= $row['idx'] ?></th>
            <td><?= $row['title'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['hit'] ?></td>
            <td><?= $row['likes'] ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <nav aria-label="Page navigation">
      <ul class="pagination d-flex justify-content-center">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
    <hr>
    <a class="btn btn-primary" href="#" role="button">글쓰기</a>
<?php
  include_once('inc/footer.php');
?>