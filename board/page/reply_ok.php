<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');

/*
$idx에 게시글의 번호를 할당
$uerpw에 입력한 비번을 hash로 암호화해서 할당
$name에 댓글작성자 이름을 할당
$content에 댓글 내용 할당
$sql에 reply 테이블에 b_idx, name, password, content항목에 값을 입력하는 쿼리 할당
$result에 $sql 쿼리 실행 결과 할당
$result 결과가 있다면 '댓글작성완료' 경고창 띄우고 목록으로, 아니면 '실패'하고 목록으로.
*/

$idx = $_POST['idx'];  //예를들어, 게시글 7번글이면, 7을 넘겨 담는거.
$name = $_POST['name'];
$userpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
$content = $_POST['content'];

$sql = "INSERT INTO reply 
  (b_idx, name, password, content) 
  VALUES
  ('$idx', '$name', '$userpw', '$content')";

// 확인작업작업 //echo $sql;
$result = $mysqli->query($sql);

if($result){
  echo "<script>
    alert('댓글작성완료');
    location.href = '../index.php';
  </script>";
}else{
  echo "<script>
    alert('댓글작성실패');
    location.href = '../index.php';
  </script>";
}

?>
