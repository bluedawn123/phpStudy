<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

$cate = $_POST['cate'];
$step = $_POST['step'];
$category = $_POST['category'];

$sql = "SELECT * FROM category WHERE step = $step and pcode = '$cate'";
$result = $mysqli->query($sql);

$html = "<option selected value=\"\">{$category}</option>";

while($data = $result->fetch_object()){ //조회된 값들 마다 할일, 값이 있으면 $data할당
  $html .= "<option value=\"{$data->code}\">{$data->name}</option>";
}

echo $html;
$mysqli->close();
?>