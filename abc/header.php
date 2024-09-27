<?php
  if(!isset($title)){
    $title = '';
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
      </ul>
    </nav>
  </header>