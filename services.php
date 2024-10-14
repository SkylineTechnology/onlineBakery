<?php
session_start();
include 'include/connection.php';
include 'include/functions.php';

?>

<html>
    <head>
        <title>Our Services | <?php echo $sitename; ?></title>
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
        <!-- js -->
        <script src="js/jquery-1.11.1.min.js"></script>
        <!-- //js -->
        <link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
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
    </head>

    <body>
        <?php
        include 'include/header.php';
        ?>
        <!-- //header -->
        <!-- products-breadcrumb -->
        <div class="products-breadcrumb">
            <div class="container">
                <ul>
                    <li><i class="fa fa-home" aria-hidden="true"></i><a href="index">Home</a><span>|</span></li>
                    <li>Services</li>
                </ul>
            </div>
        </div>
        <!-- //products-breadcrumb -->
        <!-- banner -->
        <div class="banner">
            
            <div class="w3l_banner_nav_right">
                <!-- services -->
                <div class="services">
                    <h3>Services</h3>
                    <div class="w3ls_service_grids">
                        <div class="col-md-5 w3ls_service_grid_left">
                            <h4>Service Offered</h4>
                            <p style=" color: black;">.The system is design to detect legit product for online sales</p>
                        </div>
                        <div class="col-md-7 w3ls_service_grid_right">
                            <div class="col-md-4 w3ls_service_grid_right_1">
                                <img src="images/6.jpg" alt=" " class="img-responsive" />
                            </div>
                            <div class="col-md-4 w3ls_service_grid_right_1">
                                <img src="images/9.jfif" alt=" " class="img-responsive" />
                            </div>
                            <div class="col-md-4 w3ls_service_grid_right_1">
                                <img src="images/7.jfif" alt=" " class="img-responsive" />
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="w3ls_service_grids1">
                        <div class="col-md-6 w3ls_service_grids1_left">
                            <img src="images/4.jpg" alt=" " class="img-responsive" />
                        </div>
                        <div class="col-md-6 w3ls_service_grids1_right">
                            <ul>
                                <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i></li>
                                <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i></li>
                                <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> </li>
                                <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i></li>
                                <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i></li>
                               
                            </ul>
                            <a href="items.php">Shop Now</a>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <!-- //services -->
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- //banner -->
        
        
        <!-- //newsletter-top-serv-btm -->
        
        <!-- footer -->
        <?php
        include 'include/footer.php';
        ?>
        <!-- //footer -->
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