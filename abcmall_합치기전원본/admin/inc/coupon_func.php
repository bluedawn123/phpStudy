<?php

function coupon_func($cid, $due, $userid, $reason){
  global $mysqli;
  $coupon_sql = "SELECT cid FROM coupons WHERE cid = $cid";
  $coupon_result = $mysqli->query($coupon_sql);
  $coupon_data = $coupon_result->fetch_object();  // $coupon_data->cid

  $due_date = date('Y-m-d 23:59:59', strtotime("+{$due} days"));

  $uc_sql = "INSERT INTO user_coupons 
  (couponid, userid, status, use_max_date, reason) 
  VALUES 
  ($coupon_data->cid, '$userid',  1, '$due_date', '$reason')";
  $uc_result = $mysqli->query($uc_sql);

  echo "<script>
    alert('회원가입이 완료되었습니다. 가입축하쿠폰이 발행되었습니다.');
    location.href = 'http://" . $_SERVER['HTTP_HOST'] . "/abcmall/index.php';
  </script>";
}

?>