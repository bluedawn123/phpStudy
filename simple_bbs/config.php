<?php
$mysqli = mysqli_connect('localhost', 'simple_bbs', '123123', 'simple_bbs');

if (mysqli_connect_errno()) {
  throw new RuntimeException('연결오류 실패: ' . mysqli_connect_error());
}
?>