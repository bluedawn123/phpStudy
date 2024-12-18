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
  $input_content = $_POST['content']; //수정한 내용

  //password_verify(입력한비번,원래비번)  일치 여부 true, false 반환

  if(password_verify($input_pw,$reply_pw)){
    /*
      replay 테이블에서 idx의 값이 $r_no와 일치하는 행에서 content컬럼의 값을 $input_content로 업데이트
    */
    $update_sql = "UPDATE reply SET content='$input_content' WHERE idx=$r_no";
    $update_result = $mysqli->query($update_sql);

    if($update_result){
      echo "
      <script>
        alert('댓글이 수정되었습니다.');
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