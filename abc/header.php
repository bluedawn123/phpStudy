<?php
  if(!isset($title)){
    $title = '';
  }
  //세션있는지 없는지 확인. 없다면 session시작
  if(!isset($_SESSION)){
    session_start();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?> - abc</title>
</head>
<body>
  <header>
    <h1><a href="index.php">Logo</a></h1>
    <nav>
      <ul>
        <li><a href="about.php">about</a></li>
        <li><a href="works.php">works</a></li>
        <li><a href="contact.php">contact</a></li>
        <li><a href="mypage.php">mypage</a></li>  <!--로그인이 되어있을떄는 보이고, 없을떄는 안 보여야한다. -->
        
        <!-- 세션이 있을때(즉 로그인 됐을때)와 없을때 구분 -->
        <?php  
          if( isset($_SESSION['useremail']) ){
            echo '<li><a href="logOut.php">logOut</a></li>';
          }else{
            echo '<li><a href="login.php">login</a></li>';

          }
        ?>

      </ul>
    </nav>
  </header>