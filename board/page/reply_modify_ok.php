<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/header.php');

  $r_no = $_POST['r_no'];  //댓글의 번호
  $b_no = $_POST['b_no'];  //게시글의 번호

  //댓글의 비번 조회
  $sql = "SELECT password FROM reply where idx = $r_no";

  //위 sql실행
  $result = $mysqli->query($sql);
  $reply = $result->fetch_assoc();

  $reply_pw = $reply['password']; //원래 비번(암호화되어있음)
  $input_pw = $_POST['pw'];  //사용자가 입력한 비번
  $input_content = $_POST['content']; //수정한 내용

  //당연히 두개가 다르므로, password_verify()를 써서 일치여부를 확인해야함
  //true, false 반환
  if(password_verify($input_pw, $reply_pw)){
    /*비밀번호가 일치하면, reply테이블에서 idx의 값이 $r_no와 일치하는 행에서
    content칼럼의 값을 $input_content로 업데이트! */  
    $update_sql = "UPDATE reply SET content = '$input_content' where idx=$r_no";
    $update_result = $mysqli->query($update_sql);

    if($update_result){
    echo "
      <script>
        alert('댓글이 수정되었습니다.')
        location.replace('read.php?=idx{$b_no}');
      </script>
    ";
    }
  }else{
    echo "
    <script>
      alert('비밀번호가 일치하지않습니다.')
      history.back();
    </script>
    ";
  }
 




?>
