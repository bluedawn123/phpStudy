<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/abcmall/admin/inc/dbcon.php');
$session_id = session_id();

if(isset($_SESSION['UID'])){
    $userid = $_SESSION['UID'];
} else {
    $userid =  '';
}

//최근 본 상품 조회
if(isset($_COOKIE['recent_viewed'])){
    $rvArr = json_decode($_COOKIE['recent_viewed']); //문자->배열 ['42','29','28']->[42,29,28]
    $rvString = implode(",", $rvArr); //배열->하나의 문자열, '42,29,28'
    $sql = "SELECT * FROM products where pid in ($rvString)"; //
    $result = $mysqli->query($sql);

    $rvp = [];
    while($data = $result->fetch_object()){
        $rvp[] = $data;
    }
}
//카트 조회
$cart_sql = "SELECT c.*, p.thumbnail, p.name
    FROM cart c 
    JOIN products p 
    ON c.pid=p.pid
    WHERE c.ssid = '$session_id' or c.userid = '$userid'";

$cart_result = $mysqli->query($cart_sql);

$cartArr = [];
while($cart_data = $cart_result->fetch_object()){
    $cartArr[] = $cart_data;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Karl - Fashion Ecommerce Template | Home</title>

    <!-- Favicon  -->
    <link rel="icon" href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/css/core-style.css">
    <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/style.css">

    <!-- Responsive CSS -->
    <link href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/css/responsive.css" rel="stylesheet">
    
    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/js/jquery/jquery-2.2.4.min.js"></script>
    <script src="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/js/jquery.number.min.js"></script>
</head>

<body>

    <div class="catagories-side-menu">
        <!-- Close Icon -->
        <div id="sideMenuClose">
            <i class="ti-close"></i>
        </div>
        <!--  Side Nav  -->
        <div class="nav-side-menu">
            <div class="menu-list">
                <h6>Categories</h6>
                <ul id="menu-content" class="menu-content collapse out">
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#women" class="collapsed active">
                        <a href="#">Woman wear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="women">
                            <li><a href="#">Midi Dresses</a></li>
                            <li><a href="#">Maxi Dresses</a></li>
                            <li><a href="#">Prom Dresses</a></li>
                            <li><a href="#">Little Black Dresses</a></li>
                            <li><a href="#">Mini Dresses</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#man" class="collapsed">
                        <a href="#">Man Wear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="man">
                            <li><a href="#">Man Dresses</a></li>
                            <li><a href="#">Man Black Dresses</a></li>
                            <li><a href="#">Man Mini Dresses</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#kids" class="collapsed">
                        <a href="#">Children <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="kids">
                            <li><a href="#">Children Dresses</a></li>
                            <li><a href="#">Mini Dresses</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#bags" class="collapsed">
                        <a href="#">Bags &amp; Purses <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="bags">
                            <li><a href="#">Bags</a></li>
                            <li><a href="#">Purses</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#eyewear" class="collapsed">
                        <a href="#">Eyewear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="eyewear">
                            <li><a href="#">Eyewear Style 1</a></li>
                            <li><a href="#">Eyewear Style 2</a></li>
                            <li><a href="#">Eyewear Style 3</a></li>
                        </ul>
                    </li>
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#footwear" class="collapsed">
                        <a href="#">Footwear <span class="arrow"></span></a>
                        <ul class="sub-menu collapse" id="footwear">
                            <li><a href="#">Footwear 1</a></li>
                            <li><a href="#">Footwear 2</a></li>
                            <li><a href="#">Footwear 3</a></li>
                        </ul>
                    </li>
                </ul>

                <?php 
                    if(isset($_SESSION['UID'])){
                ?>
                <!-- 로그인 후 -->
                <a href="member/logout.php">로그아웃</a>
                <a href="#">마이페이지</a>
                <?php 
                    } else{
                ?>
                <!-- 로그인 전 -->
                <a href="member/login.php">로그인</a>
                <a href="member/signup">회원가입</a>
                <?php
                    }
                ?>




            </div>
        </div>
    </div>

    <div id="wrapper">

        <!-- ****** Header Area Start ****** -->
        <header class="header_area">
            <!-- Top Header Area Start -->
            <div class="top_header_area">
                <div class="container h-100">
                    <div class="row h-100 align-items-center justify-content-end">

                        <div class="col-12 col-lg-12">
                            <div class="top_single_area d-flex align-items-center">
                                <!-- recent view Area -->
                                <div class="header-cart-menu d-flex align-items-center mr-auto">
                                    <!-- Cart Area -->
                                    <div class="recentview">
                                        <a href="#" id="header-recent-btn" target="_blank">
                                            <?php 
                                               if(isset($rvp)){
                                            ?>
                                            <span class="cart_quantity"><?= sizeof($rvp);?></span> 
                                            <?php 
                                                }     
                                            ?>

                                                <i class="ti-bag"></i> recent viewed</a>
                                        <!-- Cart List Area Start -->
                                        <ul class="recent-list">
                                            <?php
                                            if(isset($rvp)){
                                                foreach($rvp as $item){                                                
                                            ?>
                                            <li>
                                                <a href="product-details.php?pid=<?= $item->pid; ?>" class="image"><img src="<?= $item->thumbnail; ?>"
                                                        class="cart-thumb" alt=""></a>
                                                <div class="cart-item-desc">
                                                    <h6><a href="product-details.php?pid=<?= $item->pid; ?>"><?= $item->name; ?></a></h6>
                                                    <h6><?= $item->price; ?></h6>
                                                </div>

                                            </li>
                                            <?php
                                                }
                                            }                                            
                                            ?>

                                        </ul>
                                    </div>

                                </div>
                                <!-- Logo Area -->
                                <div class="top_logo">
                                    <a href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/index.php"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/img/core-img/logo.png" alt=""></a>
                                </div>
                                <!-- Cart & Menu Area -->
                                <div class="header-cart-menu d-flex align-items-center ml-auto">
                                    <!-- Cart Area -->
                                    <div class="cart">
                                        <a href="#" id="header-cart-btn" target="_blank"><span
                                                class="cart_quantity">
                                            <?php echo isset($cartArr)? sizeof($cartArr): 0; ?>
                                            
                                            </span> <i class="ti-bag"></i> Your Bag</a>
                                        <!-- Cart List Area Start -->
                                        <ul class="cart-list">
                                            <?php
                                                $total = 0;
                                                if(isset($cartArr)){
                                                    foreach($cartArr as $cart){
                                                        $total += $cart->price;                                    
                                            ?>
                                            <li>
                                                <a href="#" class="image"><img src="<?= $cart->thumbnail;?>"
                                                        class="cart-thumb" alt=""></a>
                                                <div class="cart-item-desc">
                                                    <h6><a href="#"><?= $cart->name;?></a></h6>
                                                    <p>1x - <span class="price number"><?= $cart->price;?>원</span></p>
                                                </div>
                                                <span class="dropdown-product-remove"><i class="icon-cross"></i></span>
                                            </li>
                                            <?php          
                                                    }
                                                }
                                            ?>
                                            <li class="total">
                                                <span class="pull-right number">Total: <?= $total; ?>원</span>
                                                <a href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/cart.php" class="btn btn-sm btn-cart">Cart</a>
                                                <a href="checkout-1.html" class="btn btn-sm btn-checkout">Checkout</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="header-right-side-menu ml-15">
                                        <a href="#" id="sideMenuBtn"><i class="ti-menu" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Top Header Area End -->
            <div class="main_header_area">
                <div class="container h-100">
                    <div class="row h-100">
                        <div class="col-12 d-md-flex justify-content-between">
                            <!-- Header Social Area -->
                            <div class="header-social-area">
                                <a href="#"><span class="karl-level">Share</span> <i class="fa fa-pinterest"
                                        aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            </div>
                            <!-- Menu Area -->
                            <div class="main-menu-area">
                                <nav class="navbar navbar-expand-lg align-items-start">

                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#karl-navbar" aria-controls="karl-navbar" aria-expanded="false"
                                        aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i
                                                class="ti-menu"></i></span></button>

                                    <div class="collapse navbar-collapse align-items-start collapse" id="karl-navbar">
                                        <ul class="navbar-nav animated" id="nav">
                                            <li class="nav-item active"><a class="nav-link" href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/index.php">Home</a>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="karlDropdown"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">Pages</a>
                                                <div class="dropdown-menu" aria-labelledby="karlDropdown">
                                                    <a class="dropdown-item" href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/index.php">Home</a>
                                                    <a class="dropdown-item" href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/shop.php">Shop</a>                                                    
                                                    <a class="dropdown-item" href="http://<?=$_SERVER['HTTP_HOST'];?>/abcmall/cart.php">Cart</a>
                                                    <a class="dropdown-item" href="checkout.html">Checkout</a>
                                                </div>
                                            </li>
                                            <li class="nav-item"><a class="nav-link" href="#">Dresses</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#"><span
                                                        class="karl-level">hot</span> Shoes</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <!-- Help Line -->
                            <div class="help-line">
                                <a href="tel:+346573556778"><i class="ti-headphone-alt"></i> +34 657 3556 778</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ****** Header Area End ****** -->

        <!-- ****** Top Discount Area Start ****** -->
        <section class="top-discount-area d-md-flex align-items-center">
            <!-- Single Discount Area -->
            <div class="single-discount-area">
                <h5>Free Shipping &amp; Returns</h5>
                <h6><a href="#">BUY NOW</a></h6>
            </div>
            <!-- Single Discount Area -->
            <div class="single-discount-area">
                <h5>20% Discount for all dresses</h5>
                <h6>USE CODE: Colorlib</h6>
            </div>
            <!-- Single Discount Area -->
            <div class="single-discount-area">
                <h5>20% Discount for students</h5>
                <h6>USE CODE: Colorlib</h6>
            </div>
        </section>
        <!-- ****** Top Discount Area End ****** -->