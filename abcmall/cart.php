<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/inc/header.php');

if(isset($_SESSION['UID'])){
    $userid = $_SESSION['UID'];
} else {
    $userid =  '';
}


//카트 조회
$cart_sql = "SELECT c.*, p.thumbnail, p.name, p.pid
    FROM cart c 
    JOIN products p 
    ON c.pid=p.pid
    WHERE c.ssid = '$session_id' or c.userid = '$userid'";

$cart_result = $mysqli->query($cart_sql);

$cartArr = [];
while($cart_data = $cart_result->fetch_object()){
    $cartArr[] = $cart_data;
}
//사용 가능 쿠폰 조회
$uc_sql = "SELECT uc.ucid, c.coupon_name, c.coupon_price FROM user_coupons uc
    JOIN coupons c
    ON c.cid = uc.couponid
    WHERE c.status = 2 
    and uc.status = 1 
    and uc.userid = '$userid' 
    and uc.use_max_date >=now() ";

$uc_result = $mysqli->query($uc_sql);

$ucArr = [];
while($uc_data = $uc_result->fetch_object()){
    $ucArr[] = $uc_data;
}

?>

        <!-- ****** Cart Area Start ****** -->
        <div class="cart_area section_padding_100 clearfix">
            <form action="checkout.php" method="post" class="container">
                <input type="hidden" name="ucid" value="" id="ucid">
                <input type="hidden" name="grandtotal" value="" id="grandtotal">
                <div class="row">
                    <div class="col-12">
                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total = 0;
                                        if(isset($cartArr)){
                                            foreach($cartArr as $cart){
                                                $total += $cart->price;                                    
                                    ?>
                                    <tr>                                        
                                        <td class="cart_product_img d-flex align-items-center">
                                            <input type="hidden" name="pid[]" value="<?= $cart->pid;?>">
                                            <input type="hidden" name="cart_name[]" value="<?= $cart->name;?>">
                                            <input type="hidden" name="cart_cnt[]" value="<?= $cart->cnt;?>" class="cart_cnt">
                                            <input type="hidden" name="cart_total[]" value="" class="cart_subtotal">
                                            <a href="#"><img src="<?= $cart->thumbnail;?>" alt="Product"></a>
                                            <h6><?= $cart->name;?></h6>
                                        </td>
                                        <td class="price"><span class="number" data-price="<?= $cart->price;?>"><?= $cart->price;?></span></td>
                                        <td class="qty">
                                            <div class="quantity">
                                                <span class="qty-minus"
                                                    onclick="var effect = document.getElementById('qty_<?= $cart->cartid;?>'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i
                                                        class="fa fa-minus" aria-hidden="true"></i></span>
                                                <input type="number" class="qty-text" id="qty_<?= $cart->cartid;?>" step="1" min="1" max="99"
                                                    name="quantity" value="<?= $cart->cnt;?>">
                                                <span class="qty-plus"
                                                    onclick="var effect = document.getElementById('qty_<?= $cart->cartid;?>'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span>
                                            </div>
                                        </td>
                                        <td class="total_price">
                                            <span class="number">0</span>
                                            <button type="button" class="cart_item_del" id="<?= $cart->cartid;?>"> x </button>
                                        </td>
                                    </tr>
                                    <?php          
                                            }
                                        }
                                    ?>                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-footer d-flex mt-30">
                            <div class="back-to-shop w-50">
                                <a href="shop-grid-left-sidebar.html">Continue shooping</a>
                            </div>
                            <div class="update-checkout w-50 text-right">
                                <a href="#">clear cart</a>
                                <a href="#">Update cart</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="coupon-code-area mt-70">
                            <div class="cart-page-heading">
                                <h5>Coupon Apply</h5>
                                <p>사용할 쿠폰을 선택해주세요</p>
                            </div>
                            <select name="" id="coupon-select">
                                <option value="0" selected>쿠폰 선택</option>
                                <?php
                                    if(isset($ucArr)){
                                        foreach($ucArr as $ua){
                                ?>
                                <option value="<?= $ua->ucid; ?>" data-price="<?= $ua->coupon_price; ?>"><?= $ua->coupon_name; ?></option>
                                <?php
                                        }
                                    }
                                ?>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="shipping-method-area mt-70">
                            <div class="cart-page-heading">
                                <h5>Shipping method</h5>
                                <p>Select the one you want</p>
                            </div>

                            <div class="custom-control custom-radio mb-30">
                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label d-flex align-items-center justify-content-between"
                                    for="customRadio1"><span>Next day delivery</span><span>$4.99</span></label>
                            </div>

                            <div class="custom-control custom-radio mb-30">
                                <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label d-flex align-items-center justify-content-between"
                                    for="customRadio2"><span>Standard delivery</span><span>$1.99</span></label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label d-flex align-items-center justify-content-between"
                                    for="customRadio3"><span>Personal Pickup</span><span>Free</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="cart-total-area mt-70">
                            <div class="cart-page-heading">
                                <h5>Cart total</h5>
                                <p>Final info</p>
                            </div>

                            <ul class="cart-total-chart">
                                <li><span>Subtotal</span> <span class="number" id="sub-total">0</span></li>
                                <li><span>Discount</span> <span id="discount" class="number" data-price="0">0</span></li>
                                <li><span><strong>Total</strong></span> <span><strong class="number" id="grand-total">0</strong></span></li>
                            </ul>
                            <button class="btn karl-checkout-btn">Proceed to checkout</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- ****** Cart Area End ****** -->
    <script>
        function cart_calc(){
            console.log('실행');
            let sub_total = 0;
            $('.cart-table tbody tr').each(function(){
                console.log($(this));

                let cart_item_price = Number($(this).find('.price .number').attr('data-price'));
                let cart_qty = $(this).find('.qty-text').val();
                $(this).find('.cart_cnt').val(cart_qty);

                let cart_total = cart_item_price*cart_qty;
                $(this).find('.cart_subtotal').val(cart_total);

                let cart_total_target = $(this).find('.total_price .number');
                cart_total_target.text(cart_total);
                sub_total += cart_total;
            });
            $('#sub-total').text(sub_total);
            let discount = Number($('#discount').attr('data-price'));
            $('#grand-total').text(sub_total - discount);
            $('#grandtotal').val(sub_total - discount);
            $('.number').number( true );
        }
        cart_calc();
        $('.quantity span').click(cart_calc);

        $('#coupon-select').change(function(){
            let ucid = $(this).val();
            let ucprice = $(this).find('option:selected').attr('data-price');
            console.log(ucprice);

            $('#discount').text(ucprice);
            $('#ucid').val(ucid);

            $('#discount').attr('data-price', ucprice);
            cart_calc();
        })

        $('.cart-table .cart_item_del').click(function(){
            let cartId = $(this).attr('id');

            if(confirm('정말 삭제할까요?')){
                let data = {
                    cartid : cartId
                }
                $.ajax({
                    url:'cart_delete.php',
                    async:false, //결과가 나오면 일해, 동기 방식
                    data:data,
                    method:'post',
                    dataType:'json', //javascript 객체 형식으로 받자
                    error:function(e){
                        console.log(e);
                    },
                    success:function(data){
                        if(data.result == 'ok'){
                            alert('장바구니에서 삭제했습니다.');
                            location.reload();
                        }else{
                            alert('삭제 실패!');
                        }
                    }

                })
            } else {
                alert('삭제를 취소했습니다.');
            }

        });


    </script>
<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/inc/footer.php');
?>