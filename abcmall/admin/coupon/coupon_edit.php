<?php
$title = "쿠폰 수정";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}

$cid = $_GET['cid'];

$sql = "SELECT * FROM coupons WHERE cid = $cid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

?>

<div class="container">
  <h1>쿠폰 수정</h1>
  <form action="coupon_edit_ok.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="cid" value="<?= $cid; ?>"> 
  <table class="table">
      <tbody>
        <tr>
          <th scope="row">쿠폰명</th>
          <td><input type="text" class="form-control" name="coupon_name" required value="<?= $data->coupon_name; ?>"></td>
        </tr>
        <tr>
          <th scope="row">쿠폰이미지</th>
          <td>
            <img src="<?= $data->coupon_image; ?>" alt="<?= $data->coupon_name; ?>" id="coupon_old_image" class="w-25">
            <input type="file" accept="image/*" id="coupon_image" class="form-control w-50" name="coupon_image" required>
          </td>
        </tr>
        <tr>
          <th scope="row">쿠폰타입</th>
          <td>
            <select class="form-select w-25" name="coupon_type" id="coupon_type" aria-label="쿠폰타입">                            
              <option value="1" <?php if($data->coupon_type == 1){echo 'selected';}?>>정액</option>
              <option value="2" <?php if($data->coupon_type == 2){echo 'selected';}?>>정률</option>
            </select>
          </td>
        </tr>
        <tr id="ct1">
          <th scope="row">할인가</th>
          <td>
            <div class="input-group mb-3">
              <input type="text" name="coupon_price" class="form-control" aria-label="할인가" value="<?= $data->coupon_price; ?>" aria-describedby="coupon_price" > 
              <span class="input-group-text" id="coupon_price">원</span>
            </div>
          </td>
        </tr>        
        <tr id="ct2">
          <th scope="row">할인비율</th>
          <td>
            <div class="input-group mb-3">
              <input type="text" name="coupon_ratio" class="form-control" aria-label="할인비율" value="<?= $data->coupon_ratio; ?>" aria-describedby="coupon_ratio" >
              <span class="input-group-text" id="coupon_ratio">%</span>
            </div>
          </td>
        </tr>        
        <tr>
          <th scope="row">최소사용금액</th>
          <td>
            <div class="input-group mb-3">
              <input type="text" name="use_min_price" class="form-control" aria-label="최소사용금액" value="<?= $data->use_min_price; ?>" aria-describedby="use_min_price" >
              <span class="input-group-text" id="use_min_price">원</span>
            </div>
          </td>
        </tr>        
        <tr>
          <th scope="row">최대할인금액</th>
          <td>
            <div class="input-group mb-3">
              <input type="text" name="max_value" class="form-control" aria-label="최대할인금액" value="<?= $data->max_value; ?>" aria-describedby="max_value" >
              <span class="input-group-text" id="max_value">원</span>
            </div>
          </td>
        </tr>    
        <tr>
          <th scope="row">상태</th>
          <td>
            <select class="form-select w-25" name="status" aria-label="상태">                            
              <option value="1" <?php if($data->status == 1){echo 'selected';}?>>대기</option>
              <option value="2" <?php if($data->status == 2){echo 'selected';}?>>활성화</option>
              <option value="3" <?php if($data->status == 3){echo 'selected';}?>>비활성화</option>
            </select>
          </td>
        </tr>            
      </tbody>
    </table>
    <button class="btn btn-primary">쿠폰등록</button>
  </form>
</div>
<script>
  //$('#ct2 input').prop('disabled', true);

  $('#coupon_type').change(function(){
    let value = $(this).val();
    $('#ct1 input, #ct2 input').prop('disabled', true);
    if(value == 1){
      $('#ct1 input').prop('disabled', false);
    } else{
      $('#ct2 input').prop('disabled', false);
    }
  });

  $('#coupon_image').on('change',(e)=>{
    let file = e.target.files[0];

    const reader = new FileReader(); 
    reader.onloadend = (e)=>{ 
      let attachment = e.target.result;
      if(attachment){
        let target = $('#coupon_old_image');
        target.attr('src',attachment)
      }
    }
    reader.readAsDataURL(file); 
  });


</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
