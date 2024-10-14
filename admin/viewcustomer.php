<?php
session_start();
include '../include/connection.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
$c_id = isset($_GET["m"]) ? base64_decode($_GET["m"]) : "";


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $delete_customer = mysqli_query($conn, "DELETE FROM customer WHERE email = '$id'");

    if ($delete_customer) {
        $customer_log_details = mysqli_query($conn, "DELETE FROM login WHERE username = '$id'");
        header("Location: viewcustomer.php");
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->

        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
                        All Members
                    </h1>
                  
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class=" glyphicon glyphicon-camera"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $num = mysqli_num_rows(mysqli_query($conn, "select * from customer_order"));
                                    ?>
                                    <span class="info-box-text">Customer Order</span>
                                    <span class="info-box-number"><?php echo $num; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-bullhorn"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $customer_feedbacks = mysqli_num_rows(mysqli_query($conn, "select * from contact"));
                                    ?>
                                    <span class="info-box-text">Feedback</span>
                                    <span class="info-box-number"><?php echo $customer_feedbacks; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $customer_num = mysqli_num_rows(mysqli_query($conn, "select * from customer"));
                                    ?>
                                    <span class="info-box-text">Total Customer</span>
                                    <span class="info-box-number"><?php echo $customer_num; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i  class=" glyphicon glyphicon-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">New Customer</span>
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
                                    <h3 class="box-title">Members</h3>
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
                                <div class="box-body" style="overflow-x: scroll;">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>FULLNAME</th>
                                                <th>GENDER</th>
                                                <th>VENTURE</th>
                                                <th>PHONE</th>
                                                <th>EMAIL</th>
                                                <th>LOCATION</th>
                                                <th>ADDRESS</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                                          

                                            $result = mysqli_query($conn, "select * from customer");
                                            $a = 1;
                                            while ($row = mysqli_fetch_array($result)) {
                                              
                                                ?>
                                                <tr>
                                                    <td><?php echo $a; ?></td>
                                                    <td><?php echo $row["fullname"]; ?></td>
                                                    <td><?php echo $row["gender"]; ?></td>
                                                    <td><?php echo $row["venture"]; ?></td>
                                                    <td> <?php echo $row["phone"]; ?></td>
                                                    <td> <?php echo $row["email"]; ?></td>
                                                    <td> <?php echo $row["location"]; ?></td>
                                                    <td> <?php echo $row["address"]; ?></td>
                                                    <td>
                                                        <a href="editcustomer.php?m=<?php echo base64_encode($row["email"]); ?>">UPDATE</a> |
                                                        <a href="viewcustomer.php?del_id=<?php echo $row['email']; ?>">DELETE</a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $a++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
        <!-- DATA TABES SCRIPT -->
        <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='plugins/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js" type="text/javascript"></script>
        <!-- page script -->
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