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
  ON p.cate LIKE concat(c.code,'%')
  GROUP BY c.name";

$result = $mysqli->query($sql);
$resultArr = [];
while($data = $result->fetch_object()){
  $resultArr[] = $data;
}

$labels = [];
$data = [];

foreach($resultArr as $item){
  // $labels[] = $item->name;
  array_push($labels, $item->name);
  array_push($data, $item->product_count);
}

?>
<div class="container">
  <h1>ABCMall Administration</h1>
  <?php
  if($_SESSION['AULEVEL'] == 100){
  ?>
  <a href="product/category.php">카테고리</a>
  <a href="product/product_list.php">상품관리</a>
  <a href="coupon/coupon_list.php">쿠폰관리</a>
  <a href="teacher/teacher_list.php">강사관리</a>
  <?php
    } else if($_SESSION['AULEVEL'] == 10){
  ?>
  <a href="product/product_list.php">상품관리</a>
  <?php
    } 
  ?>   
  <h2>Chart</h2>
  <div>
    <canvas id="myChart"></canvas>
  </div>
</div>

<script>
  const ctx = document.getElementById('myChart');
  let cateLabels = <?= json_encode($labels);?>;
  let cateDatas = <?= json_encode($data);?>;

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
