<?php
session_start();
include 'include/connection.php';
include 'include/functions.php';

$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
$id = isset($_GET["memberid"]) ? base64_decode($_GET["memberid"]) : "";


$rw = mysqli_fetch_array(mysqli_query($conn, "select * from customer where email ='$username'"));
$db_cusId = $rw['cus_id'];





?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Orders | <?php echo $sitename; ?></title>
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
                    <li>My Orders</li>
                </ul>
            </div>
        </div>
        <!-- //products-breadcrumb -->
        <!-- banner -->
        <div class="bs-docs-example" style="width:95%; margin: 0px auto; margin-top: 15px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="3">#</th>
                        <th width="10">Fullname</th>
                        <th width="10">Venture</th>
                        <th width="10">Product</th>
                        <th width="10">Quantity</th>
                        <th width="10">Phone</th>
                        <th width="10">Email</th>
                        <th width="10">Location</th>
                        <th width="17">Address</th>
                        <th width="10">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "select * from customer_order where cus_id ='$db_cusId' ");
                    $a = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $prod_id = $row["p_id"];
                        $cus_name = $row["cus_id"];
                        $rw1 = mysqli_fetch_array(mysqli_query($conn, "select * from product where p_id ='$prod_id'"));

                        $prud_name = $rw1["product_name"];
                        $rw2 = mysqli_fetch_array(mysqli_query($conn, "select * from customer where cus_id ='$cus_name'"));
                        $get_name = $rw2["fullname"];
                        $get_venture = $rw2["venture"];
                        $get_location = $rw2["location"];
                        $get_address = $rw2["address"];
                        $get_phone = $rw2["phone"];
                        $get_email = $rw2["email"];
                        ?>
                        <tr>
                            <td><?php echo $a; ?></td>
                            <td><?php echo $get_name; ?></td>                                                    
                            <td><?php echo $get_venture; ?></td>
                            <td><?php echo $prud_name ?></td>
                            <td><?php echo $row["product_qty"]; ?></td>
                            <td> <?php echo $get_phone; ?></td>
                            <td> <?php echo $get_email; ?></td>
                            <td> <?php echo $get_location; ?></td>
                            <td> <?php echo $get_address; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                         
                        </tr>
                        <?php
                        $a++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

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