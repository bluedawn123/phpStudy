<?php
$chart_js = "<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = 'login.php';
    </script>
  ";
}

$sql = "SELECT c.name, COUNT(p.pid) AS product_count 
        FROM products p 
        JOIN category c 
        ON p.cate LIKE concat(c.code, '%')
        GROUP BY c.name"; // 그룹핑에서 세미콜론 제거
$result = $mysqli->query($sql);
$resultArr = [];
while($data = $result->fetch_object()) {
    $resultArr[] = $data;
}
// echo "<pre>";
// print_r($resultArr);
// echo "</pre>";
/*
Array
(
    [0] => stdClass Object
        (
            [name] => 컴퓨터
            [product_count] => 35
        )

    [1] => stdClass Object
        (
            [name] => 핸드폰
            [product_count] => 1
        )

)  ...이런식으로 연관배열로 나온다. 
*/

$labels = [];
$data = [];
foreach ($resultArr as $item){
  array_push($labels, $item->name);
  array_push($data, $item -> product_count);
}
// echo "<pre>";
// print_r($resultArr);
// print_r($labels);
// print_r($data);
// echo "</pre>";

/*
Array
(
    [0] => 컴퓨터
    [1] => 핸드폰
)
Array
(
    [0] => 35
    [1] => 1
)


*/
?>
<div class="container">
  <h1>ABCMall Administration</h1>
  <?php
  if($_SESSION['AULEVEL'] == 100){
    ?>


  <a href="login.php">로그인</a>
  <a href="product/category.php">카테고리</a>
  <a href="product/product_list.php">상품관리</a>
  <a href="coupon/coupon_list.php">쿠폰관리</a>
  <a href="teacher/teacher_list.php">강사관리</a>
    <?php
      }else if($_SESSION['AULEVEL'] == 10){
    ?>

  <a href="product/product_list.php">상품관리</a>
    <?php
    }
    ?>
  
  <h2>CHart</h2>
  <div>
    <canvas id="myChart"></canvas>
  </div>
</div>


<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<script>
  const ctx = document.getElementById('myChart');
  let cateLabels = <?=  json_encode($labels); ?>;
  let cateDatas = <?=  json_encode($data); ?>;

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: cateLabels,
      datasets: [{
        label: '카테고리별 상품수',
        data: cateDatas,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
