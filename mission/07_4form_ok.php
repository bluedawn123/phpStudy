<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>07 form</title>
</head>
<body>
  <h2>폼</h2>
  <h3>1-2</h3>
  <!--  코드 작성   -->
  <?php 
    //get이나 post나 뭘로 오든 오는 방법 => request 사용
    print_r($_REQUEST);

    echo $_REQUEST['subscribe'];
    echo $_REQUEST['username'];
  
  ?>
</body>
</html>

