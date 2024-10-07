<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');

//대분류를 조회
//option에 넣어줘야 된다.
$sql = "SELECT * FROM category WHERE step =1";
$result = $mysqli->query($sql) or die('query error :'.$mysqli->error);
while($data = $result->fetch_object()){// 조회된 값들 마다 할일, 값이 있으면 $data할당
  $cate1[]= $data;// $cate1배열에 $data할당
}
//print_r($cate1);
?>
<div class="container">
  <h1>카테고리</h1>
  <div class="row">
    <div class="col-md-4">
    <select class="form-select" id="cate1" aria-label="대분류 선택">
      <option selected>대분류 선택</option>
      <?php
        foreach($cate1 as $c1){
      ?>
      <option value="<?= $c1->code ?>"><?= $c1->name?></option>
      <?php
        }
      ?>
    </select>
    </div>
    <div class="col-md-4">
    <select class="form-select" id="cate2" aria-label="Default select example">
      <option selected>대분류를 먼저 선택하세요</option>
    </select>
    </div>
    <div class="col-md-4">
    <select class="form-select" id="cate3" aria-label="Default select example">
      <option selected>중분류를 먼저 선택하세요</option>
    </select>
    </div>
  </div>
  <div class="btns mt-3">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cate1_modal">
      대분류 등록
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cate2_modal">
      중분류 등록
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cate3_modal">
      소분류 등록
    </button>
  </div>


<!-- Modal 1 -->
<div class="modal fade" id="cate1_modal" tabindex="-1" aria-labelledby="cate1_modal" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" data-step="1" class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">대분류 등록</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body row">
        <div class="col-md-6">
          <input type="text" class="form-control" name="code1" id="code1" placeholder="코드명을 입력하세요." pattern="A\d{4}" 
          title="A로 시작하고 뒤에 네 자리 숫자가 와야 합니다. 예: A0001, A1234" required>
        </div>
        <div class="col-md-6">
          <input type="text" class="form-control" name="name1" id="name1" placeholder="분류명을 입력하세요." required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
        <button type="submit" class="btn btn-primary">등록</button>
      </div>
    </form>
  </div>
</div>
</div>
<!-- Modal 2 -->
<div class="modal fade" id="cate2_modal" tabindex="-1" aria-labelledby="cate2_modal" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" data-step="2" class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">중분류 등록</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <select class="form-select" name="pcode2" id="pcode2" aria-label="대분류 선택">
          <option selected>대분류 선택</option>
          <?php
            foreach($cate1 as $c1){
          ?>
          <option value="<?= $c1->code ?>"><?= $c1->name?></option>
          <?php
            }
          ?>
      </select>
      <div class="row mt-3">
        <div class="col-md-6">
          <input type="text" class="form-control" name="code2" id="code2" placeholder="코드명을 입력하세요." pattern="B\d{4}" 
          title="B로 시작하고 뒤에 네 자리 숫자가 와야 합니다. 예: B0001, B1234" required>
        </div>
        <div class="col-md-6">
          <input type="text" class="form-control" name="name2" id="name2" placeholder="분류명을 입력하세요." required>
        </div>
      </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
        <button type="submit" class="btn btn-primary">등록</button>
      </div>
    </form>
  </div>
</div>
</div>
<!-- Modal 3 -->
<div class="modal fade" id="cate3_modal" tabindex="-1" aria-labelledby="cate3_modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">소분류 등록</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <select class="form-select" name="pcode3" id="pcode3" aria-label="대분류 선택">
              <option selected>대분류 선택</option>
              <?php
                foreach($cate1 as $c1){
              ?>
              <option value="<?= $c1->code ?>"><?= $c1->name?></option>
              <?php
                }
              ?>
        </select>
          </div>
          <div class="col-md-6">
            <select class="form-select" name="pcode4" id="pcode4" aria-label="Default select example">
              <option selected>대분류를 먼저 선택하세요</option>
            </select>
          </div>
        </div>
        <div class="row mt-3">
        <div class="col-md-6">
          <input type="text" class="form-control" name="code3" id="code3" placeholder="코드명을 입력하세요." pattern="C\d{4}" 
          title="C로 시작하고 뒤에 네 자리 숫자가 와야 합니다. 예: C0001, C1234" required>
        </div>
        <div class="col-md-6">
          <input type="text" class="form-control" name="name3" id="name3" placeholder="분류명을 입력하세요." required>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
        <button type="button" class="btn btn-primary">등록</button>
      </div>
    </div>
  </div>
</div>
</div>

<script>
  $('#cate1').change(function(){
    //let cate = event.val();(event를 물고 왔을때)
    makeOption($(this),2, '중분류', $('#cate2'));
  });
  $('#cate2').change(function(){
    //let cate = event.val();(event를 물고 왔을때)
    makeOption($(this),3, '소분류', $('#cate3'));
  });

  async function makeOption(e,step,category,target){
    let cate = e.val();

    let data = new URLSearchParams({
      cate:cate,
      step:step,
      category:category
    });
    try{
      const response = await fetch('printOption.php',{
        method:'post',
        headers: {//전송되는 데이터의 타입
        'Content-Type': 'application/x-www-form-urlencoded'
        },
        body:data,

      });
      if(!response.ok){//연결의 에러가 있다면
        throw new Error('연결에러');
      }
      const result = await response.text();//응답의 결과물
      target.html(result);

    }catch(error){
      console.log(error);
    }
   
  }




  /* j쿼리 방식
  function makeOption(e, step, category, target){
    let cate = e.val();
    //console.log(cate, step, category, target); ce.fn.init {0: select#cate2.form-select, length: 1}

    let data = {
      cate:cate,
      step:step,
      category:category
    }
    //console.log(data) {cate: 'A0001', step: 2, category: '중분류'} 이런식

    
    $.ajax({
      async:false,    //printOption.php의 결과(result)가 있을때 이후 수행. true면 이후가 있떤없던 실행!
      type: 'post',
      data : data,  //던져줄 구체적인 데이터
      dataType : 'html',  //서버로부터 반환되는 데이터 형식
      url: "printOption.php", //어디로 넘길것인가

      //그리고 성공(실패)하면 할일
      success: function(result){
        target.html(result);
        },
      error: function(error){
        console.log(error);
        //오류처리
        if(error.status == '404'){
          alert('해당 페이지가 없습니다.');
          location.href = '404.php';
          }
        }
      }
    );
    
  } */

  //modal-content의 섭밋이벤트가 일어나면 할일
  $('.modal-content').submit(function(e){
    e.preventDefault();  
    let step = $(this).attr('data-step');
    let code = $(`#code${step}`).val();
    let name = $(`#name${step}`).val();
    // console.log(step, code, name);

    category_save(step, code, name);
  });

  function category_save(step, code, name){
    console.log(step, code, name);

    //save_category.php
    let data = {
      name:name,
      code:code,
      step:step
    }
    
    $.ajax({
      async:false,    //printOption.php의 결과(result)가 있을때 이후 수행. true면 이후가 있떤없던 실행!
      type: 'post',
      data : data,  //던져줄 구체적인 데이터
      dataType : 'json',  //서버로부터 반환되는 데이터 형식.요기선 성공시{result:1}, 실패시{result:0}, 실패시{result: -1} <-코드,분류명이 중복되면.
      url: "save_category.php", //어디로 넘길것인가. 여기선 페이지 이동을 시키지 않음.

      //그리고 성공(실패)하면 할일
      success: function(returned_data){
        console.log(returned_data);
        
        if(returned_data.result == 1){
          alert('등록완료');
          location.reload();  //새로고침
        } else if(returned_data.result == -1){
          alert('코드명 또는 분류명이 이미 사용중입니다.');
          location.reload();
        } else{
          alert('등록을 실패했습니다.');
          location.reload();

        }
      },
      error: function(error){
        console.log(error);
        
        }
      }
    );
  }

</script>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ABCMALL/admin/inc/footer.php');
?>