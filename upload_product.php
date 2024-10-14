<?php
session_start();
include 'include/connection.php';
include 'admin/includes/functions.php';


  
if (isset($_POST["submit"])) {
    $pname = $_POST["pname"];
    $pprice = $_POST["pprice"];
    $date = date("Y-m-d H:i:s");
    $pid = "PROD-" . date('ism');
    $status = "not approved";

    // Images
    $pic_name = isset($_FILES['pic']['name']) ? $_FILES['pic']['name'] : "";
    //image array
    // $screenshot_ext_array = array(".jpg", ".png", ".gif", ".jpeg");
    //image 1
    if ($pic_name != "") {
        $screen_img1_ext = pathinfo($pic_name, PATHINFO_EXTENSION);
        //if (in_array(strtolower($screen_img1_ext), $screenshot_ext_array)) {
        $img_url = upload_product($_FILES['pic']['tmp_name'], $screen_img1_ext, 1);
        if ($img_url != "") {
            $insert_product = mysqli_query($conn, "insert into product values ('$pid','$pname','$pprice','$img_url','$date','$status')");
            if ($insert_product) {
                echo "<script>alert('Product Added Successfully!')</script>";
            } else {
                echo "<script>alert('Operations Failed, Please Try after some minutes!')</script>";
            }
        } else {
            echo "<script>alert('Operations Failed, Image could not be uploaded!')</script>";
        }
        /**     } else {
          echo "<script>alert('Please include testifier image!')</script>";
          $img_url = "";
          }* */
    } else {
        echo "<script>alert('Operations Failed, Image could not be uploaded!')</script>";
        // $img_url = "";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Product Upload | <?php echo $sitename; ?></title>
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
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
        <!-- //products-breadcrumb -->
        <!-- banner -->
        <div class="banner">
            <div class="w3l_banner_nav_left">
                <nav class="navbar nav_bottom">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header nav_2">
                        <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div> 
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <?php
                    include 'include/sidebar.php';
                    ?>
                </nav>
            </div>
            <div class="w3l_banner_nav_right">
                <!-- mail -->
                <div class="mail">
                    <h3>Upload Product</h3>
                    <div class="agileinfo_mail_grids">
                       
                        <div class="col-md-8 agileinfo_mail_grid_right">
                            <form action="" method="post">
                                <div class="col-md-6 wthree_contact_left_grid">
                                    <input type="text" name="pname" placeholder="Product Name" required="">
                                     <input type="text" name="pprice" placeholder="Product Price" required="">
                                   
                                </div>
                                <div class="col-md-6 wthree_contact_left_grid">
                                    <input name="pic" accept=".jpg, .jpeg, .png, .jif" type="file" placeholder="Product Price" required="">
                                </div>
                                <div class="clearfix"> </div>
                                <input type="submit" name="submit" value="Submit">
                                
                            </form>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <!-- //mail -->
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- //banner -->


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

        </script>s
    </body>
</html>