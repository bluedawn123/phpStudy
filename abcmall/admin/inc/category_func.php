<?php

//대분류 조회
$sql = "SELECT * FROM category WHERE step = 1";
$result = $mysqli->query($sql) or die('query error :'.$mysqli->error);
while($data = $result->fetch_object()){ //조회된 값들 마다 할일, 값이 있으면 $data할당
  $cate1[]= $data; //$cate1배열에 $data할당
}

?>