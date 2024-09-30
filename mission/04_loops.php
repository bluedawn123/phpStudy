<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>04 반복문</title>
</head>
<body>
  <h2>반복문</h2>
  <h3>1-1</h3>
  <p>while 반복문으로 1에서 1씩 증가하여, 6까지 출력되도록</p>
  <?php
     $i = 1;
     while($i <= 6){
       echo $i.'<br>';
       $i++;
     }
  ?>


  <h3>1-2</h3>
  <p>for 반복문으로 1에서 1씩 증가하여, 6까지 출력되도록</p>
  <?php
  for($x = 1; $x < 7; $x ++){
    echo "<li>$x</li>";
  }

  ?>



</body>
</html>

