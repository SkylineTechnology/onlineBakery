<?php
session_start();
include 'include/connection.php';
include 'include/functions.php';

if (isset($_POST["submit"])) {
    // $contactUsid = uniqueCode($conn);
    $fullname = secure($_POST["fullname"]);
    $gender = secure($_POST["gender"]);
    $email = secure($_POST["email"]);
    $phone = secure($_POST["phone"]);
    $msg = secure($_POST["mssg"]);
    $status = "no";
    $date = date("Y-m-d H:i:s");
   
        $contactUs = mysqli_query($conn, "insert into contact_us values ('$fullname','$gender','$phone','$email','$msg','$date','$status')") or die(mysqli_error($conn));
        
        if($contactUs){
            echo "<script>alert('Message has Been Sent Successfully')</script>";
        }else{
            echo "<script>alert('There is an error try after some time')</script>";
             echo mysqli_error($conn);
        }
        
    }
    

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Contact Us | <?php echo $sitename; ?></title>
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
                    <h3>Contact Us</h3>
                    <div class="agileinfo_mail_grids">
                        <div class="col-md-4 agileinfo_mail_grid_left">
                            <ul>
                                <li><i class="fa fa-home" aria-hidden="true"></i></li>
                                <li>address<span><br></span></li>
                            </ul>
                            <ul>
                                <li><i class="fa fa-envelope" aria-hidden="true"></i></li>
                                <li>email<span><a href="#"></a></span></li>
                            </ul>
                            <ul>
                                <li><i class="fa fa-phone" aria-hidden="true"></i></li>
                                <li>call to us<span>(+123) 233 2362 826</span></li>
                            </ul>
                        </div>
                        <div class="col-md-8 agileinfo_mail_grid_right">
                            <form action="" method="post">
                                <div class="col-md-6 wthree_contact_left_grid">
                                    <input type="text" name="fullname" placeholder="Fullname" required="">
                                     <input type="text" name="phone" placeholder="Phone" required="">
                                   
                                </div>
                                <div class="col-md-6 wthree_contact_left_grid">
                                    <select type="text" name="gender" >
                                        <option value="">Select gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <input type="email" name="email" placeholder="Email" required="">
                                </div>
                                <div class="clearfix"> </div>
                                <textarea  name="mssg" placeholder="Message" required=""></textarea>
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