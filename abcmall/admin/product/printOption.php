<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ABCMALL/admin/inc/header.php');

//넘겨서 온 데이터
$cate = $_POST['cate'];
$step = $_POST['step'];
$category = $_POST['category'];

$sql = "SELECT * FROM category WHERE step = $step and pcode = '$cate' ";
$result = $mysqli->query($sql);

$html = "<option selected>{$category}</option>";

while($data = $result->fetch_object() ){  
  $html .= "<option value=\"{$data->code}\">{$data->name}</option>";  ;
}

echo $html;  //화면에 되돌려주는 방법은 이것하나!

?>