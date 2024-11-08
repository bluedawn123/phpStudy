<?php
$title = "상품상세";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');

$pid = $_GET['pid'];
if (!isset($pid)) {
  echo "<script>alert('상품정보가 없습니다.'); location.href = '../product/product_list.php';</script>";
}

$sql = "SELECT * FROM products WHERE pid = $pid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

$cate = $data->cate ; //A0001B0001C0001
$cate1 = substr($cate, 0, 5); // A0001
$cate2 = substr($cate, 5, 5); // B0001
$cate3 = substr($cate, 10, 5); // C0001

$cate_sql = "SELECT name FROM category WHERE code IN ('$cate1', '$cate2', '$cate3')";
$result = $mysqli->query($cate_sql);

// 카테고리 이름 배열에 저장
$category_names = [];
while ($row = $result->fetch_object()) {
    $category_names[] = $row->name;
}

$category_display = implode(' / ', $category_names); //배열->문자열 변환, javascript 배열명.join('/')

//추가 이미지 조회
$addimg_sql = "SELECT filename FROM product_image_table WHERE pid = $pid";
$addimg_result = $mysqli->query($addimg_sql);

$addImages = [];

while($addimg_data = $addimg_result->fetch_object()){
  $addImages[] = $addimg_data;
}

// 옵션 조회 함수
function getOptions($mysqli, $pid, $cate) {
  $otp_sql = "SELECT * FROM product_options WHERE pid = $pid and cate = '$cate'";
  $otp_result = $mysqli->query($otp_sql);

  $options = [];
  while ($otp_data = $otp_result->fetch_object()) {
      $options[] = $otp_data;
  }
  return $options;
}

// 옵션1 조회 (컬러)
$options1 = getOptions($mysqli, $pid, '컬러');

// 옵션2 조회 (사이즈)
$options2 = getOptions($mysqli, $pid, '사이즈');


?>
<div class="container">
<h1>상품 상세</h1>
<table class="table">
    <thead>
      <tr>
        <th scope="col">구분</th>
        <th scope="col">내용</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">제품명</th>
        <td><?= $data->name; ?></td>
      </tr>
      <tr>
        <th scope="row">썸네일</th>
        <td>
          <img src="<?= $data->thumbnail; ?>" alt="" class="w-25">
        </td>
      </tr>
      <?php 
      if(isset($addImages)){
        ?> 
      <tr>
        <th scope="row">추가이미지</th>
        <td>
          <ul class="d-flex gap-3 list-unstyled" >
            <?php               
                foreach($addImages as $ai){              
            ?> 
            <li class="w-25">
              <a href="<?= $ai->filename;?>">
                <img src="<?= $ai->filename;?>" alt="" class="w-100">
              </a>
            </li>
            <?php     
                }          
            ?>           
          </ul>
        </td>
      </tr>
      <?php 
        }
      ?>
      <tr>
        <th scope="row">카테고리</th>
        <td><?= $category_display; ?></td>
      </tr>
      <tr>
        <th scope="row">상세설명</th>
        <td><?= $data->content; ?></td>
      </tr>
      <tr>
        <th scope="row">가격</th>
        <td><?= $data->price; ?></td>
      </tr>      
      <tr>
        <th scope="row">세일가</th>
        <td><?= $data->sale_price; ?></td>
      </tr>      
      <tr>
        <th scope="row">할인율</th>
        <td><?= $data->sale_ratio; ?></td>
      </tr>      
      <tr>
        <th scope="row">전시옵션</th>
        <td>
            <label class="form-check-label" for="ismain">메인</label>            
            <input class="form-check-input" type="checkbox" <?php echo $data->ismain ? 'checked' : ''; ?> disabled>
            
            <label class="form-check-label" for="isnew">신제품</label>
            <input class="form-check-input" type="checkbox" <?php echo $data->isnew ? 'checked' : ''; ?> disabled>
            
            <label class="form-check-label" for="isbest">베스트</label>
            <input class="form-check-input" type="checkbox"  <?php echo $data->isbest ? 'checked' : ''; ?> disabled>
            
            <label class="form-check-label" for="isrecom">추천</label>
            <input class="form-check-input" type="checkbox" <?php echo $data->isrecom ? 'checked' : ''; ?> disabled>       
        </td>
      </tr>  
      <tr>
        <th scope="row">판매종료일</th>
        <td><?= $data->sale_end_date; ?></td>
      </tr>            
      <?php 
      if(isset($options1)){
        ?> 
      <tr>
        <th scope="row">컬러</th>
        <td>          
            <?php               
                foreach($options1 as $op){              
            ?> 
            <ul class="d-flex gap-3 list-unstyled" >
              <li class="w-5"><?= $op->option_name;?></li>
              <li class="w-5"><?= $op->option_price ;?></li>
              <li class="w-5">
                <a href="<?= $op->image_url;?>" target="_blank">
                  <img src="<?= $op->image_url;?>" alt="" style="width:50px">
                </a>
              </li>             
            </ul>
            <?php     
                }          
            ?>
        </td>
      </tr>
      <?php 
        }
      ?>   
      <?php 
      if(isset($options2)){
        ?> 
      <tr>
        <th scope="row">사이즈</th>
        <td>          
            <?php               
                foreach($options2 as $op){              
            ?> 
            <ul class="d-flex gap-3 list-unstyled" >
              <li class="w-5"><?= $op->option_name;?></li>
              <li class="w-5"><?= $op->option_price ;?></li>
              <li class="w-5">
                <a href="<?= $op->image_url;?>" target="_blank">
                  <img src="<?= $op->image_url;?>" alt="" style="width:50px">
                </a>
              </li>             
            </ul>
            <?php     
                }          
            ?>
        </td>
      </tr>
      <?php 
        }
      ?>   
    </tbody>
  </table>
  <hr>
  <ul class="list-unstyled d-flex gap-3 justify-content-end">
    <li><button class="btn btn-primary btn-sm" id="goback">상품목록</button></li>
    <li><a href="product_edit.php?pid=<?=$pid;?>" class="btn btn-secondary btn-sm">수정</a></li>
    <li><a href="product_del.php?pid=<?=$pid;?>" class="btn btn-danger btn-sm">삭제</a></li>
  </ul>
</div>
<script>
  $('#goback').click(function(){
    history.back();
  }); 
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
