<?php
$title = "쿠폰 등록";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}
?>

<div class="container">
  <h1>쿠폰 등록</h1>
  <form action="coupon_ok.php" method="POST" enctype="multipart/form-data">
    <table class="table">
      <tbody>
        <tr>
          <th scope="row">쿠폰명</th>
          <td><input type="text" class="form-control" name="coupon_name" required></td>
        </tr>
        <tr>
          <th scope="row">쿠폰이미지</th>
          <td><input type="file" accept="image/*" class="form-control w-50" name="coupon_image" required></td>
        </tr>
        <tr>
          <th scope="row">쿠폰타입</th>
          <td>
            <select class="form-select w-25" name="coupon_type" id="coupon_type" aria-label="쿠폰타입">                            
              <option value="1" selected>정액</option>
              <option value="2">정률</option>
            </select>
          </td>
        </tr>
        <tr id="ct1">
          <th scope="row">할인가</th>
          <td>
            <div class="input-group mb-3">
              <input type="text" name="coupon_price" class="form-control" aria-label="할인가" value="0" aria-describedby="coupon_price"> 
              <span class="input-group-text" id="coupon_price">원</span>
            </div>
          </td>
        </tr>        
        <tr id="ct2">
          <th scope="row">할인비율</th>
          <td>
            <div class="input-group mb-3">
              <input type="text" name="coupon_ratio" class="form-control" aria-label="할인비율" value="0" aria-describedby="coupon_ratio">
              <span class="input-group-text" id="coupon_ratio">%</span>
            </div>
          </td>
        </tr>        
        <tr>
          <th scope="row">최소사용금액</th>
          <td>
            <div class="input-group mb-3">
              <input type="text" name="use_min_price" class="form-control" aria-label="최소사용금액" value="0" aria-describedby="use_min_price">
              <span class="input-group-text" id="use_min_price">원</span>
            </div>
          </td>
        </tr>        
        <tr>
          <th scope="row">최대할인금액</th>
          <td>
            <div class="input-group mb-3">
              <input type="text" name="max_value" class="form-control" aria-label="최대할인금액" value="0" aria-describedby="max_value">
              <span class="input-group-text" id="max_value">원</span>
            </div>
          </td>
        </tr>    
        <tr>
          <th scope="row">상태</th>
          <td>
            <select class="form-select w-25" name="status" aria-label="상태">                            
              <option value="1">대기</option>
              <option value="2">활성화</option>
              <option value="3">비활성화</option>
            </select>
          </td>
        </tr>            
      </tbody>
    </table>
    <button class="btn btn-primary">쿠폰등록</button>
  </form>
</div>
<script>
  $('#ct2 input').prop('disabled', true);

  $('#coupon_type').change(function(){
    let value = $(this).val();
    $('#ct1 input, #ct2 input').prop('disabled', true);
    if(value == 1){
      $('#ct1 input').prop('disabled', false);
    } else{
      $('#ct2 input').prop('disabled', false);
    }
  });
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
