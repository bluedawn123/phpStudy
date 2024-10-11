<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/db.php');

  $username = $_POST['name'];
  $userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);

  $title = $_POST['title'];
  $content = $_POST['content'];

  if(isset($_POST['lockpost'])){
    $lock_post = 1;
  }else{
    $lock_post = 0;
  }
  
  //print_r($_FILES['attach']);

  $max_file_size = 10*1024*1024;

  if($_FILES['attach']['size']>$max_file_size ){
    echo "<script>
      alert('10MB 이상을 첨부할 수 없습니다.');
      history.back();
    </script>";
    exit;
  }

  
  //파일업로드
  $file_name = $_FILES['attach']['name'];
  $temp_path = $_FILES['attach']['tmp_name'];
  $upload_path = '../upload/'.$file_name;
  move_uploaded_file($temp_path, $upload_path);
  
 strpos($_FILES['attach']['type'],'image') !== false ? $is_img = 1 : $is_img= 0;

  $sql = "INSERT INTO 
  board (name, pw, title, content,file, lock_post,is_img) 
  VALUES ('$username','$userpw','$title','$content','$upload_path', $lock_post, $is_img)";

  // $result = $mysqli->query($sql);

  if($mysqli->query($sql) === true){
    echo "<script>
      alert('글작성 완료');
      location.href = '../index.php';
    </script>";
  }else{
    echo "<script>
      alert('글작성 실패');
      location.href = '../index.php';
    </script>";
  }

?>