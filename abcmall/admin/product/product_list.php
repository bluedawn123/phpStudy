<?php
$title = "상품목록";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');
if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인 해 주세요.');
      location.href='../login.php';
    </script>
  " ;
}

//모든 상품 조회
$sql = "SELECT * FROM products ";
$result = $mysqli->query($sql) or die('query error :'.$mysqli->error);
while($data = $result->fetch_object()){ 
  $dataArr[]= $data; 

  
}
print_r($dataArr);
?>

<div class="container">
  <h1>상품리스트</h1>
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
      <tr>
        <th scope="row">1</th>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <hr>
  <a href="product_up.php" class="btn btn-primary">상품등록</a>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
