<?php
$title = "상품등록";
$summernote_css = "<link href=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css\" rel=\"stylesheet\">";
$summernote_js = "<script src=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js\"></script>";

include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href='../login.php';
    </script>
  ";
};

//대분류 조회
$sql = "SELECT * FROM category WHERE step = 1";
$result = $mysqli->query($sql) or die('query error :'.$mysqli->error);
while($data = $result->fetch_object()){ //조회된 값들 마다 할일, 값이 있으면 $data할당
  $cate1[]= $data; //$cate1배열에 $data할당
}
$mysqli->close();
?>

<div class="container">
  <h1>상품등록</h1>
  <form action="product_ok.php" id="product_save" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="product_image" id="product_image_id" value="">
    <input type="hidden" name="contents" id="contents" value="" required>
    <table class="table">
      <tbody>
        <tr>
          <th scope="row">카테고리 선택</th>
          <td>
            <div class="row">
              <div class="col-md-4">
                <select class="form-select" name= "cate1" id="cate1" aria-label="대분류 선택" required>
                  <option selected >대분류 선택</option>
                  <?php
                    foreach($cate1 as $c1){
                  ?>
                  <option value="<?= $c1->code;?>"><?= $c1->name;?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <select class="form-select" name= "cate2" id="cate2" aria-label="Default select example">
                  <option selected value="">대분류를 먼저 선택하세요</option>
                </select>
              </div>
              <div class="col-md-4">
                <select class="form-select" name= "cate3" id="cate3" aria-label="Default select example">
                  <option selected value="">중분류를 먼저 선택하세요</option>
                </select>
              </div>
            </div>
          </td>       
        </tr>
        <tr>
          <th scope="row">제품명</th>
          <td><input type="text" class="form-control" name="name" required></td>       
        </tr>
        <tr>
          <th scope="row">배송비</th>
          <td><input type="text" class="form-control w-25" name="delivery_fee"></td>       
        </tr>
        <tr>
          <th scope="row">제품가격</th>
          <td><input type="text" class="form-control w-25" name="price" required></td>       
        </tr>
        <tr>
          <th scope="row">세일가격</th>
          <td><input type="text" class="form-control w-25" name="sale_price"></td>       
        </tr>
        <tr>
          <th scope="row">세일비율</th>
          <td><input type="text" class="form-control w-25" name="sale_ratio"></td>       
        </tr>
        <tr>
          <th scope="row">전시옵션</th>
          <td>
            <label class="form-check-label" for="ismain">메인</label>
            <input class="form-check-input" type="checkbox" value="1" name="ismain" id="ismain">
            
            <label class="form-check-label" for="isnew">신제품</label>
            <input class="form-check-input" type="checkbox" value="1" name="isnew" id="isnew">
            
            <label class="form-check-label" for="isbest">베스트</label>
            <input class="form-check-input" type="checkbox" value="1" name="isbest" id="isbest">
            
            <label class="form-check-label" for="isrecom">추천</label>
            <input class="form-check-input" type="checkbox" value="1" name="isrecom" id="isrecom">
          </td>       
        </tr>
        <tr>
          <th scope="row">위치지정</th>
          <td>          
            <select class="form-select w-25" name="locate" aria-label="상품 노출 위치 지정">
              <option selected>위치지정</option>
              <option value="0">지정안함</option>
              <option value="1">1번 위치</option>
              <option value="2">2번 위치</option>
            </select>
          </td>       
        </tr>  
        <tr>
          <th scope="row">판매종료일</th>
          <td>
            <input type="text" name="sale_end_date" id="datepicker" class="form-control w-25">
          </td>       
        </tr>          
        <tr>
          <th scope="row">상세설명</th>
          <td>
            <div id="content"></div>
          </td>       
        </tr>          
        <tr>
          <th scope="row">썸네일</th>
          <td>
            <input type="file" accept="image/*" class="form-control w-50" name="thumbnail" required>
          </td>       
        </tr>          
        <tr>
          <th scope="row">추가이미지</th>
          <td>
            <input type="file" multiple accept="image/*" name="upfile[]" id="upfile" class="visually-hidden">
            <button type="button" class="btn btn-primary btn-sm" id="addImage">이미지 추가</button>
            <div id="addedImages" class="d-flex gap-3"></div>
          </td>       
        </tr>          
        
      </tbody>
    </table>
    <button class="btn btn-primary">상품등록</button>
  </form>

</div>

<script>
  $('#addImage').click(function(){
    $('#upfile').trigger('click');
  });

  $('#upfile').change(function(){
    let files = $(this).prop('files');
    console.log(files);

    for(let i = 0; i<files.length; i++){
      attachFile(files[i]);
    }

  });

  function attachFile(file){

    let formData = new FormData(); //페이지전환 없이, 폼전송없이(submit 이벤트 없이) 파일 전송, 빈폼을 생성
    formData.append('savefile',file); //<input type="file" name="savefile" value="file"> 이미지 첨부


    $.ajax({
      url:'product_image_save.php',
      data:formData,
      cache: false, //이미지 정보를 브라우저 저장, 안한다
      contentType:false, //전송되는 데이터 타입지정, 안한다.
      processData:false, //전송되는 데이터 처리(해석), 안한다.
      dataType:'json', //product_image_save.php이 반환하는 값의 타입
      type:'POST', //파일 정보를 전달하는 방법
      success:function(returned_data){ //product_image_save.php과 연결(성공)되면 할일
        // console.log(returned_data);

        if(returned_data.result === 'size'){
          alert('10MB 이하만 첨부할 수 있습니다.');
          return;
        } else if(returned_data.result === 'image'){
          alert('이미지만 첨부할 수 있습니다.');
          return;   
        } else if(returned_data.result === 'error'){
          alert('첨부실패, 관리자에게 문의하세요');
          return;
        } else{ //파일 첨부가 성공하면
          let imgids = $('#product_image_id').val() + returned_data.imgid+',';
          $('#product_image_id').val(imgids);
          let html = `
            <div class="card" style="width: 9rem;" id="${returned_data.imgid}">
              <img src="../upload/${returned_data.savefile}" class="card-img-top" alt="...">
              <div class="card-body">                
                <button type="button" class="btn btn-danger btn-sm">삭제</button>
              </div>
            </div>
          `;
          $('#addedImages').append(html);
        }
      }

      
    });
  } //Attachfile
  //$('#addedImages button').click(function) -> 요약문. 버튼이 없는 시점에서는 사용 불가(추후 추가한 이미지가 비동기 방식이라 찾지 못함)
  //변수.addEventListener('이벤트종류', '대상', funchtion(){})

  $('#addedImages').on('click', 'button', function(){ // -> 클릭 후 'button'을 찾으라고 해서 가능함. 
    let imgid = $(this).closest('.card').attr('id');
    file_delete(imgid);
     console.log(imgid);
  });

  function file_delete(imgid){
    // if(confirm('정말 삭제할까요?' === false)){
      console.log('Deleting image ID:', imgid);
    if(!confirm('정말 삭제할까요?')){ //조건이 false일 때
      return false; //거짓 반환, 종료
    }

    let data = {
      imgid:imgid
    }
    $.ajax({
      async:false, //동기방식, image_delete.php의 결과를 받으면 진행
      url:'image_delete.php',
      data : data, //삭제할 번호 data 객체를 전달
      type: 'post', //data를 전달할 방식
      dataType : 'json', //json형식 이용해서, 객체로 받겠다.
      error : function(){
        //연결실패시 할일
        console.log('error')
      },
      success:function(returned_data){
        console.log(returned_data)
        //연결성공시 할일, image_delete.php가 echo로 출력해준 값을 매개변수 returened_data로 받는다.
        if(returned_data.result == 'mine'){
          alert('본인이 작성한 제품의 이미지만 삭제할 수 있습니다.')
          return;
        } else if(returned_data.result == 'error'){
          alert('삭제 실패!')
          return;
        } else {
          $('#'+imgid).remove(); //요소(tag)를 삭제
        }
      }
    })
  }

  

  $('#cate1').change(function(){    
    makeOption($(this), 2, '중분류', $('#cate2'));
  });

  $('#cate2').change(function(){    
    makeOption($(this), 3, '소분류', $('#cate3'));
  });

  $('#pcode3').change(function(){    
    makeOption($(this), 2, '중분류', $('#pcode4'));
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
        headers: { //전송되는 데이터의 타입
          'Content-Type': 'application/x-www-form-urlencoded' 
        },
        body:data
      });
      if(!response.ok){ //연결에러가 있다면
        throw new Error('연결에러');
      }
      const result = await response.text(); //응답의 결과를
      target.html(result);

    } catch(error){
      console.log(error);
    }
  }


  $( "#datepicker" ).datepicker({
    dateFormat: "yy-mm-dd"
  });

  let target = $('#content');
  target.summernote({
    height:300,
    toolbar: [
      // [groupName, [list of button]]
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']]
    ]
  });
  
  $('#product_save').on('submit', save);

  function save(){
    var markup = target.summernote('code');
    let content = encodeURIComponent(markup);
    $('#contents').val(content);
  };



</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>