<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');

if(!isset($title)){
  $title = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?> ABCmall</title>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/admin/css/main.css">
  
  <?php 
    if(isset($summernote_css)){
      echo $summernote_css;
    }
    if(isset($additional_css)){
      echo $additional_css;
    }
  ?>
  <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
  <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
  <?php 
    if(isset($summernote_js)){
      echo $summernote_js;
    }
    if(isset($chart_js)){
      echo $chart_js;
    }
  ?>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="http://<?= $_SERVER['HTTP_HOST']?>/abcmall/admin/index.php">관리자 홈</a>
      <div>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php
            if(!isset($_SESSION['AUID'])){
          ?>
          <li class="nav-item">
            <a class="nav-link" href="#">로그인</a>
          </li>
          <?php
            } else {
          ?>          
          <li class="nav-item">
            <a class="nav-link" href="#"><?= $_SESSION['AUNAME']; ?>님</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://<?= $_SERVER['HTTP_HOST']?>/abcmall/admin/logout.php">로그아웃</a>
          </li>
          <?php
           }
          ?>           
        </ul>
      </div>
    </div>
  </nav>
