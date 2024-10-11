<?php
  $title = "상품목록";
  include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');
  include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/category_func.php');

    //관리자만 접근하도록 하기(관리자 로그인 안하면 돌려보내기)
    if(!isset($_SESSION['AUID'])){
      echo "
      <script>
        alert('관리자로 로그인해주세요.');
        location.href = '../login.php';
      </script>
      ";
    }

    $search_where = ''; //처음에 전체목록 출력하기 위해 
    //검색, 필터 데이터 넘기기
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
      //$search_where = $search_where." and cate LIKE '$cates%'"; 
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
      //문자열을 datetime 형식으로 변경할 함수 CAST 사용, 판재 기간이 남아있는 상품 조회
      $search_where .= " and sale_end_date >= CAST('$sale_end_date' AS datetime)"; 
    }

    if($search_keyword){
      //문자열을 datetime 형식으로 변경할 함수 CAST 사용, 판재 기간이 남아있는 상품 조회
      $search_where .= " and (name LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%')"; 
    }


    //페이지네이션 시작
    //데이터(상품 목록)의 개수 조회
    $page_sql = "SELECT COUNT(*) AS cnt FROM products WHERE 1=1 $search_where";
    $page_result = $mysqli->query($page_sql);
    $page_data = $page_result->fetch_assoc();
    $row_num = $page_data['cnt'];
    //echo $row_num;

    //페이지네이션
    //열자마자는 페이지 번호 없을 수 있어서 두가지 경우
    if(isset($_GET['page'])){
      $page = $_GET['page'];
    }else{
      $page = 1;
    }
    $list = 4;
    $start_num = ($page-1) * $list;

    //페이저버튼 
    $block_ct = 5; //버튼 몇개씩 보일지
    $block_num = ceil($page/$block_ct); //버튼 몇개씩 보일지 (총게시글수/보일목록수) -> 페이지번호/버튼개수
  
    $block_start = ($block_num-1)*$block_ct + 1;
    $block_end =  ($block_start + $block_ct) - 1;

    $total_page = ceil($row_num/$list); //총70개 10개씩이면 7페이지 75개면 10개씩 8페이지 111개면 10개씩 11페이지
    $total_block = ceil($total_page/$block_ct); //pagegroup 개수
    
    if($block_end > $total_page) $block_end = $total_page; //자바스크립트처럼 중괄호 생략 가능
    //총게시물 수 78개일때 end 번호 8 일 수 있게

    //products 테이블에서 모든 데이터를 조회, 등록일 기준으로 역순으로 출력
    $sql = "SELECT * FROM products WHERE 1=1 $search_where ORDER BY reg_date DESC LIMIT $start_num, $list"; 
    //페이저끝
    //echo $sql; //목록 출력안됐을 때 확인

    $result = $mysqli->query($sql); //sql 실행 결과를 담기

 
    /* fetch_object를 이용해서 값을 추출, 변수명 $data에 할당하고
    그 값이 있을 때 마다 변수명 $dataArr에 값을 추가 */
    while($data = $result->fetch_object()){ //조회된 값들 마다 할 일, 값이 있으면 $data에 할당
      $dataArr[] = $data;
    }

    //print_r($dataArr); //데이터 잘 받아오나 출력해서 확인해보기
?>



<div class="container">
  <h1 class="my-4">상품리스트</h1>
  <form action="" id="search_form">
    <div class="row my-3">
      <div class="col-md-4">
        <select id="cate1" class="form-select" name="cate1" aria-label="대분류 선택">
          <option selected value="">대분류를 선택하세요.</option>
          <?php
            foreach($cate1 as $c1){
          ?>
          <option value="<?= $c1->code; ?>"><?= $c1->name; ?></option>
          <?php
            }
          ?>
          <!-- <option value="2">Two</option>
          <option value="3">Three</option> -->
        </select>
      </div>
      <div class="col-md-4">
        <select id="cate2" class="form-select" name="cate2" aria-label="중분류 선택">
          <option selected value="">대분류를 먼저 선택하세요.</option>
        </select>
      </div>
      <div class="col-md-4">
        <select id="cate3" class="form-select" name="cate3" aria-label="소분류 선택">
          <option selected value="">중분류를 먼저 선택하세요.</option>
        </select>
      </div>
    </div>

    <div class="d-flex gap-3 align-items-center justify-content-between mb-3">
      <div class="d-flex gap-3 align-items-center">
        <label class="form-check-label" for="ismain">메인</label>
        <input class="form-check-input me-2" type="checkbox" value="1" name="ismain" id="ismain">
  
        <label class="form-check-label" for="isnew">신제품 </label>
        <input class="form-check-input me-2" type="checkbox" value="1" name="isnew" id="isnew">
  
        <label class="form-check-label" for="isbest">베스트 </label>
        <input class="form-check-input me-2" type="checkbox" value="1" name="isbest" id="isbest">
  
        <label class="form-check-label" for="isrecom">추천 </label>
        <input class="form-check-input me-2" type="checkbox" value="1" name="isrecom" id="isrecom">
  
        <label class="form-check-label" for="datepicker">판매종료일 </label>
        <input type="text" class="form-control w-25" name="sale_end_date" id="datepicker">
      </div>
      <div class="d-flex gap-3 w-30 align-item-center">        
        <input type="text" class="form-control" id="search" name="search_keyword">
        <button class="btn btn-primary btn-sm w-25">검색</button>
      </div>
    </div>
  </form>

  <hr>
    총 상품 수: <span class="badge text-bg-secondary"><?= $row_num ?> </span>
  <hr>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">No.</th>
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
      <!-- $dataArr의 값으로 foreach로 tr 출력 (안전하게는 값이 있으면 출력, 만약에 값이 없으면 에러날수도) -->
      <?php
        if(isset($dataArr)){  
          foreach($dataArr as $d_item){
      ?>
          <tr>
            <th scope="row"><?= $d_item->pid; ?></th>
            <td><img src="<?= $d_item->thumbnail; ?>" style="width: 9rem;" alt="..."></td>
            <td><?= $d_item->name; ?></td>
            <td><?= $d_item->price; ?></td>
            <td>
              <input type="checkbox" class="form-check-input" <?php echo $d_item->ismain ? 'checked' : '' ?> name="ismain[<?= $d_item->pid; ?>]" id="ismain[<?= $d_item->pid; ?>]">
            </td>
            <td>
              <input type="checkbox" class="form-check-input" <?php echo $d_item->isnew ? 'checked' : '' ?> name="isnew[<?= $d_item->pid; ?>]" id="isnew[<?= $d_item->pid; ?>]">
            </td>
            <td>
              <input type="checkbox" class="form-check-input" <?php echo $d_item->isbest ? 'checked' : '' ?> name="isbest[<?= $d_item->pid; ?>]" id="isbest[<?= $d_item->pid; ?>]">
            </td>
            <td>
              <input type="checkbox" class="form-check-input" <?php echo $d_item->isrecom ? 'checked' : '' ?> name="isrecom[<?= $d_item->pid; ?>]" id="isrecom[<?= $d_item->pid; ?>]">
            </td>
            <td>
              <select class="form-select" aria-label="판매여부" name="status[<?= $d_item->pid; ?>]" id="status[<?= $d_item->pid; ?>]">
                <option value="-1" <?php if($d_item->status == -1){echo 'selected';} ?>>판매중지</option>
                <option value="0" <?php if($d_item->status == 0){echo 'selected';} ?>>대기</option>
                <option value="1" <?php if($d_item->status == 1){echo 'selected';} ?>>판매중</option>
              </select>
            </td>
            <td><a href="product_view.php?pid=<?= $d_item->pid; ?>" class="btn btn-primary btn-sm">상세보기</a></td>
          </tr>
      <?php 
          }
        }
      ?>
    </tbody>
  </table>

  <!-- 페이지네이션 -->
  <nav aria-label="Page navigation">
      <ul class="pagination d-flex justify-content-center">
        <?php
          $prev = $block_start - $block_ct;
          if($block_num > 1){
           echo "<li class=\"page-item\"><a class=\"page-link\" href=\"product_list.php?cate1={$cate}&cate2={$cate2}&cate3={$cate3}&ismain={$ismain}&isnew={$isnew}&isbest={$isbest}&isrecom={$isrecom}&sale_end_date={$sale_end_date}&search_keyword={$search_keyword}&page={$prev}\">Previous</a></li>";
          }
        ?>


        <?php
          for($i = $block_start; $i<=$block_end; $i++){
            $page == $i ? $active = 'active' : $active = '';
        ?>
        <li class="page-item <?=$active; ?>">
          <a class="page-link" href="product_list.php?cate1=<?= $cate; ?>&cate2=<?= $cate2; ?>&cate3=<?= $cate3; ?>&ismain=<?= $ismain; ?>&isnew=<?= $isnew; ?>&isbest=<?= $isbest; ?>&isrecom=<?= $isrecom; ?>&sale_end_date=<?= $sale_end_date; ?>&search_keyword=<?= $search_keyword; ?>&page=<?= $i; ?>"><?= $i; ?></a>
        </li>

        <?php
          }
          $next = $block_end + 1;
          if($total_block > $block_num){
        ?>
        <li class="page-item"><a class="page-link" href="product_list.php?cate1=<?= $cate;?>&cate2=<?= $cate2;?>&cate3=<?= $cate3;?>&ismain=<?= $ismain;?>&isnew=<?= $isnew;?>&isbest=<?= $isbest;?>&isrecom=<?= $isrecom;?>&sale_end_date=<?= $sale_end_date;?>&search_keyword=<?= $search_keyword;?>&page=<?= $next; ?>">Next</a></li>
        <?php
          }
        ?>
      </ul>
    </nav>

  <hr>
  <a href="product_up.php" class="btn btn-primary">상품등록</a>

</div>

<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/abcmall/admin/js/category_option.js"></script>
<script>
   $( "#datepicker" ).datepicker({
    dateFormat: "yy-mm-dd"
  });
</script>

<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>