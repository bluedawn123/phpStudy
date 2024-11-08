<?php
$title = "상품등록";
$summernote_css = "<link href=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css\" rel=\"stylesheet\">";
$summernote_js = "<script src=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js\"></script>";
$additional_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/abcmall/admin/css/drag_drop.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/header.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/category_func.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}


$mysqli->close();

?>

<div class="container">
  <h1>상품등록</h1>
  <form action="product_ok.php" id="product_save" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="product_image" id="product_image_id" value="">
    <input type="hidden" name="contents" id="contents" value="">
    <table class="table">
      <tbody>
        <tr>
          <th scope="row">카테고리 선택</th>
          <td>
            <div class="row">
              <div class="col-md-4">
                <select class="form-select" id="cate1" name="cate1" aria-label="대분류 선택" required>
                  <option selected>대분류 선택</option>
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
                <select class="form-select" id="cate2" name="cate2" aria-label="Default select example">
                  <option selected value="">대분류를 먼저 선택하세요</option>
                </select>
              </div>
              <div class="col-md-4">
                <select class="form-select" id="cate3" name="cate3" aria-label="Default select example">
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
          <td><input type="text" class="form-control w-25" name="delivery_fee" value="0" required></td>       
        </tr>
        <tr>
          <th scope="row">제품가격</th>
          <td><input type="text" class="form-control w-25" name="price" required  value="0" required></td>       
        </tr>
        <tr>
          <th scope="row">세일가격</th>
          <td><input type="text" class="form-control w-25" name="sale_price" value="0" required> </td>       
        </tr>
        <tr>
          <th scope="row">세일비율</th>
          <td><input type="text" class="form-control w-25" name="sale_ratio"  value="0" required></td>       
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
              <option value="0" selected>지정안함</option>
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
            <div id="drop" class="box">
              <span>여기로 드래그 앤 드롭하세요</span>
              <div id="addedImages" class="d-flex gap-3"></div>
            </div>
          </td>       
        </tr>               
        <!--
        <tr>
          <th scope="row">추가이미지</th>
          <td>
            <input type="file" multiple accept="image/*" name="upfile[]" id="upfile" class="visually-hidden">
            <button type="button" class="btn btn-primary btn-sm" id="addImage">이미지 추가</button>
            <div id="addedImages" class="d-flex gap-3"></div>
          </td>       
        </tr>          
        -->
        <tr>
          <th scope="row">
            <select class="form-select" name="option_cate1" aria-label="옵션명 선택">              
              <option value="" selected>옵션</option>
              <option value="컬러">컬러</option>
              <option value="사이즈">사이즈</option>
            </select>
          </th>
          <td>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">옵션명</th>
                  <th scope="col">가격</th>
                  <th scope="col">이미지</th>
                </tr>
              </thead>
              <tbody id="option1">
                <tr id="optionTr1">
                  <td>
                    <input type="text" class="form-control" name="optionName1[]">
                  </td>
                  <td>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" value="0" placeholder="0" aria-label="옵션 가격" aria-describedby="basic-addon2" name="optionPrice1[]">
                      <span class="input-group-text" id="basic-addon2">원</span>
                    </div>
                  </td>
                  <td>
                    <div class="input-group mb-3">                     
                      <input type="file" class="form-control" id="optionImage1"  name="optionImage1[]">
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <button class="btn btn-secondary btn-sm optAddBtn" type="button">옵션추가</button>
          </td>       
        </tr>  <!-- //컬러 옵션 추가 -->
        <tr>
          <th scope="row">
            <select class="form-select" name="option_cate2" aria-label="옵션명 선택">              
              <option value="" selected>옵션</option>
              <option value="컬러">컬러</option>
              <option value="사이즈">사이즈</option>
            </select>
          </th>
          <td>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">옵션명</th>
                  <th scope="col">가격</th>
                  <th scope="col">이미지</th>
                </tr>
              </thead>
              <tbody id="option2">
                <tr id="optionTr2">
                  <td>
                    <input type="text" class="form-control" name="optionName2[]">
                  </td>
                  <td>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control"  value="0" placeholder="0" aria-label="옵션 가격" aria-describedby="basic-addon2" name="optionPrice2[]">
                      <span class="input-group-text" id="basic-addon2">원</span>
                    </div>
                  </td>
                  <td>
                    <div class="input-group mb-3">                     
                      <input type="file" class="form-control" id="optionImage2"  name="optionImage2[]">
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <button class="btn btn-secondary btn-sm optAddBtn" type="button">옵션추가</button>
          </td>       
        </tr>  <!-- //사이즈 옵션 추가 -->
      </tbody>
    </table>
    <button class="btn btn-primary">상품등록</button>
  </form>
</div>
<script src="http://<?= $_SERVER['HTTP_HOST']?>/abcmall/admin/js/category_option.js"></script>
<script>


  /*
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
  */
  $('#drop').on('dragenter',function(){
      $(this).addClass('drag-enter');
    }).on('dragleave',function(){
      $(this).removeClass('drag-enter');
    }).on('dragover',function(e){
      e.preventDefault();
      e.stopPropagation();
    }).on('drop', function(e){
      e.preventDefault();      
      $(this).removeClass('drag-enter');
      let files = e.originalEvent.dataTransfer.files;
      //console.log(files);
      for(let i = 0; i < files.length; i++){
        let file = files[i];
        attachFile(file);
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
        console.log(returned_data);

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
          let imgids = $('#product_image_id').val() + returned_data.imgid + ',';
          $('#product_image_id').val(imgids);
          let html = `
            <div class="card" style="width: 9rem;" id="${returned_data.imgid}">
              <img src="${returned_data.savefile}" class="card-img-top" alt="...">
              <div class="card-body">                
                <button type="button" class="btn btn-danger btn-sm">삭제</button>
              </div>
            </div>
          `;
          $('#addedImages').append(html);
        }
      }

    })
  } //Attachfile
  //$('#addedImages button');
  //변수.addEventListener('이벤트종류','대상',function(){})

  $('#addedImages').on('click','button', function(){
    let imgid = $(this).closest('.card').attr('id');
    //console.log(imgid);
    file_delete(imgid);
  });


  function file_delete(imgid){

    if(!confirm('정말 삭제할까요?')){      //조건이 false일때
      return false;//거짓 반환,종료      
    }

    let data = {
      imgid:imgid
    }
    $.ajax({
      async:false, //동기방식, image_delete.php의 결과를 받으면 진행      
      url:'image_delete.php',
      data:data, //삭제할 번호 data 객체를 전달
      type:'post', //data를 전달할 방식
      dataType:'json', //json형식이용해서, 객체로 받겠다.
      error:function(){
        //연결실패시 할일
      },
      success:function(returned_data){
        //연결성공시 할일, image_delete.php가 echo 출력해준 값을 매배견수 returend_data 받자
        if(returned_data.result == 'mine'){
          alert('본인이 작성한 제품의 이미지만 삭제할 수 있습니다.');
          return;
        } else if(returned_data.result == 'error'){
          alert('삭제 실패!');
          return;
        } else {
          $('#'+imgid).remove(); //요소(tag)를 삭제
        }
      }

    })

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



  $('.optAddBtn').click(function(){
    let optionTbody = $(this).parent().find('tbody');
    let optionTr = optionTbody.find('tr');

    let addHtml = optionTr.html();
      addHtml = `<tr>${addHtml}</tr>`;
    optionTbody.append(addHtml);
  });



  $('#product_save').submit(function(e){

    if (target.summernote('isEmpty')) {
      e.preventDefault();
      alert('상품 설명을 작성해주세요');
      target.summernote('focus');      
    }

    var markup = target.summernote('code');
    let content = encodeURIComponent(markup);
    $('#contents').val(markup);
  });

</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/footer.php');
?>
