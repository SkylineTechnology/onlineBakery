<?php
session_start();
include 'include/connection.php';
include 'include/functions.php';

if(isset($_POST["add_to_cart"])){
    
    if(isset($_SESSION["shopping_cart"])){
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if(!in_array($_GET["id"], $item_array_id)){
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        } else {
           echo '<script>alert("Item Already Added")</script>';
           echo '<script>window.location="items.php"</script>';
        }
        
    } else {
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]        
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
    
}
if(isset($_GET["action"])){
    if($_GET["action"] == "delete"){
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
           if($values["item_id"] == $_GET["id"]){
               unset($_SESSION["shopping_cart"][$keys]);
               echo '<script>alert("Item Remove")</script>';
               echo '<script>window.location="items.php"</script>';
           } 
        }
    } 
}

if(isset($_GET["reset"])){
    if($_GET["reset"] == 'true'){
        unset($_SESSION["item_name"]);
        unset($_SESSION["item_price"]);
        unset($_SESSION["item_quantity"]);
        unset($_SESSION["shopping_cart"]);
        
        echo '<script>alert("Cart Item has Cleared")</script>';
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Items | <?php echo $sitename; ?></title>
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
                    <li>Product</li>
                </ul>
            </div>
        </div>
        <!-- //products-breadcrumb -->
        <!-- banner -->
     
            <div class="w3l_banner_nav_right">
                <div class="w3l_banner_nav_right_banner8">
                    <h3>Best Deals For New Products<span class="blink_me"></span></h3>
                </div>
                <div class="w3ls_w3l_banner_nav_right_grid w3ls_w3l_banner_nav_right_grid_sub">
                    <h3 class="w3l_fruit">Product</h3>
                    <div class="w3ls_w3l_banner_nav_right_grid1 w3ls_w3l_banner_nav_right_grid1_veg" style="width:80% !important; margin: 0px auto !important;">
                        
                        <?php
                        $product_content = mysqli_query($conn, "select  * from product") or die(mysqli_error($conn));
                        while ($row = mysqli_fetch_array($product_content)) {                           
                            $name = $row["product_name"];
                            $price = $row["product_price"];
                            $image = $row["product_image"];
                            //$stat = $row["status"];

                          
                        ?>
                        <div class="col-md-3 w3ls_w3l_banner_left w3ls_w3l_banner_left_asdfdfd">
                            <form method="post" action="items.php?action=add&id=<?php echo $row["p_id"]; ?>">                                
                            
                                <div class="hover14 column" style="margin-bottom: 10px;">
                                <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                    <div class="agile_top_brand_left_grid_pos">
                                        <img src="images/offer.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="agile_top_brand_left_grid1">
                                        <figure>
                                            <div class="snipcart-item block">
                                                <div class="snipcart-thumb">
                                                    <a href="single.html"><img src="admin/img/<?php echo $image; ?>" style="width: 180px; height: 150px;" alt=" " class="img-responsive" /></a>
                                                    <p><?php echo $name; ?></p>
                                                    <h4>#<?php echo $price; ?></h4>
                                                    <input type="text" name="quantity" class="form-control" value="1" />
                                                    <input type="hidden" name="hidden_name" class="form-control" value="<?php echo $name; ?>" />
                                                    <input type="hidden" name="hidden_price" class="form-control" value="<?php echo $price; ?>" />
                                                    <input type="submit" name="add_to_cart" class="btn btn-success" value="Add to cart" style="margin-top:8px; margin-left: 60px;" />
                                                </div>
                                                
                                            </div>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                           </form>
                        </div>
                        <?php
                        }
                        ?>
                        
                        <div class="clearfix"> </div>
                    </div>
                    <br>
                    <h2 style="text-align: center;">Order details</h2><br/>
                    <div style="display: inline-flex; justify-content: space-between; width: 70%; margin-left: 200px"><a href="bread.php?reset=true" class="btn btn-danger" style="float: right;">Reset Cart</a></div>
                    <div class="bs-docs-example" style="margin-left: 200px;">                        
                         <table class="table table-bordered" style="width: 80% !important;">
					<thead>
						<tr>
							<th width="35%">Item Name</th>
							<th width="10%">Quantity</th>
							<th width="13%">Price</th>
							<th width="15%">Total</th>
                                                        <th width="7%">Action</th>
						</tr>
					</thead>
                                        <?php
                                        if(!empty($_SESSION["shopping_cart"])){
                                            $total = 0;
                                            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                                               
                                            
                                        
                                        ?>
					<tbody>
						<tr>
							<td><?php echo $values["item_name"]; ?></td>
							<td><?php echo $values["item_quantity"]; ?></td>
							<td><?php echo $values["item_price"]; ?></td>
                                                        <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                                                        <td><a href="items.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></td>
						</tr>
						
					</tbody>
                                        <?php
                                        $total = $total + ($values["item_quantity"] * $values["item_price"]);
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3" align="right">Total</td>
                                            <td align="right">NGN <?php echo number_format($total, 2); ?></td>
                                            <td></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr align="right">
                                            <td colspan="5"><a href="checkout"><button class="btn btn-success">Check Out</button></a></td>                                        
                                        </tr>
                                        
				</table>
			</div>
                     
                     
                        <div class="clearfix"> </div>
                    </div>
                
                       
                   
                   
                        <div class="clearfix"> </div>
                    </div>
                </div>
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

        </script>
    </body>
</html>