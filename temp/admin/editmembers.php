<?php
session_start();
include '../includes/connection.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
$id = isset($_GET["m"]) ? base64_decode($_GET["m"]) : "";


if (isset($_POST["reg"])) {
    $fullname = $_POST["fullname"];
    $gender = $_POST["gender"];
    $mstatus = $_POST["mstatus"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $state = $_POST["state"];
    $lga = $_POST["lga"];
    $address = $_POST["address"];
    $date = $_POST["date"];
    $dept = $_POST["dept"];




    $update_member = mysqli_query($conn, "update members set fullname='$fullname', gender='$gender', mstatus='$mstatus', phone='$phone', email='$email', state='$state', lga='$lga', res_address='$address', date='$date', dept ='$dept' where memberid='$id'") or die(mysqli_error($conn));

    if ($update_member) {
        echo "<script>alert('Member record updated successfully!')</script>";
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
                        Member Registration
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $num = mysqli_num_rows(mysqli_query($conn, "select * from gallery"));
                                    ?>
                                    <span class="info-box-text">Photos in Gallery</span>
                                    <span class="info-box-number"><?php echo $num; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
                                <div class="info-box-content">
                                    <?php
                                    $members_testimonies = mysqli_num_rows(mysqli_query($conn, "select * from testimony"));
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
                                    $members_num = mysqli_num_rows(mysqli_query($conn, "select * from members"));
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
                                    <?php /** $interval="2 months";
                                      $object=date("Y-m-d");
                                      $new_members_date_range= date_sub($object, $interval);
                                      $new_members = mysqli_num_rows(mysqli_query($conn, "select * from members where date > '$new_members_date_range'"));

                                     * */ ?>

                                    <span class="info-box-number"><?php echo 3; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->



                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Member Update Form</h3>
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
                                $rw = mysqli_fetch_array(mysqli_query($conn, "select * from members where memberid='$id'"));
                                
                                $db_dept = $rw["dept"];
                                $department_name = mysqli_fetch_array(mysqli_query($conn, "select * from department where dept_id='$db_dept'"));
                                $deptName = $department_name["dept_name"];
                                
                                $db_memID = $rw['memberid'];
                                $db_email = $rw["email"];
                               
                                $db_fullname = $rw["fullname"];
                                $db_gender = $rw["gender"];
                                $db_mstatus = $rw["mstatus"];
                                $db_phone = $rw["phone"];
                                $db_address = $rw["res_address"];
                                $db_date = $rw["date"];
                                $db_state = $rw["state"];
                                $db_lga = $rw["lga"];
                                ?>
                                <div class="box-body">
                                    <form action="" method="post">
                                        <div class="row  box-body">
                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <input required="" readonly="" name="memberid" type="text" class="form-control" value="<?php echo $db_email; ?>" placeholder="Email"/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>
                                            </div>

                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <input required="" value="<?php echo $db_fullname ?>" name="fullname" type="text" class="form-control" placeholder="Fullname "/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>   
                                            </div>
                                        </div>

                                        <div class="row  box-body">
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

                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <div class="form-group">
                                                        <select name="mstatus" required="" class="form-control">
                                                            <option>Marital Status</option>
                                                            <option value="Single" <?php
                                                            if ($db_mstatus == "Single") {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                ?> >Single</option>
                                                            <option value="Married" <?php
                                                            if ($db_mstatus == "Married") {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                ?>>Married</option>
                                                            <option value="Widow" <?php
                                                            if ($db_mstatus == "Widow") {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                ?>>Widow</option>
                                                            <option value="Widower" <?php
                                                            if ($db_mstatus == "Widower") {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                ?>>Widower</option>
                                                            <option value="Divorce" <?php
                                                            if ($db_mstatus == "Divorce ") {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                ?>>Divorced</option>
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
                                                        <select id="state"  onchange="getlocals(this.value)" name="state" required="" class="form-control">
                                                            <option value="">Select State</option>
                                                            <?php
                                                            $get_state = mysqli_query($conn, "select * from states");
                                                            while ($db = mysqli_fetch_array($get_state)) {
                                                                ?>
                                                                <option value="<?php echo $db["state_id"]; ?>"  <?php
                                                            if ($db["state_id"] == $db_state) {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                                                ?>><?php echo $db["name"]; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <?php $get_lga = mysqli_query($conn, "select * from locals where state_id='$db_state'"); ?>
                                                    <div class="form-group">
                                                        <select id="lga" name="lga" required="" class="form-control">
                                                            <?php
                                                            while ($lg = mysqli_fetch_array($get_lga)) {
                                                                ?>
                                                                <option value="<?php echo $lg["local_id"]; ?>" <?php
                                                            if ($lg["local_id"] == $db_lga) {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                                                ?>><?php echo $lg["local_name"]; ?></option> 
                                                                        <?php
                                                                    }
                                                                    ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function getlocals(val) {
                                                $.ajax({
                                                    type: "POST",
                                                    url: "get_lga.php",
                                                    data: 'state_id=' + val,
                                                    success: function (data) {
                                                        $("#lga").html(data);
                                                    }
                                                });
                                            }
                                        </script>


                                        <div class="row  box-body">
                                            <div class="col-xs-6"> 
                                                <div class="form-group has-feedback">
                                                    <div class="form-group">
                                                        <select name="dept" required="" class="form-control">
                                                            <option value="<?php echo $deptName ?>"><?php echo $deptName . " " . "unit"; ?></option>
                                                            <?php
                                                            $result = mysqli_query($conn, "select * from department");
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                ?>
                                                                <option value="<?php echo $row["dept_name"]; ?>"><?php echo $row["dept_name"] . " " . "unit"; ?></option>
                                                                <?php
                                                            }
                                                            ?>                                                          
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