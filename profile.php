<?php
session_start();
include 'include/connection.php';
include 'include/functions.php';

$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
$id = isset($_GET["memberid"]) ? base64_decode($_GET["memberid"]) : "";


$rw = mysqli_fetch_array(mysqli_query($conn, "select * from customer where email ='$username'"));
$db_memID = $rw['cus_id'];
$db_fullname = $rw["fullname"];
$db_venture = $rw["venture"];
$db_gender = $rw["gender"];
$db_phone = $rw["phone"];
$db_email = $rw["email"];
$db_location = $rw["location"];
$db_address = $rw["address"];
$db_date = $rw["reg_date"];


if (isset($_POST["completeReg"])) {
    // $contactUsid = uniqueCode($conn);
    $fullname = $_POST["fullname"];
    $venture = $_POST["venture"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $location = $_POST["location"];
    $address = $_POST["address"];
    $date = $_POST["date"];
    
            
            $update_query = mysqli_query($conn, "UPDATE customer SET fullname ='$fullname', venture='$venture', gender='$gender', phone='$phone', email='$email',location='$location', address='$address', reg_date='$date' WHERE email='$username'") or die(mysqli_error($conn));
            if ($update_query) {
                echo "<script>alert('Profile updated succesfully!'); window.location.href='profile';</script>";
                
            } else {
                echo "<script>alert('There is an error try after some time')</script>";
                echo mysqli_error($conn);
            }
        
    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile | <?php echo $sitename; ?></title>
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
        <style>
            .completReg{
                width: 75%;
           
                border: 1px solid #ccc;
                margin: 0px auto;
                padding: 20px;
            }
            .sec1{
                width: 100%;
               
                display: inline-flex;
                justify-content: space-between;
            }
            .sec2{
                width: 100%;
               
                display: inline-flex;
                justify-content: space-between;

            }
            .uploadPic{
                width: 150px;
                height: 200px;
                border: 1px solid #ccc;
                margin-right: 7px;
            }
            .upperform{
                width: 90%;
                height: 200px;
                padding-top: 35px;

            }
            .left-side-form{
                width: 100%;
                float:left !important;
                position: relative;
                margin-right: 5px;
            }
            .right-side-form{
                width: 49%;
                float: right !important;
                position: relative;
            }
            form input,select,textarea{
                width: 95%;
                border: 1px solid #ccc;
                border-radius: 7px;
                height: 40px;
                margin-bottom: 17px;
                outline: none;
                padding-left: 5px;
            }
        </style>
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
                    <li>Profile</li>
                </ul>
            </div>
        </div>
        <!-- //products-breadcrumb -->
        <!-- banner -->
        <div class="banner">

            <div class="w3l_banner_nav_right">
                <!-- mail -->
                <div class="mail">

                    <div class="agileinfo_mail_grids">

                        <div class="col-md-12 agileinfo_mail_grid_right">
                            <div class="completReg">
                                <form action="" method="post" enctype="multipart/form-data" name="myform">

                                    <h4 class="heading text-capitalize mb-lg-5 mb-4" style="text-align: center; color: #2e8b57;">Profile</h4>

                                    <div class="sec1">
                                        

                                            <div class="left-side-form">
                                                <label>Fullname:</label><br>
                                                <div class="form-left-to-w3l">
                                                    <input type="text" id="title" name="fullname" placeholder="" required="" value="<?php echo $db_fullname; ?>">
                                                    <div class="clear"></div>
                                                </div>
                                                <label>Gender:</label><br>
                                                <div class="form-left-to-w3l">
                                                    <select name="gender" required="">
                                                        <option value="<?php echo $db_gender; ?>"><?php echo $db_gender; ?></option>
                                                        <option value="Male" <?php
                                                        if ($db_gender == "Male") {
                                                            echo "selected='selected'";
                                                        } else {
                                                            
                                                        }
                                                        ?>>Male</option>
                                                        <option value="Female" <?php
                                                        if ($db_gender == "Female") {
                                                            echo "selected='selected'";
                                                        } else {
                                                            
                                                        }
                                                        ?>>Female</option>                                                           
                                                    </select>
                                                    <div class="clear"></div>
                                                </div>
                                                
                                                
                                                    <label>Venture name:</label>
                                            <div>
                                                <input type="text" readonly="" name="venture" placeholder="" required="" value="<?php echo $db_venture; ?>">
                                            </div>
                                             <label>Email:</label>
                                            <div class="form-left-to-w3l">
                                                    <input type="text" id="title" name="email" placeholder="" required="" value="<?php echo $db_email; ?>">
                                                    <div class="clear"></div>
                                            </div>
                                             
                                            <label>Phone:</label><br>
                                            <div class="form-left-to-w3l">
                                                <input type="text" name="phone" placeholder="" required="" value="<?php echo $db_phone; ?>">
                                                <div class="clear"></div>
                                            </div>
                                            <label>Location:</label><br>
                                                <div class="form-left-to-w3l">
                                                    <input type="text" id="title" name="location" placeholder="" required="" value="<?php echo $db_location; ?>" readonly="">

                                                    <div class="clear"></div>
                                                </div>
                                          <label>Address:</label><br>
                                            <div>
                                                <textarea type="text" name="address" placeholder="" required="" value=""><?php echo $db_address; ?></textarea>
                                            </div>
                                            <label>Registration Date:</label><br>
                                            <div>
                                                <input type="text" name="date" placeholder="" required="" value="<?php echo $db_date; ?>">
                                            </div>
                                             <div>
                                                <input type="submit" name="completeReg" onclick="return validateForm()" value="Update" required="">
                                            </div>
                                            </div>
                                            

                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                   
                                </form>
                            </div>
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