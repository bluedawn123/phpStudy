<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>07 form</title>
</head>
<body>
  <!-- 
    아래 폼을 참조하여, 
    07_2form_ok.php,  07_3form_ok.php을 작성합니다.  
  -->
  <h2>폼</h2>
  <h3>1-1</h3>
  <form action="07_2form_ok.php" method="get">
    이름: <input type="text" name="username">
          <button>send</button>
  </form>

  <h2>1-2</h2>
  <form action="07_3form_ok.php" method="post">
    이름: <input type="text" name="username">
          <button>send</button>
  </form>

  <h2>1-3</h2>
  <form action="07_4form_ok.php?subscribe=gold" method="post">
    이름: <input type="text" name="username">
          <button>send</button>
  </form>
</body>
</html>

