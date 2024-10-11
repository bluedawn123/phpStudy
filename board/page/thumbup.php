<?php
  include_once($_SERVER['DOCUMENT_ROOT'].'/board/inc/db.php');

  $idx = $_GET['idx'];
  $sql ="SELECT likes FROM board WHERE idx = $idx";
  $result = $mysqli->query($sql);
  $data = $result->fetch_assoc();
  // print_r($data);
  $likes = $data['likes']+1;

  $updateSql = "UPDATE board set likes=$likes WHERE idx = $idx";
  $updateResult = $mysqli->query($updateSql);
  if($updateResult){
    echo "<script>
      alert('추천성공');
      location.href = '../index.php';
    </script>";
  }else{
    echo "<script>
      alert('추천실패');
      location.href = '../index.php';
    </script>";
  }
  /*
  $idx에 추천하고자 하는 글 번호 할당
  $sql에 board 테이블에서 idx컬럼의 값이 $idx와 일치하는 행(데이터)에서 추천수를 조회
  $result에 $sql의 쿼리 실행결과를 할당
  $data에 $result결과의 값을 연관배열로 할당
  $likes에 기존추천수에 1더하기

  $updateSql에 board 테이블에서 idx컬럼의 값이 $idx와 일치하는 행(데이터)의 추천수를 $likes로 수정하는 쿼리
  $updateResult에 $updateSql 쿼리 실행결과를 할당
  
  $updateResult의 값이 있으면 '추천했습니다' 경고창 띄우고 목록으로 이동
  $updateResult의 값이 없으면 '추천실패' 경고창 띄우고 목록으로 이동
  */
?>