<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/inc/header.php');

if(isset($_SESSION['UID'])){
    $userid = $_SESSION['UID'];
} else {
    $userid =  '';
}

if(isset($_POST['ucid']) && $_POST['ucid']>0){
    $ucid = $_POST['ucid'];
} else{
    $ucid = 0;
}

$pid = $_POST['pid'] ?? [];
$cart_name = $_POST['cart_name'] ?? [];
$cart_cnt = $_POST['cart_cnt'] ?? [];
$cart_total = $_POST['cart_total'] ?? [];
$grandtotal = $_POST['grandtotal'] ?? 0;

$pidArr = json_encode($pid);
$cartnameArr = json_encode($cart_name);
$cartcntArr = json_encode($cart_cnt);
$carttotalArr = json_encode($cart_total);

$cart_items = []; // 새로운 배열 생성

for ($i = 0; $i < sizeof($cart_name); $i++) {
    // 각 항목을 $cart_items 배열에 추가
    $cart_items[$i] = [
        "pid" => $pid[$i],
        "name" => $cart_name[$i],
        "cnt" => $cart_cnt[$i],
        "subtotal" => $cart_total[$i]
    ];
}

?>

        <!-- ****** Checkout Area Start ****** -->
        <div class="checkout_area section_padding_100">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="checkout_details_area mt-50 clearfix">

                            <div class="cart-page-heading">
                                <h5>Billing Address</h5>
                                <p>Enter your cupone code</p>
                            </div>

                            <form action="#" method="post">
                                <div class="row">

                                    <input type="text" id="sample4_postcode" placeholder="우편번호">
                                    <input type="button" onclick="sample4_execDaumPostcode()" value="우편번호 찾기"><br>
                                    <input type="text" id="sample4_roadAddress" placeholder="도로명주소">
                                    <input type="text" id="sample4_jibunAddress" placeholder="지번주소">
                                    <span id="guide" style="color:#999;display:none"></span>
                                    <input type="text" id="sample4_detailAddress" placeholder="상세주소">
                                    <input type="text" id="sample4_extraAddress" placeholder="참고항목">

                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                        <div class="order-details-confirmation">

                            <div class="cart-page-heading">
                                <h5>Your Order</h5>
                                <p>The Details</p>
                            </div>

                            <ul class="order-details-form mb-4">
                                <li><span>Product</span> <span>Total</span></li>
                                <li class="order-items">
                                    <?php
                                        foreach($cart_items as $cart_item){                                        
                                    ?>
                                    <div>
                                        <span><?= $cart_item['name'];?></span>
                                        X <?= $cart_item['cnt'];?>개</span> = 
                                        <span class="number"><?= $cart_item['subtotal'];?></span>
                                    </div>
                                    <?php      
                                        }
                                    ?>
                                    
                                </li>
                                <li><span>Subtotal</span> <span><?= $grandtotal;?></span></li>
                                <li><span>Shipping</span> <span>Free</span></li>
                                <li><span>Total</span> <span><?= $grandtotal;?></span></li>
                            </ul>


                            <div id="accordion" role="tablist" class="mb-4">
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h6 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><i class="fa fa-circle-o mr-3"></i>Paypal</a>
                                        </h6>
                                    </div>

                                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integ er bibendum sodales arcu id te mpus. Ut consectetur lacus.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-circle-o mr-3"></i>cash on delievery</a>
                                        </h6>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quis in veritatis officia inventore, tempore provident dignissimos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingThree">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="fa fa-circle-o mr-3"></i>credit card</a>
                                        </h6>
                                    </div>
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse quo sint repudiandae suscipit ab soluta delectus voluptate, vero vitae</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingFour">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"><i class="fa fa-circle-o mr-3"></i>direct bank transfer</a>
                                        </h6>
                                    </div>
                                    <div id="collapseFour" class="collapse show" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est cum autem eveniet saepe fugit, impedit magni.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="#" class="btn karl-checkout-btn">Place Order</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ****** Checkout Area End ****** -->
<script>
    $('.karl-checkout-btn').click(function(e){
        e.preventDefault();
        if(confirm('주문하시겠습니까?')){
            let userid = '<?=$userid;?>';
            let pid = <?= $pidArr; ?> 
            let count = <?= $cartcntArr; ?> 
            let subtotal = <?= $carttotalArr; ?> 
            let address = $('#sample4_roadAddress').val();
            let ucid = <?= $ucid;?>

            let data = {
                ucid: ucid,
                userid:userid,
                pid:pid,
                count:count,
                subtotal:subtotal,
                address:address
            }
            console.log(data);

            $.ajax({
                async:false,
                url:'place_order.php',
                type:'post',
                data:data,
                dataType:'json',
                error:function(e){
                    console.log(e);
                },
                success:function(data){
                    console.log(data);
                    if(data.result == 'ok'){
                        alert('주문 완료');
                        location.href = 'index.php';
                    } else{
                        alert('주문 실패');
                        location.reload();
                    }
                }
            })
                
        } else{
            alert('주문이 취소 되었습니다.');
            location.href = 'index.php';
        }
    })
</script>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
    function sample4_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('sample4_postcode').value = data.zonecode;
                document.getElementById("sample4_roadAddress").value = roadAddr;
                document.getElementById("sample4_jibunAddress").value = data.jibunAddress;
                
                // 참고항목 문자열이 있을 경우 해당 필드에 넣는다.
                if(roadAddr !== ''){
                    document.getElementById("sample4_extraAddress").value = extraRoadAddr;
                } else {
                    document.getElementById("sample4_extraAddress").value = '';
                }

                var guideTextBox = document.getElementById("guide");
                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    guideTextBox.innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                    guideTextBox.style.display = 'block';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    guideTextBox.innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                    guideTextBox.style.display = 'block';
                } else {
                    guideTextBox.innerHTML = '';
                    guideTextBox.style.display = 'none';
                }
            }
        }).open();
    }
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/inc/footer.php');
?>
 