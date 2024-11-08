<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/coupon_func.php');

$username = trim($_POST['username']);
$userid = trim($_POST['userid']);
$email = trim($_POST['email']);
$passwd = trim($_POST['passwd']);
$passwd = hash('sha512', $passwd);

echo $userid;

//중복 id 개수 조회
$id_sql = "SELECT COUNT(*) AS cnt FROM admins WHERE userid='$userid '";
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


$sql = "INSERT INTO admins (username, userid, email, passwd,level) VALUES ('$username','$userid','$email','$passwd', 10)";
$result = $mysqli->query($sql);

if($result){
  echo "<script>
    alert('강사등록 완료');
    location.href = 'teacher_list.php';
  </script>";

} else{
  echo "<script>
    alert('강사등록 실패');
    history.back();
  </script>";
}

?>
