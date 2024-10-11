<?php
$title = "상품상세";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');

$pid = $_GET['pid'];

if(!isset($pid)){
  echo "
  <script>
    alert('상품정보가 없습니다.');
    location.href = '../prouduct/product_list.php';
  </script>
  ";
  exit;
}



$sql = "SELECT * FROM products WHERE pid = $pid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

$cate = $data->cate; 
$cate1 = substr($cate, 0, 5); // A0001 
$cate2 = substr($cate, 5, 5); // B0001 
$cate3 = substr($cate, 10, 5); // C0001

$cate_sql = "SELECT name FROM category WHERE code IN ('$cate1', '$cate2', '$cate3')";
$result = $mysqli->query($cate_sql);


// 카테고리 이름 배열에 저장
$category_names = [];
while ($row = $result->fetch_object()) {
    $category_names[] = $row->name;  //배열로 나옴
}

//print_r($category_names)  Array ( [0] => 컴퓨터 [1] => 노트북 [2] => 게임용 )

//배열에 있는걸 합쳐줌
$category_display = implode(' / ', $category_names);  
//echo $category_display;   결과: 컴퓨터 / 노트북 / 게임용



?>

<div class="contaier">
  <h1>상품수정</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">구분</th>
        <th scope="col">내용</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="col">제품명</th>
        <td><?= $data->name ?></td>
      </tr>
      <tr>
        <th scope="col">썸네일</th>
        <td><img src="<?= $data->thumbnail; ?>"  style="width: 9rem;"></td>
      </tr>
      <tr>
        <th scope="col">카테고리</th>
        <td><?= $category_display ?></td>
      </tr>
      <tr>
        <th scope="col">상세설명</th>
        <td><?= $data->content ?></td>
      </tr>
      <tr>
        <th scope="col">가격</th>
        <td><?= $data->price ?></td>
      </tr>
      <tr>
        <th scope="col">세일가격</th>
        <td><?= $data->sale_price; ?></td>
      </tr>
      <tr>
        <th scope="col">할인률</th>
        <td><?= $data->sale_ratio ?></td>
      </tr>
      <tr>
        <th scope="row">전시옵션</th>
        <td>
          <label class="form-check-label" for="ismain"><?= $data->ismain ?></label>
          <input class="form-check-input" type="checkbox" <?php echo $data->ismain ? 'checked' : '' ?> disabled>

          <label class="form-check-label" for="isnew"><?= $data->isnew ?></label>
          <input class="form-check-input" type="checkbox" <?php echo $data->isnew ? 'checked' : '' ?> disabled>
            
          <label class="form-check-label" for="isbest"><?= $data->isbest ?></label>
          <input class="form-check-input" type="checkbox" <?php echo $data->isbest ? 'checked' : '' ?>checked disabled>
            
          <label class="form-check-label" for="isrecom"><?= $data->isrecom ?></label>
          <input class="form-check-input" type="checkbox" <?php echo $data->isrecom ? 'checked' : '' ?>disabled>
        </td>       
      </tr>
      <tr>
        <th scope="col">판매종료일</th>
        <td><?= $data->sale_end_date; ?></td>
      </tr>
    </tbody>
  </table>
  <hr>
  <ul class="d-flex gap-3 justify-content-end list-unstyled">
    <li><button class="btn btn-primary btn-sm" id="goback">상품목록</button></li>
    <li><a href="" class="btn btn-secondary btn-sm">상품수정</a></li>
    <li><a href="" class="btn btn-danger btn-sm">상품삭제</a></li>
  </ul>
</div>

<script>
$('#goback').click(function(){
  history.back();
})




</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>