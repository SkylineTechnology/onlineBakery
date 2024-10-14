<?php
session_start();
include '../include/connection.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

$or_id = isset($_GET["m"]) ? base64_decode($_GET["m"]) : "";

$rw4 = mysqli_fetch_array(mysqli_query($conn, "select * from customer_order where cus_id='$or_id'"));
$get_cus_id = $rw4["cus_id"];

$rw5 = mysqli_fetch_array(mysqli_query($conn, "select * from customer where cus_id ='$get_cus_id'"));
$cus_name = $rw5["fullname"];
$cus_venture = $rw5["venture"];
$cus_location = $rw5["location"];
$cus_address = $rw5["address"];
$cus_phone = $rw5["phone"];
$cus_email = $rw5["email"];

$date = date("d-m-Y");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Invoice | </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <div class="wrapper">

            <?php
            include 'includes/header.php';
            ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php
            include 'includes/sidebar.php';
            ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">

                <!-- Main content -->
                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> Joe-Best bakery.
                                <small class="pull-right">Date: <?php echo $date; ?></small>
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>Joe-Best, Bakery.</strong><br>
                                Mission ward north-bank<br>
                                Makurdi Benue State.<br>
                                Phone: +234-8133448811<br/>
                                Email: info@joebestbakery.com
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong><?php echo $cus_venture; ?>.</strong><br>
                               <?php echo $cus_address; ?><br>
                                <?php echo $cus_location; ?> Benue state<br>
                                <?php echo $cus_phone; ?><br/>
                                <?php echo $cus_email; ?>
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice #007612</b><br/>
                            <br/>
                            <b>Order ID:</b> 4F3S8J<br/>
                            <b>Payment Due:</b> 2/22/2014<br/>
                            <b>Account:</b> 968-34567
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Product</th>
                                        <th>Quantity</th>                                   
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "select * from customer_order where cus_id='$or_id' and status='pending'");
                                    $a = 1;
                                    $total = 0;
                                    while ($row = mysqli_fetch_array($result)) {
                                        $prod_qty = $row["product_qty"];

                                        $prod_id = $row["p_id"];
                                        $cus_name = $row["cus_id"];
                                        $rw1 = mysqli_fetch_array(mysqli_query($conn, "select * from product where p_id ='$prod_id'"));
                                        $prud_name = $rw1["product_name"];
                                        $prod_price = $rw1["product_price"];

                                        $rw2 = mysqli_fetch_array(mysqli_query($conn, "select * from customer where cus_id ='$cus_name'"));
                                        $get_name = $rw2["fullname"];
                                        $get_venture = $rw2["venture"];
                                        $get_location = $rw2["location"];
                                        $get_address = $rw2["address"];
                                        $get_phone = $rw2["phone"];
                                        $get_email = $rw2["email"];

                                        $date = date("d-m-Y");
                                        $rw3 = mysqli_fetch_array(mysqli_query($conn, "select * from charges where location ='$get_location'"));
                                        $shipping_price = $rw3["amount"];
                                        $total = $total + ($prod_qty * $prod_price);
                                        ?>
                                        <tr>
                                            <td><?php echo $a; ?></td>
                                            <td><?php echo $prud_name; ?></td>
                                            <td><?php echo $prod_qty; ?></td>                                        
                                            <td><?php echo $prod_price; ?></td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->

                        <div class="col-xs-6" style="float: right;">
                            <p class="lead">Amount Due <?php echo $date; ?></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>NGN <?php echo $total; ?></td>
                                    </tr>                                   
                                    <tr>
                                        <th>Shipping Charges:</th>
                                        <td><?php echo $shipping_price; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>NGN <?php echo number_format($total + $shipping_price, 2); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="printproduct.php?m=<?php echo base64_encode($or_id); ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                            <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
                            <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
                        </div>
                    </div>
                </section><!-- /.content -->
                <div class="clearfix"></div>
            </div><!-- /.content-wrapper -->
            <footer class="main-footer no-print">
                <div class="pull-right hidden-xs">

                </div>
                <strong>Copyright &copy; 2020 <a href="http://geemlatechnologies.com">Geemla Technologies</a>.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.3 -->
        <script src="../../plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='../../plugins/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="../../dist/js/app.min.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../../dist/js/demo.js" type="text/javascript"></script>
    </body>
</html>
