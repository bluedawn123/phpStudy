<?php
$title = "상품목록";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/category_func.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}
$search_where = '';

$cate = $_GET['cate1'] ?? '';
$cate2 = $_GET['cate2'] ?? '';
$cate3 = $_GET['cate3'] ?? '';
$cates = $cate.$cate2.$cate3;
$ismain = $_GET['ismain'] ?? '';
$isnew = $_GET['isnew'] ?? '';
$isbest = $_GET['isbest'] ?? '';
$isrecom = $_GET['isrecom'] ?? '';
$sale_end_date = $_GET['sale_end_date'] ?? '';
$search_keyword = $_GET['search_keyword'] ?? '';

if($cates){
  // $search_where = $search_where." and cate LIKE '$cates%'";
  $search_where .= " and cate LIKE '$cates%'";
}
if($ismain){
  $search_where .= " and ismain = 1";
}
if($isnew){
  $search_where .= " and isnew = 1";
}
if($isbest){
  $search_where .= " and isbest = 1";
}
if($isrecom){
  $search_where .= " and isrecom = 1";
}
if($sale_end_date){
  //문자열을 DATETIME 변경할 함수 CAST, 판매기간이 남아 있는 상품 조회
  $search_where .= " and sale_end_date >= CAST('$sale_end_date' AS datetime)";
}
if($search_keyword){ 
  $search_where .= " and (name LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%')";
}


//데이터의 개수 조회
$page_sql = "SELECT COUNT(*) AS cnt FROM products WHERE 1=1 $search_where";
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

 
$sql = "SELECT * FROM products WHERE 1=1 $search_where ORDER BY pid DESC LIMIT $start_num, $list"; //products 테이블에서 모든 데이터를 조회

$result = $mysqli->query($sql); //쿼리 실행 결과


while($data = $result->fetch_object()){
  $dataArr[] = $data;
}
?>

<div class="container">
  <h1>상품리스트</h1>
  <form action="" id="search_form">
    <div class="row mb-3">
      <div class="col-md-4">
        <select class="form-select" id="cate1" name="cate1" aria-label="대분류 선택">
          <option selected value="">대분류 선택</option>
          <?php
            foreach($cate1 as $c1){
          ?>
          <option value="<?= $c1->code;?>"><?= $c1->name;?></option>
          <?php
            }
          ?>
        </select>
      </div>
      <div class="col-md-4">
        <select class="form-select" id="cate2" name="cate2" aria-label="Default select example">
          <option selected value="">대분류를 먼저 선택하세요</option>
        </select>
      </div>
      <div class="col-md-4">
        <select class="form-select" id="cate3" name="cate3" aria-label="Default select example">
          <option selected value="">중분류를 먼저 선택하세요</option>
        </select>
      </div>
    </div>
    <div class="d-flex gap-3 align-items-center justify-content-between mb-3">
      <div class="d-flex gap-3 align-items-center"> 
        <label class="form-check-label" for="ismain">메인</label>
        <input class="form-check-input" type="checkbox" value="1" name="ismain" id="ismain">

        <label class="form-check-label" for="isnew">신제품</label>
        <input class="form-check-input" type="checkbox" value="1" name="isnew" id="isnew">
        
        <label class="form-check-label" for="isbest">베스트</label>
        <input class="form-check-input" type="checkbox" value="1" name="isbest" id="isbest">
        
        <label class="form-check-label" for="isrecom">추천</label>
        <input class="form-check-input" type="checkbox" value="1" name="isrecom" id="isrecom">

        <label class="form-check-label" for="datepicker">판매종료일</label>
        <input type="text" name="sale_end_date" id="datepicker" class="form-control w-25">
      </div>       
      <div class="d-flex gap-3 w-30 align-items-center">
        <input type="text" class="form-control" name="search_keyword" id="search">
        <button class="btn btn-primary btn-sm w-25">검색</button>
      </div>      
    </div>
  </form>
  <hr>
  총 상품수: <?= $row_num; ?>
  <hr>
  <form action="plist_update.php" method="GET">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No. </th>
          <th scope="col">썸네일</th>
          <th scope="col">제품명</th>
          <th scope="col">가격</th>
          <th scope="col">메인</th>
          <th scope="col">신제품</th>
          <th scope="col">베스트</th>
          <th scope="col">추천</th>
          <th scope="col">상태</th>
          <th scope="col">보기</th>
        </tr>
      </thead>
      <tbody>
        <!-- $dataArr의 값으로 foreach로 tr 출력 -->
        <?php
          if(isset($dataArr)){
            foreach($dataArr as $item){
        ?> 
        <tr>
          <th scope="row">
            <input type="hidden" name="pid[]" value="<?= $item->pid; ?>">
            <?= $item->pid; ?>
          </th>
          <td>
            <img src="<?= $item->thumbnail; ?>" width="90" alt="">
          </td>
          <td><?= $item->name; ?></td>
          <td><?= $item->price; ?></td>
          <td>
            <input type="checkbox" class="form-check-input" <?php echo $item->ismain ? 'checked' : ''; ?> name="ismain[<?= $item->pid; ?>]" id="ismain[<?= $item->pid; ?>]" value="<?= $item->ismain ?>">
          </td>
          <td>
            <input type="checkbox" class="form-check-input" <?php echo $item->isnew ? 'checked' : ''; ?> name="isnew[<?= $item->pid; ?>]" id="isnew[<?= $item->pid; ?>]" value="<?= $item->isnew ?>">
          </td>
          <td>
            <input type="checkbox" class="form-check-input" <?php echo $item->isbest ? 'checked' : ''; ?> name="isbest[<?= $item->pid; ?>]" id="isbest[<?= $item->pid; ?>]" value="<?= $item->isbest ?>">
          </td>
          <td>
            <input type="checkbox" class="form-check-input" <?php echo $item->isrecom ? 'checked' : ''; ?> name="isrecom[<?= $item->pid; ?>]" id="isrecom[<?= $item->pid; ?>]" value="<?= $item->isrecom ?>">
          </td>
          <td>
            <select class="form-select" aria-label="판매여부" name="status[<?= $item->pid; ?>]" id="status[<?= $item->pid; ?>]">
              <option value="-1" <?php if($item->status == -1){echo 'selected';}?>>판매중지</option>
              <option value="0" <?php if($item->status == 0){echo 'selected';}?>>대기</option>
              <option value="1" <?php if($item->status == 1){echo 'selected';}?>>판매중</option>
            </select>
          </td>
          <td>
            <a href="product_view.php?pid=<?= $item->pid; ?>" class="btn btn-primary btn-sm">상세보기</a>
          </td>
        </tr>
        <?php
            }
          }
        ?> 
      </tbody>
    </table>    
    <button class="btn btn-secondary btn-sm ms-auto d-block">일괄수정</button>
  </form>
  <nav aria-label="Page navigation">
      <ul class="pagination d-flex justify-content-center">
        <?php
          if($block_num > 1){
            $prev = $block_start - $block_ct;
            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"product_list.php?cate1={$cate}&cate2={$cate2}&cate3={$cate3}&ismain={$ismain}&isnew={$isnew}&isbest={$isbest}&isrecom={$isrecom}&sale_end_date={$sale_end_date}&search_keyword={$search_keyword}&page={$prev}\">Previous</a></li>";
          }
        ?>
        
        <?php
          for($i=$block_start; $i<=$block_end; $i++){                
            // if($page == $i) {$active = 'active';} else {$active = '';}
            $page == $i ? $active = 'active': $active = '';
        ?>
        <li class="page-item <?= $active; ?>"><a class="page-link" href="product_list.php?cate1=<?= $cate;?>&cate2=<?= $cate2;?>&cate3=<?= $cate3;?>&ismain=<?= $ismain;?>&isnew=<?= $isnew;?>&isbest=<?= $isbest;?>&isrecom=<?= $isrecom;?>&sale_end_date=<?= $sale_end_date;?>&search_keyword=<?= $search_keyword;?>&page=<?= $i;?>"><?= $i;?></a></li>
        <?php
          }
          $next = $block_end + 1;
          if($total_block >  $block_num){
        ?>
        <li class="page-item"><a class="page-link" href="product_list.php?cate1=<?= $cate;?>&cate2=<?= $cate2;?>&cate3=<?= $cate3;?>&ismain=<?= $ismain;?>&isnew=<?= $isnew;?>&isbest=<?= $isbest;?>&isrecom=<?= $isrecom;?>&sale_end_date=<?= $sale_end_date;?>&search_keyword=<?= $search_keyword;?>&page=<?= $next;?>">Next</a></li>
        <?php
        }         
        ?>
      </ul>
    </nav>

  <hr>
  <div class="d-flex justify-content-end">
    <a href="product_up.php" class="btn btn-primary">상품등록</a>
  </div>
</div>

<script src="http://<?= $_SERVER['HTTP_HOST']?>/abcmall/admin/js/category_option.js"></script>

<script>
  $( "#datepicker" ).datepicker({
    dateFormat: "yy-mm-dd"
  });

  $('table .form-check-input').change(function(){
    if($(this).prop( "checked" )){
      $(this).val('1');
    } else{
      $(this).val('0');
    }
  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
