<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
</head>
<body>
  <div class="container">
    <h2>회원가입</h2>
    <form action="signup_ok.php" method="POST" id="signup_form">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="username" placeholder="Your Name" name="username" required>
        <label for="username">Name</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="userid" placeholder="ID" name="userid" required>
        <label for="userid">ID</label>
        <button type="button" id="idcheck" class="btn btn-secondary btn-sm">중복체크</button>
      </div>
      <div class="form-floating mb-3">
        <input type="email" class="form-control" id="useremail" placeholder="Email" name="email" required>
        <label for="useremail">Email</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="userpw" placeholder="Password" name="passwd" required>
        <label for="userpw">Password</label>
      </div>
      <button class="mt-3 btn btn-primary">회원가입</button>
    </form>
  </div>
  <script>
    let idChecked = false;

    $('#idcheck').click(function(){
      let userid = $('#userid').val();
      if(userid == ''){
        alert('아이디를 입력해주세요');
        $('#userid').focus();
      } else{
        idCheck_func(userid);
      }
    });

    function idCheck_func(userid){

      let data = {
        userid:userid
      }
      $.ajax({
        async:false,       
        url:'id_check.php',
        data:data, 
        type:'post', 
        dataType:'json', 
        error:function(){
          //연결실패시 할일
        },
        success:function(returned_data){
          //연결성공시 할일, image_delete.php가 echo 출력해준 값을 매배견수 returend_data 받자
          if(returned_data.result == 'ok'){
            alert('사용할 수 있는 아이디입니다.');
            idChecked = true;
            $('#userid').attr('readonly','readonly');
            return;
          } else if(returned_data.result == 'error'){
            alert('중복되는 아이디입니다.');
            return;
          } 
        }
      })
    }

    $('#signup_form').submit(function(e){
      if (!idChecked) {
        e.preventDefault();
        alert('아이디 중복체크를 해주세요');
      }
    });
  </script>
</body>
</html>