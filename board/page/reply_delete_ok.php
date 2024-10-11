<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/db.php');

  $r_no = $_POST['r_no']; //댓글의 번호
  $b_no = $_POST['b_no']; //게시글의 글 번호

  //댓글의 비번 조회
  $sql = "SELECT password FROM reply WHERE idx = $r_no";
  $result = $mysqli->query($sql);
  $reply = $result->fetch_assoc();

  $reply_pw = $reply['password']; //원래 비번 hash 암호화
  $input_pw = $_POST['pw']; //입력한 비번

  if(password_verify($input_pw,$reply_pw)){
    $delete_sql = "DELETE FROM reply where idx=$r_no";
    $delete_result = $mysqli->query($delete_sql);

    if($delete_result){
      echo "
      <script>
        alert('댓글이 삭제되었습니다.');
        location.replace('read.php?idx={$b_no}');
      </script>
    ";
    }

  }else{
    echo "
      <script>
        alert('비번이 일치하지 않습니다');
        history.back();
      </script>
    ";
  }

?>