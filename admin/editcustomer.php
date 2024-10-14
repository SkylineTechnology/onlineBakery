<?php
session_start();
include '../include/connection.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
$id = isset($_GET["m"]) ? base64_decode($_GET["m"]) : "";

 $rw1 = mysqli_fetch_array(mysqli_query($conn, "select * from customer where email='$id'"));
  $db_pic = $rw1["picture"];

if (isset($_POST["reg"])) {
    $fullname = $_POST["fullname"];
    $venture = $_POST["venture"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $location = $_POST["location"];
    $address = $_POST["address"];
    $date = $_POST["date"];





    $update_member = mysqli_query($conn, "update customer set fullname='$fullname', venture='$venture', gender='$gender', phone='$phone', email='$email', location='$location', address='$address', reg_date='$date' where email='$id'") or die(mysqli_error($conn));

    if ($update_member) {
        echo "<script>alert('Customer record updated successfully!')</script>";
    } else {
        echo "<script>alert('Operations Failed, Please Try after some minutes!')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Member Registration</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
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
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Customer Profile
                    </h1>
                   
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Info boxes -->
                    <div class="row">

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $members_testimonies = mysqli_num_rows(mysqli_query($conn, "select * from contact"));
                                    ?>
                                    <span class="info-box-text">Testimonies</span>
                                    <span class="info-box-number"><?php echo $members_testimonies; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $members_num = mysqli_num_rows(mysqli_query($conn, "select * from customer"));
                                    ?>
                                    <span class="info-box-text">Total Members</span>
                                    <span class="info-box-number"><?php echo $members_num; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">New Members</span>
                                    <?php
                                    $interval = "2 months";
                                    $date = date("Y-m-d");
                                    $date_object = date_create($date);
                                    $added_date = date_sub($date_object, date_interval_create_from_date_string($interval));
                                    $new_customer_date_range = date_format($added_date, "Y-m-d");
                                    $new_customer = mysqli_num_rows(mysqli_query($conn, "select * from customer where reg_date > '$new_customer_date_range'"));
                                    ?>

                                    <span class="info-box-number"><?php echo $new_customer; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->



                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Customer Update Form</h3><br><br>

                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div style=" border: 1px solid #ccc; height: 300px;">
                                            <img src="../passport/<?php echo $db_pic; ?>" width="100%" height="100%"/>
                                        </div><!-- /.info-box -->
                                    </div><!-- /.col -->

                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <div class="btn-group">
                                            <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Separated link</a></li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div><!-- /.box-header -->
                                <?php
                                $rw = mysqli_fetch_array(mysqli_query($conn, "select * from customer where email='$id'"));

                                $db_cusID = $rw['cus_id'];
                                $db_fullname = $rw["fullname"];
                                $db_venture = $rw["venture"];
                                $db_gender = $rw["gender"];
                                $db_phone = $rw["phone"];
                                $db_email = $rw["email"];
                                $db_location = $rw["location"];
                                $db_address = $rw["address"];                               
                                $db_date = $rw["reg_date"];
                                ?>
                                <div class="box-body">
                                    <form action="" method="post">
                                        <div class="row  box-body">
                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <input required="" readonly="" name="cus_id" type="text" class="form-control" value="<?php echo $db_cusID; ?>" placeholder="Customer ID" readonly=""/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>
                                            </div>

                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <input required="" value="<?php echo $db_fullname ?>" name="fullname" type="text" class="form-control" placeholder="Fullname "/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>   
                                            </div>
                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <input required="" name="venture" type="text" class="form-control" value="<?php echo $db_venture; ?>" placeholder="Venture Name"/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <div class="form-group">
                                                        <select name="gender" required="" class="form-control">
                                                            <option value="">Gender</option>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row  box-body">
                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <input required="" value="<?php echo $db_phone ?>" name="phone" type="text" class="form-control" placeholder="Phone "/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>
                                            </div>

                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <input readonly="" name="email" value="<?php echo $db_email ?>" type="text" class="form-control" placeholder="Email "/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>   
                                            </div>
                                        </div>




                                        <div class="row  box-body">
                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <div class="form-group">
                                                        <select name="location" required="" class="form-control">
                                                            <option value="<?php echo $db_location ?>"><?php echo $db_location; ?></option>
                                                            <option value="makurdi">Makurdi</option>
                                                            <option value="gboko">Gboko</option>
                                                            <option value="otukpo">Otukpo</option>
                                                            <option value="otukpa">Otukpa</option>
                                                            <option value="alaide">Alaide</option>
                                                            <option value="">Enpty</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback date">
                                                    <input name="date" value="<?php echo $db_date ?>" type="date" class="form-control" placeholder="Membership Date"/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row  box-body">                                           
                                            <div class="col-xs-12"> 
                                                <div class="form-group">
                                                    <textarea name="address" class="form-control" rows="3" placeholder="Enter residential Address..."><?php echo $db_address ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row box-body">
                                            <div class="col-xs-8">    
                                                <div class="checkbox icheck">
                                                    <label>
                                                    </label>
                                                </div>                        
                                            </div><!-- /.col -->
                                            <div class="col-xs-4">
                                                <button type="submit" name="reg" class="btn btn-primary btn-block btn-flat">Update Records</button>
                                            </div><!-- /.col -->
                                        </div>
                                    </form>     
                                </div>

                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <!-- Main row -->

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php
            include 'includes/footer.php';
            ?>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.3 -->
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='plugins/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>

        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(function () {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
    </body>
</html>