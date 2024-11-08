<?php
ob_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/inc/header.php');

$pid = $_GET['pid'];
if (!isset($pid)) {
  echo "<script>alert('상품정보가 없습니다.'); 
  location.href = 'shop.php';</script>";
}

$sql = "SELECT * FROM products WHERE pid = $pid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

$cate = $data->cate ; //A0001B0001C0001
$cate1 = substr($cate, 0, 5); // A0001
$cate2 = substr($cate, 5, 5); // B0001
$cate3 = substr($cate, 10, 5); // C0001

$cate_sql = "SELECT name,code FROM category WHERE code IN ('$cate1', '$cate2', '$cate3')";
$result = $mysqli->query($cate_sql);

// 카테고리 이름 배열에 저장
$category_infos = [];
while ($row = $result->fetch_object()) {
    $category_infos[] = $row;
}

$rvArr = [];

if(isset($_COOKIE['recent_viewed'])){
    $rvArr = json_decode($_COOKIE['recent_viewed']); //기존 쿠키값을 조회 변수 할당, //문자열-> 배열
    if(!in_array($pid, $rvArr)){ //이미 본 상품이 아니라면, 새상품을 열었다면
        
       if(sizeof($rvArr)>=3){ //이미 값이 3개이면
        array_shift($rvArr);
       }
        
        array_push($rvArr, $pid);// [42,20]
        $rvStr = json_encode($rvArr);//[42,20] -> ["42","20"];
        setcookie('recent_viewed', $rvStr, time()+86400, "/");  
    }   
} else{
    array_push($rvArr, $pid);// [42]
    $rvStr = json_encode($rvArr);//배열-> 문자열 [42] -> ["42"];
    setcookie('recent_viewed', $rvStr, time()+86400, "/");  
}

//추가 이미지 조회
$addimg_sql = "SELECT filename FROM product_image_table WHERE pid = $pid";
$addimg_result = $mysqli->query($addimg_sql);

$addImages = [];

while($addimg_data = $addimg_result->fetch_object()){
  $addImages[] = $addimg_data;
}

// 옵션 조회 함수
function getOptions($mysqli, $pid, $cate) {
  $otp_sql = "SELECT * FROM product_options WHERE pid = $pid and cate = '$cate'";
  $otp_result = $mysqli->query($otp_sql);

  $options = [];
  while ($otp_data = $otp_result->fetch_object()) {
      $options[] = $otp_data;
  }
  return $options;
}

// 옵션1 조회 (컬러)
$options1 = getOptions($mysqli, $pid, '컬러');

// 옵션2 조회 (사이즈)
$options2 = getOptions($mysqli, $pid, '사이즈');



?>

        <!-- <<<<<<<<<<<<<<<<<<<< Breadcumb Area Start <<<<<<<<<<<<<<<<<<<< -->
        <div class="breadcumb_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ol class="breadcrumb d-flex align-items-center">
                            <?php                            
                                foreach($category_infos as $info){                                
                            ?>
                            <li class="breadcrumb-item"><a href="shop.php?cate_code=<?= $info->code;?>"><?= $info->name;?></a></li>
                            <?php
                                }
                            ?>
                        </ol>
                        <!-- btn -->
                        <a href="#" class="backToHome d-block"><i class="fa fa-angle-double-left"></i> Back to Category</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <<<<<<<<<<<<<<<<<<<< Breadcumb Area End <<<<<<<<<<<<<<<<<<<< -->

        <!-- <<<<<<<<<<<<<<<<<<<< Single Product Details Area Start >>>>>>>>>>>>>>>>>>>>>>>>> -->
        <section class="single_product_details_area section_padding_0_100">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">

                                <ol class="carousel-indicators">
                                    <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(<?=$data->thumbnail; ?>);">
                                    </li>
                                    <?php 
                                        if(isset($addImages)){
                                            $i = 1;
                                            foreach($addImages as $ai){         
                                    ?> 
                                    
                                    <li data-target="#product_details_slider" data-slide-to="<?=$i;?>" style="background-image: url(<?= $ai->filename;?>);">
                                    </li>
                                    <?php 
                                        $i++;
                                            }
                                        }         
                                    ?>                                     
                                </ol>

                                <div class="carousel-inner">

                                    <div class="carousel-item active">
                                        <a class="gallery_img" href="<?=$data->thumbnail; ?>">
                                        <img class="d-block w-100" src="<?=$data->thumbnail; ?>" alt="First slide">
                                        </a>
                                    </div>
                                    <?php 
                                        if(isset($addImages)){
                                           
                                            foreach($addImages as $ai){         
                                    ?> 
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="<?= $ai->filename;?>">
                                        <img class="d-block w-100" src="<?= $ai->filename;?>" alt="First slide">
                                        </a>
                                    </div>
                                    <?php                                         
                                            }
                                        }         
                                    ?> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="single_product_desc">

                            <h4 class="title"><a href="#"><?=$data->name?></a></h4>

                            <h4 class="price"><?=$data->price?></h4>

                            <p class="available">Available: <span class="text-muted">In Stock</span></p>

                            <div class="single_product_ratings mb-15">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </div>
                            <!-- Add to Cart Form -->
                            <form class="cart clearfix mb-50" method="post" id="cartform">
                                
                                <?php 
                                    if(isset($options1) && sizeof($options1) > 0){
                                ?> 
                                <div class="widget size mb-50">
                                    <h6 class="widget-title"><?= $options1[0]->cate; ?></h6>
                                    <div class="widget-desc">                                  
                                        <?php   
                                                     
                                            foreach($options1 as $key => $op){              
                                        ?> 
                                        <ul class="d-flex gap-3 list-unstyled" >
                                        <li class="w-5">
                                            <input 
                                                type="radio" name="option1" 
                                                id="option1_<?= $op->poid;?>" 
                                                value="<?= $op->option_name;?>" 
                                                data-price="<?= $op->option_price ;?>" 
                                                <?php echo $key==0? 'checked':''; ?> 
                                            >
                                        </li>
                                        <li class="w-5">
                                            <label for="option1_<?= $op->poid;?>">
                                                <?= $op->option_name;?>
                                            </label>
                                        </li>
                                        <li class="w-5"><?= $op->option_price ;?></li>
                                        <li class="w-5">
                                            <a href="<?= $op->image_url;?>" target="_blank">
                                            <img src="<?= $op->image_url;?>" alt="" style="width:50px">
                                            </a>
                                        </li>             
                                        </ul>
                                        <?php     
                                            }          
                                        ?>
                                    </div>
                                </div>
                                <?php     
                                    }          
                                ?>
                                <?php 
                                    if(isset($options2) && sizeof($options2) > 0){
                                ?> 
                                <div class="widget size mb-50">
                                    <h6 class="widget-title"><?= $options2[0]->cate; ?></h6>
                                    <div class="widget-desc">                                  
                                        <?php               
                                            foreach($options2 as $op){              
                                        ?> 
                                        <ul class="d-flex gap-3 list-unstyled" >
                                        <li class="w-5">
                                            <input 
                                                type="radio" name="option2" 
                                                id="option2_<?= $op->poid;?>" 
                                                value="<?= $op->option_name;?>" 
                                                data-price="<?= $op->option_price ;?>" 
                                                <?php echo $key==0? 'checked':''; ?> 
                                            >
                                        </li>
                                        <li class="w-5">
                                            <label for="option2_<?= $op->poid;?>">
                                                <?= $op->option_name;?>
                                            </label>
                                        </li>
                                        <li class="w-5"><?= $op->option_price ;?></li>
                                        <li class="w-5">
                                            <a href="<?= $op->image_url;?>" target="_blank">
                                            <img src="<?= $op->image_url;?>" alt="" style="width:50px">
                                            </a>
                                        </li>             
                                        </ul>
                                        <?php     
                                            }          
                                        ?>
                                    </div>
                                </div>
                                <?php     
                                    }          
                                ?>
                                <div>
                                    <div class="quantity">
                                        <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="12" name="quantity" value="1">
                                        <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                    </div>
                                    <button type="submit" name="addtocart" value="5" class="btn cart-submit d-block">Add to cart</button>
                                </div>
                            </form>

                            <div id="accordion" role="tablist">
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h6 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Information</a>
                                        </h6>
                                    </div>

                                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <?=$data->content?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Cart Details</a>
                                        </h6>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quis in veritatis officia inventore, tempore provident dignissimos nemo, nulla quaerat. Quibusdam non, eos, voluptatem reprehenderit hic nam! Laboriosam, sapiente! Praesentium.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia magnam laborum eaque.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingThree">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">shipping &amp; Returns</a>
                                        </h6>
                                    </div>
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse quo sint repudiandae suscipit ab soluta delectus voluptate, vero vitae, tempore maxime rerum iste dolorem mollitia perferendis distinctio. Quibusdam laboriosam rerum distinctio. Repudiandae fugit odit, sequi id!</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae qui maxime consequatur laudantium temporibus ad et. A optio inventore deleniti ipsa.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- <<<<<<<<<<<<<<<<<<<< Single Product Details Area End >>>>>>>>>>>>>>>>>>>>>>>>> -->

        <!-- ****** Quick View Modal Area Start ****** -->
        <div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                    <div class="modal-body">
                        <div class="quickview_body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-5">
                                        <div class="quickview_pro_img">
                                            <img src="img/product-img/product-1.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-7">
                                        <div class="quickview_pro_des">
                                            <h4 class="title">Boutique Silk Dress</h4>
                                            <div class="top_seller_product_rating mb-15">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                            <h5 class="price">$120.99 <span>$130</span></h5>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia expedita quibusdam aspernatur, sapiente consectetur accusantium perspiciatis praesentium eligendi, in fugiat?</p>
                                            <a href="#">View Full Product Details</a>
                                        </div>
                                        <!-- Add to Cart Form -->
                                        <form class="cart" method="post">
                                            <div class="quantity">
                                                <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>

                                                <input type="number" class="qty-text" id="qty2" step="1" min="1" max="12" name="quantity" value="1">

                                                <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                            </div>
                                            <button type="submit" name="addtocart" value="5" class="cart-submit">Add to cart</button>
                                            <!-- Wishlist -->
                                            <div class="modal_pro_wishlist">
                                                <a href="wishlist.html" target="_blank"><i class="ti-heart"></i></a>
                                            </div>
                                            <!-- Compare -->
                                            <div class="modal_pro_compare">
                                                <a href="compare.html" target="_blank"><i class="ti-stats-up"></i></a>
                                            </div>
                                        </form>

                                        <div class="share_wf mt-30">
                                            <p>Share With Friend</p>
                                            <div class="_icon">
                                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                                <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ****** Quick View Modal Area End ****** -->

        <section class="you_may_like_area clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_heading text-center">
                            <h2>related Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="you_make_like_slider owl-carousel">

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-1.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-2.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-3.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-4.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-5.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <script>
        $('#cartform').submit(function(e){
            e.preventDefault();
            let opts =  '';
            let sub_total = Number(<?=$data->price;?>);
            $(".widget input[type='radio']:checked").each(function(){
                opts+= $(this).val();
                let price = Number($(this).attr('data-price'));
                sub_total += price;
            });
            let pid = <?=$pid;?>; 
            let cnt = $('#qty').val();

            let data = {
                pid : pid,
                opts: opts,
                price : sub_total,
                cnt:cnt
            }
            console.log(data);

            $.ajax({
                async:false,
                type:'post',
                url:'cart_insert.php',
                data:data,
                dataType:'json',
                error:function(e){
                    console.log(e)
                },
                success:function(data){
                    if(data.result == '중복'){
                        alert('이미 장바구니에 있습니다.');
                    } else if(data.result == 'ok'){
                        alert('장바구니에 추가되었습니다.');
                    } else{
                        alert('장바구니 담기 실패');
                    }
                }
            })

        });
    </script>

<?php
    ob_end_flush(); //버퍼에 담았던 정보 비우기
    include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/inc/footer.php');
?>