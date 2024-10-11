<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');
  // echo $_SERVER['DOCUMENT_ROOT'];

  $category = $_GET['search_cat'];
  $keywords = $_GET['keywords'];
  echo $category;
  echo $keywords;
?>
    <h1>게시판 - 검색결과</h1>
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
        //게시글 개수 조회
        $page_sql = "SELECT COUNT(*) AS cnt FROM board WHERE $category LIKE '%$keywords%'";
        $page_result = $mysqli->query($page_sql);
        $page_data = $page_result->fetch_assoc();
        $row_num = $page_data['cnt'];
        echo $row_num;

        //페이지네이션 
        if(isset($_GET['page'])){
          $page = $_GET['page'];
        }else{
          $page = 1;
        }

        $list = 10;
        $start_num=($page-1)*$list;
        $block_ct = 5;
        $block_num = ceil($page/$block_ct); //$page1/5 0.2 = 1

        $block_start = (($block_num-1)*$block_ct) + 1;
        $block_end = $block_start + $block_ct - 1;

        $total_page = ceil($row_num/$list); //총75개 10개씩, 8
        $total_block = ceil($total_page/$block_ct);

        if($block_end > $total_page ) $block_end = $total_page;
  
        $sql = "SELECT * FROM board WHERE $category LIKE '%$keywords%' ORDER BY idx DESC LIMIT $start_num, $list" ;        
        $result = $mysqli->query($sql);
        
         //print_r($result->fetch_assoc());

        $list = '';
        while($row = $result->fetch_assoc()){
          $b_idx =  $row['idx'];
          $rc_sql = "SELECT COUNT(*) AS cnt FROM reply WHERE b_idx = $b_idx";
          $rc_result = $mysqli->query($rc_sql);
          $rc_data = $rc_result->fetch_assoc();

          if($rc_data['cnt']>0){
            $rc = '('.$rc_data['cnt'].')';
          } else {
            $rc = '';
          }


          $post_time = $row['date'];
          $current_time = date("Y-m-d");

          if($post_time == $current_time){
            $icon = "<i class=\"fa-solid fa-pizza-slice\"></i>";
          } else{
            $icon = '';
          }

          $title = $row['title'];
          // echo iconv_strlen($title);

          if(iconv_strlen($title)>10){
            $title = str_replace($row['title'],iconv_substr($row['title'],0,10).'...',$row['title']);
          }

          $list.= "
          <tr>
            <th scope=\"row\">{$row['idx']}</th>
            <td>". 
            (
              $row['lock_post'] == 1 ? 
              " <a href=\"page/lock_read.php?idx={$row['idx']}\">{$title}{$rc}{$icon}<i class=\"fa-solid fa-lock\"></i>" 
              : 
              "<a href=\"page/read.php?idx={$row['idx']}\">{$title}{$rc}{$icon}"
            ) 
            ."</a></td>
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
    <nav aria-label="Page navigation">
      <ul class="pagination d-flex justify-content-center">
        <?php
          if($block_num > 1){
            $prev = $block_start - $block_ct;
            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page={$prev}\">Previous</a></li>";
          }
        ?>
        
        <?php
          for($i=$block_start; $i<=$block_end; $i++){                
            // if($page == $i) {$active = 'active';} else {$active = '';}
            $page == $i ? $active = 'active': $active = '';
        ?>
        <li class="page-item <?= $active; ?>">
          <a class="page-link" 
            href="search_result.php?search_cat=<?= $category;?>&keywords=<?= $keywords;?>&page=<?= $i;?>"
          ><?= $i;?></a>
        </li>
        <?php
          }
          $next = $block_end + 1;
          if($total_block >  $block_num){
        ?>
        <li class="page-item"><a class="page-link" href="index.php?page=<?= $next;?>">Next</a></li>
        <?php
        }         
        ?>
      </ul>
    </nav>
    <hr>

    <form action="search_result.php" class="d-flex justify-content-end align-items-center">
      <select class="form-select w-25" name="search_cat" aria-label="카테고리 선택">
        <option value="title">제목</option>
        <option value="name">글쓴이</option>
        <option value="content">내용</option>
      </select>
      <div class="d-flex align-items-center w-50 justify-content-end gap-3">
        <input type="text" name="keywords" class="form-control w-75">
        <button class="btn btn-primary">검색</button>
      </div>      
    </form>

    <hr>
    <a class="btn btn-primary" href="page/write.php" role="button">글쓰기</a>
<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/footer.php');
?>