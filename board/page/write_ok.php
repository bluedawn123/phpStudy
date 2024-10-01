<?php
 include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/db.php');

 //print_r($_POST); Array ( [name] => [title] => [content] => )
  
//write.php에서 name="~~~" 으로 던진 name pw title content 를 받음. 이걸 써줘야함.
  $username = $_POST['name'];
  $userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
  $title = $_POST['title'];
  $content = $_POST['content'];

  $sql = "INSERT INTO board (name, pw, title, content) VALUES('$username', '$userpw', '$title', '$content')";

  // $result = $mysqli->query($sql);

 /*
 글 작성이 완료되면 '글쓰기 완료' 경고창을 띄우고 리스트 페이지로 이동
 */

 if($mysqli->query($sql) === true){
  echo "
  <script>
    alert('글쓰기 완료');
    location.href = '../index.php';
  </script>
  ";
}else{
  echo 
  "<script>
    alert('글쓰기 실패');
    location.href = '../index.php';
  </script>
  ";
}

?>