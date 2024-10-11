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