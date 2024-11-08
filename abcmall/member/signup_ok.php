<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/coupon_func.php');

$username = $_POST['username'];
$userid = $_POST['userid'];
$email = $_POST['email'];
$passwd = $_POST['passwd'];
$passwd = hash('sha512', $passwd);

echo $userid;

//중복 id 개수 조회
$id_sql = "SELECT COUNT(*) AS cnt FROM members WHERE userid='$userid '";
$id_result = $mysqli->query($id_sql);
$id_data = $id_result->fetch_assoc();
$row_num = $id_data['cnt'];  //중복 1, 중복x 0


if($row_num >= 1){
  echo "<script>
    alert('아이디가 중복됩니다.');
    history.back();
  </script>";
  exit;
}


$sql = "INSERT INTO members (username, userid, email, passwd) VALUES ('$username','$userid','$email','$passwd')";
$result = $mysqli->query($sql);

if($result){
  //회원가입 축하 쿠폰 발행
  coupon_func(3, 30, $userid, '회원가입 축하');

} else{
  echo "<script>
    alert('가입 실패');
    history.back();
  </script>";
}

?>
