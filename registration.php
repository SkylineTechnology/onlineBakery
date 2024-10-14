<?php
session_start();
include 'include/connection.php';
include 'include/functions.php';

if (isset($_POST["submit"])) {
    $cus_id = uniqueCode($conn);
    $fullname = secure($_POST["fullname"]);
    $venture = secure($_POST["businessname"]);
    $gender = secure($_POST["gender"]);
    $phone = secure($_POST["phone"]);
    $email = secure($_POST["email"]);
    $location = secure($_POST["location"]);
    $address = secure($_POST["address"]);
    $reg_date = date("Y-m-d H:i:s");
     $role = "customer";
    
     $chk_email = mysqli_num_rows(mysqli_query($conn, "select * from customer where email='$email'"));
    if ($chk_email > 0) {
        echo "<script>alert('This email have already been registered!')</script>";
    } else {

        $reg_customer = mysqli_query($conn, "insert into customer values ('$cus_id','$fullname','$venture','$gender','$phone','$email','$location','$address','$reg_date')");

        if ($reg_customer) {          
            $insert_login = mysqli_query($conn, "insert into login values ('$email','$email','$role','active')");
            echo "<script>alert('Registration was Successful!')</script>";
        } else {
            echo "<script>alert('Operations Failed, Please Try after some minutes!')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $sitename; ?></title>
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
                    <li><i class="fa fa-home" aria-hidden="true"></i><a href="index.html">Home</a><span>|</span></li>
                    <li>Registration</li>
                </ul>
            </div>
        </div>
        <!-- //products-breadcrumb -->
        <!-- banner -->
        <div class="banner">

            <div class="w3l_banner_nav_right">
                <!-- mail -->
                <div class="mail">
                    <h3>Registration</h3>
                    <div class="agileinfo_mail_grids">

                        <div class="col-md-10 agileinfo_mail_grid_right" style="margin-left: 100px">
                            <form action="#" method="post">
                                <div class="col-md-6 wthree_contact_left_grid">
                                    <input type="text" name="fullname" placeholder="Fullname"><br><br>
                                    <select type="text" name="gender" >
                                        <option value="">Select gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <input type="email" name="email" placeholder="Email"  required="">   
                                </div>
                                <div class="col-md-6 wthree_contact_left_grid">
                                    <input type="text" name="businessname" placeholder="Venture Name"  required="">
                                    <input type="text" name="phone" placeholder="Phone"><br><br>

                                    <select type="text" name="location" >
                                        <option value="">Select Location</option>
                                        <option value="makurdi">Makurdi</option>
                                        <option value="gboko">Gboko</option>
                                        <option value="otukpo">Otukpo</option>
                                        <option value="otukpa">Otukpa</option>
                                        <option value="alaide">Alaide</option>
                                    </select><br>
                                </div>
                                <div class="clearfix"> </div>
                                <textarea  name="address" placeholder="Address" required=""></textarea>
                                <input type="submit" name="submit" value="Submit">
                                <input type="reset" value="Clear">
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


        <!-- //newsletter -->
        <!-- footer -->

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