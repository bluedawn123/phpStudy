<?php
$title = "상품목록";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/category_func.php');  //대분류 조회코드


if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}

$cate1 = $_GET['cate1'] ?? '';

//모든 상품 조회
$sql = "SELECT * FROM products ORDER BY reg_date DESC";
$result = $mysqli->query($sql) or die('query error :'.$mysqli->error);
while($data = $result->fetch_object()){ 
  $dataArr[]= $data; 
  
}

?>


<div class="container">
<h1>상품리스트</h1>
  <form action="" id="search_form">
    <div class="row mb-3">
      <div class="col-md-4">
        <select class="form-select" id="cate1" aria-label="대분류 선택" name="cate1">
          <option selected>대분류 선택</option>
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
        <select class="form-select" id="cate2" aria-label="Default select example" name="cate2">
          <option selected>대분류를 먼저 선택하세요</option>
        </select>
      </div>
      <div class="col-md-4">
        <select class="form-select" id="cate3" aria-label="Default select example" name="cate3">
          <option selected>중분류를 먼저 선택하세요</option>
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
        <input type="text" class="form-control " id="search" name="search_keyword">
        <button class="btn btn-primary btn-sm w-25">검색</button>
      </div>      
    </div>
  </form>



  <table class="table">
    <thead>
      <tr class>
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

      <?php
      if(isset($dataArr)){
        foreach($dataArr as $item){
      ?>

      <tr>
        <th scope="row"><?= $item->pid; ?></th>
        <td>
          <img src="<?= $item->thumbnail; ?>" alt="" width="90">
        </td>
        <td><?= $item->name; ?></td>
        <td><?= $item->price; ?></td>
        <td>
          <input type="checkbox" class="form-check-input"<?php echo $item->ismain ? 'checked' : ''; ?> name="ismain[<?= $item->pid; ?>]" id="ismain[<?= $item->pid; ?>]">
        </td>
        <td>
          <input type="checkbox" class="form-check-input"<?php echo $item->isnew ? 'checked' : ''; ?> name="isnew[<?= $item->pid; ?>]" id="isnew[<?= $item->pid; ?>]">
        </td>
        <td>
          <input type="checkbox" class="form-check-input"<?php echo $item->isbest ? 'checked' : ''; ?> name="isbest[<?= $item->pid; ?>]" id="isbest[<?= $item->pid; ?>]">
        </td>
        <td>
          <input type="checkbox" class="form-check-input"<?php echo $item->isrecom ? 'checked' : ''; ?> name="isrecom[<?= $item->pid; ?>]" id="isrecom[<?= $item->pid; ?>]">
        </td>
        <td>
        <select class="form-select" aria-label="판매여부" name="status[<?= $item->pid; ?>]" id="status[<?= $item->pid; ?>]">
          <option value="-1" <?php if($item->status == -1){echo 'selected';} ?>> 판매중지</option>
          <option value="0" <?php if($item->status == 0){echo 'selected';} ?>>대기</option>
          <option value="1" <?php if($item->status == 1){echo 'selected';} ?>>판매중</option>
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
  <hr>
  <a href="product_up.php" class="btn btn-primary">상품등록</a>
  
</div>
<script src="http://<?= $_SERVER['HTTP_HOST']?>/abcmall/admin/category_option.js"></script>
<script>
  $( "#datepicker" ).datepicker({
    dateFormat: "yy-mm-dd"
  });

</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
