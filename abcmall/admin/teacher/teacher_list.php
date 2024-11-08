<?php
$title = "강사 목록";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}
$search_where = '';

$search_keyword = $_GET['search_keyword'] ?? '';

if($search_keyword){ 
  $search_where .= " and (name LIKE '%$search_keyword%')";
}


//데이터의 개수 조회
$page_sql = "SELECT COUNT(*) AS cnt FROM admins WHERE level=10 $search_where";
$page_result = $mysqli->query($page_sql);
$page_data = $page_result->fetch_assoc();
$row_num = $page_data['cnt'];

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

 
$sql = "SELECT * FROM admins WHERE level=10 $search_where ORDER BY idx DESC LIMIT $start_num, $list"; //products 테이블에서 모든 데이터를 조회

$result = $mysqli->query($sql); //쿼리 실행 결과


while($data = $result->fetch_object()){
  $dataArr[] = $data;
}
?>

<div class="container">
  <h1>강사 리스트</h1>
  <form action="" id="search_form">

    <div class="d-flex gap-3 align-items-center justify-content-end mb-3">
      <div class="d-flex gap-3 w-30 align-items-center">
        <input type="text" class="form-control" name="search_keyword" id="search">
        <button class="btn btn-primary btn-sm w-25">검색</button>
      </div>      
    </div>
  </form>
  <hr>
  총 강사수: <?= $row_num; ?>
  <hr>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">강사명</th>
        <th scope="col">이메일</th>
        <th scope="col">관리</th>
      </tr>
    </thead>
    <tbody>
      <!-- $dataArr의 값으로 foreach로 tr 출력 -->
      <?php
        if(isset($dataArr)){
          foreach($dataArr as $item){
      ?> 
      <tr>        
        <td><?= $item->username; ?></td>
        <td><?= $item->email; ?></td>       
        <td>
          <a href="teacher_edit.php?cid=<?= $item->idx?>" class="btn btn-secondary btn-sm">수정</a>
          <a href="teacher_del.php?cid=<?= $item->idx?>"  class="delete btn btn-danger btn-sm">삭제</a>
        </td>     
      </tr>
      <?php
          }
        }
      ?> 
    </tbody>
  </table>    

  <nav aria-label="Page navigation">
      <ul class="pagination d-flex justify-content-center">
        <?php
          if($block_num > 1){
            $prev = $block_start - $block_ct;
            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"coupon_list.php?search_keyword={$search_keyword}&page={$prev}\">Previous</a></li>";
          }
        ?>
        
        <?php
          for($i=$block_start; $i<=$block_end; $i++){                
            // if($page == $i) {$active = 'active';} else {$active = '';}
            $page == $i ? $active = 'active': $active = '';
        ?>
        <li class="page-item <?= $active; ?>"><a class="page-link" href="coupon_list.php?search_keyword=<?= $search_keyword;?>&page=<?= $i;?>"><?= $i;?></a></li>
        <?php
          }
          $next = $block_end + 1;
          if($total_block >  $block_num){
        ?>
        <li class="page-item"><a class="page-link" href="coupon_list.php?search_keyword=<?= $search_keyword;?>&page=<?= $next;?>">Next</a></li>
        <?php
        }         
        ?>
      </ul>
    </nav>

  <hr>
  <div class="d-flex justify-content-end">
    <a href="teacher_up.php" class="btn btn-primary">강사등록</a>
  </div>
</div>
<script>
  $('.delete').click(function(e) {
      e.preventDefault();
      if (confirm('정말 삭제할까요?')) {
          window.location.href = $(this).attr('href');
      }
  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
