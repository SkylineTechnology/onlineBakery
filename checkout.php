<?php
session_start();
include 'include/connection.php';
include 'include/functions.php';

if ($_SESSION['username'] == "") {
    header("Location: login.php");
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";


$rw = mysqli_fetch_array(mysqli_query($conn, "select * from customer where email ='$username'"));
$db_cusId = $rw['cus_id'];
$db_location = $rw["location"];
 
        
 $charges = mysqli_fetch_array(mysqli_query($conn, "select amount from charges where location ='$db_location'"));
 $amount = $charges["amount"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Check Out | <?php echo $sitename; ?></title>
        <!-- for-mobile-apps -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Grocery Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
              Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //for-mobile-apps -->
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <!-- font-awesome icons -->
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" media="all" /> 
        <!-- //font-awesome icons -->

        <link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>

    </head>

    <body>
        <!-- header -->
        <?php
        include 'include/header.php';      
        ?>
        <!-- //header -->
        <!-- products-breadcrumb -->
        <div class="products-breadcrumb">
            <div class="container">
                <ul>
                    <li><i class="fa fa-home" aria-hidden="true"></i><a href="index">Home</a><span>|</span></li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>
        <!-- //products-breadcrumb -->
        <!-- banner -->
        <div class="banner">

            <div class="w3l_banner_nav_right">
                <!-- about -->
                <div class="privacy about">



                    <div class="checkout-left">
                        <form action="" method="POST">
                            <div class="col-md-8 checkout-left-basket" style="margin-left: 250px;">
                                <h4>Your Order</h4>                                
                                <ul>
                                    <li style="color: black; font-weight: bolder;">PRODUCT  <span>TOTAL </span></li>
                                    <?php
                                    if (!empty($_SESSION["shopping_cart"])) {
                                        $total = 0;
                                        foreach ($_SESSION["shopping_cart"] as $keys => $values) {



                                            if (isset($_POST["send_order"])) {
                                                $item_qty = $values["item_quantity"];
                                                $product_id = $values["item_id"];
                                                $order_date = $reg_date = date("Y-m-d H:i:s");
                                                $status = "pending";
                                                $order_query = mysqli_query($conn, "insert into customer_order values('','$db_cusId','$product_id','$item_qty','$order_date','$status')");
                                                if ($order_query) {
                                                    unset($_SESSION["item_name"]);
                                                    unset($_SESSION["item_price"]);
                                                    unset($_SESSION["item_quantity"]);
                                                    unset($_SESSION["shopping_cart"]);
                                                   
                                                    echo '<script>alert("Ordered Placed Succussfully");window.location="items.php"</script>';
                                                    
                                                }
                                            } else {
                                                echo mysqli_error($conn);
                                            }
                                            ?>
                                            <li style="color: black; border: 1px solid #ccc; padding: 10px; border-radius: 10px; font-weight: bolder;">(<?php echo $values["item_quantity"]; ?>x)&nbsp;<?php echo $values["item_name"]; ?> <span><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></span></li>
                                            <?php
                                            $total = $total + ($values["item_quantity"] * $values["item_price"]);
                                        }
                                        ?>
                                        <li style="color: black; border: 1px solid #ccc; padding: 10px; border-radius: 10px; margin-top: 18px; font-weight: bolder;">Total Service Charges <span><?php echo number_format($amount, 2); ?></span></li>
                                        <li style="color: black; font-weight: bolder; font-size: 20px;">Total <span>NGN <?php echo number_format($total + $amount, 2); ?></span></li>
                                    </ul>
                                    <?php
                                }
                                ?>
                                <br>
                                <div>
                                    <a href=""><button type="submit" class="btn btn-success" name="send_order" style="float: right; margin-left: 20px;">Place Order</button></a>                                
                                    <a href="items.php" class="btn btn-success" style="float: right;">Continue Shopping</a>
                                </div>
                            </div>
                        </form>

                        <div class="clearfix"> </div>

                    </div>

                </div>
                <!-- //about -->
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- //banner -->



        <!-- footer -->
        <?php
        include 'include/footer.php';
        ?>
        <!-- //footer -->
        <!-- js -->
        <script src="js/jquery-1.11.1.min.js"></script>
        <!--quantity-->
        <script>
            $('.value-plus').on('click', function () {
                var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10) + 1;
                divUpd.text(newVal);
            });

            $('.value-minus').on('click', function () {
                var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10) - 1;
                if (newVal >= 1)
                    divUpd.text(newVal);
            });
        </script>
        <!--quantity-->
        <script>$(document).ready(function (c) {
                $('.close1').on('click', function (c) {
                    $('.rem1').fadeOut('slow', function (c) {
                        $('.rem1').remove();
                    });
                });
            });
        </script>
        <script>$(document).ready(function (c) {
                $('.close2').on('click', function (c) {
                    $('.rem2').fadeOut('slow', function (c) {
                        $('.rem2').remove();
                    });
                });
            });
        </script>
        <script>$(document).ready(function (c) {
                $('.close3').on('click', function (c) {
                    $('.rem3').fadeOut('slow', function (c) {
                        $('.rem3').remove();
                    });
                });
            });
        </script>

        <!-- //js -->
        <!-- script-for sticky-nav -->
        <script>
            $(document).ready(function () {
                var navoffeset = $(".agileits_header").offset().top;
                $(window).scroll(function () {
                    var scrollpos = $(window).scrollTop();
                    if (scrollpos >= navoffeset) {
                        $(".agileits_header").addClass("fixed");
                    } else {
                        $(".agileits_header").removeClass("fixed");
                    }
                });

            });
        </script>
        <!-- //script-for sticky-nav -->
        <!-- start-smoth-scrolling -->
        <script type="text/javascript" src="js/move-top.js"></script>
        <script type="text/javascript" src="js/easing.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".scroll").click(function (event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
                });
            });
        </script>
        <!-- start-smoth-scrolling -->
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".dropdown").hover(
                        function () {
                            $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                            $(this).toggleClass('open');
                        },
                        function () {
                            $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                            $(this).toggleClass('open');
                        }
                );
            });
        </script>
        <!-- here stars scrolling icon -->
        <script type="text/javascript">
            $(document).ready(function () {
                /*
                 var defaults = {
                 containerID: 'toTop', // fading element id
                 containerHoverID: 'toTopHover', // fading element hover id
                 scrollSpeed: 1200,
                 easingType: 'linear' 
                 };
                 */

                $().UItoTop({easingType: 'easeOutQuart'});

            });
        </script>
        <!-- //here ends scrolling icon -->
        <script src="js/minicart.js"></script>
        <script>
            paypal.minicart.render();

            paypal.minicart.cart.on('checkout', function (evt) {
                var items = this.items(),
                        len = items.length,
                        total = 0,
                        i;

                // Count the number of each item in the cart
                for (i = 0; i < len; i++) {
                    total += items[i].get('quantity');
                }

                if (total < 3) {
                    alert('The minimum order quantity is 3. Please add more to your shopping cart before checking out');
                    evt.preventDefault();
                }
            });

        </script>
    </body>
</html>