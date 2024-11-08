<?php
$title = "쿠폰 목록";
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
  $search_where .= " and (coupon_name LIKE '%$search_keyword%')";
}


//데이터의 개수 조회
$page_sql = "SELECT COUNT(*) AS cnt FROM coupons WHERE 1=1 $search_where";
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

 
$sql = "SELECT * FROM coupons WHERE 1=1 $search_where ORDER BY cid DESC LIMIT $start_num, $list"; //products 테이블에서 모든 데이터를 조회

$result = $mysqli->query($sql); //쿼리 실행 결과


while($data = $result->fetch_object()){
  $dataArr[] = $data;
}
?>

<div class="container">
  <h1>쿠폰 리스트</h1>
  <form action="" id="search_form">

    <div class="d-flex gap-3 align-items-center justify-content-end mb-3">
      <div class="d-flex gap-3 w-30 align-items-center">
        <input type="text" class="form-control" name="search_keyword" id="search">
        <button class="btn btn-primary btn-sm w-25">검색</button>
      </div>      
    </div>
  </form>
  <hr>
  총 쿠폰수: <?= $row_num; ?>
  <hr>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">사진</th>
        <th scope="col">쿠폰명</th>
        <th scope="col">쿠폰타입</th>
        <th scope="col">할인가</th>
        <th scope="col">할인율</th>
        <th scope="col">최소사용금액</th>
        <th scope="col">최대할인금액</th>
        <th scope="col">등록자 </th>
        <th scope="col">상태 </th>
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
        <td><img src="<?= $item->coupon_image; ?>" width="90" alt=""></td>
        <td><?= $item->coupon_name; ?></td>
        <td>
          <?php 
            if($item->coupon_type == 1){
              echo '정액';
            } else if($item->coupon_type == 2){
              echo '정률'; 
            }
          ?>
        </td>
        <td><?= $item->coupon_price; ?></td>
        <td><?= $item->coupon_ratio; ?></td>
        <td><?= $item->use_min_price; ?></td>
        <td><?= $item->max_value; ?></td>
        <td><?= $item->userid; ?></td>
        <td>
          <?php
            if($item->status == 1){
              echo '대기';
            } else if($item->status == 2){
              echo '활성화'; 
            } else{
              echo '비활성화'; 
            }         
          ?>
        </td>
        <td>
          <a href="coupon_edit.php?cid=<?= $item->cid?>" class="btn btn-secondary btn-sm">수정</a>
          <a href="coupon_del.php?cid=<?= $item->cid?>"  class="delete btn btn-danger btn-sm">삭제</a>
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
    <a href="coupon_up.php" class="btn btn-primary">쿠폰등록</a>
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
