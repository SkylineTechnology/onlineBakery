<?php
session_start();
include '../includes/connection.php';
include 'includes/functions.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

if ($role != "admin") {
    header("location:login.php");
}
$unread_msg = mysqli_num_rows(mysqli_query($conn, "select * from contact where status='no'"));
$read_msg = mysqli_num_rows(mysqli_query($conn, "select * from contact where status='yes'"));
$inbox = mysqli_num_rows(mysqli_query($conn, "select * from contact"));
$cont_id = isset($_GET["cid"]) ? base64_decode($_GET["cid"]) : "";

$row = mysqli_fetch_array(mysqli_query($conn, "select * from contact where contact_id='$cont_id'")) or die(mysqli_error($conn));
$contact_id = $row["contact_id"];
$fullname = $row["fullname"];
$email = $row["email"];
$status = $row["status"];
$date = $row["date"];
$message = $row["message"];
$title = $row["title"];
if ($status == "no") {
    mysqli_query($conn, "update contact set status='yes' where contact_id='$contact_id'");
}

$error_message = [];
$success_message = [];

if (isset($_POST["delete"])) {
    $del_query = mysqli_query($conn, "delete from contact where contact_id='$contact_id'");
    if ($del_query) {
        array_push($success_message, "Message(s) deleted successfully");
        header("location:feedbacks.php");
    } else {
        array_push($error_message, "Operations Failed, please try after some minutes");
    }
}

if (isset($_POST["reply"])) {
    $_SESSION["contact_id"] = $contact_id;
    $_SESSION["fullname"] = $fullname;
    $_SESSION["email"] = $email;
    $_SESSION["status"] = $status;
    $_SESSION["date"] = $date;
    $_SESSION["message"] = $message;
    $_SESSION["title"] = $title;
    header("location:compose.php?reply=yes");
}

//for success messages
foreach ($success_message as $key => $value) {
    if ($key < 1) {
        echo "<script>alert('$value')</script>";
    } else {
        break;
    }
}


//for error messages
foreach ($error_message as $kay => $val) {
    if ($kay < 1) {
        echo "<script>alert('$val')</script>";
    } else {
        break;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Read Contacts</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <!-- Ionicons -->
        <!-- fullCalendar 2.2.5-->
        <link href="plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media='print' />
        <!-- Theme style -->
        <!-- AdminLTE Skins. Choose a skin from the css/skins
           
        <!-- iCheck -->
        <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
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
                        User Feedbacks                        
                        <small><?php echo $unread_msg; ?> new messages</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Feedbacks</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="compose.php" class="btn btn-primary btn-block margin-bottom">Compose</a>
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Folders</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <ul class="nav nav-pills nav-stacked">

                                        <li class="active"><a href="feedbacks.php"><i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right"><?php echo $inbox; ?></span></a></li>
                                        <li><a href="feedbacks.php?msg=read"><i class="fa fa-file-text-o"></i> Read <span class="label label-primary pull-right"><?php echo $read_msg; ?></span></a></li>
                                        <li><a href="feedbacks.php?msg=unread"><i class="fa fa-filter"></i> Unread <span class="label label-waring pull-right"><?php echo $unread_msg; ?></span></a></li>
                                    </ul>
                                </div><!-- /.box-body -->
                            </div><!-- /. box -->

                        </div><!-- /.col -->

                        <form method="post" action="">
                            <div class="col-md-9" style="height: 100%">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Read Message</h3>
                                        <div class="box-tools pull-right">
                                            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                                            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
                                        </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body no-padding">
                                        <div class="mailbox-read-info">
                                            <h3><?php echo $title; ?></h3>
                                            <h5>From: <?php echo $email; ?> <span class="mailbox-read-time pull-right"><?php echo date_format(date_create($date), " d M Y H:i A "); ?></span></h5>
                                        </div><!-- /.mailbox-read-info -->
                                        <div class="mailbox-controls with-border text-center">
                                            <div class="btn-group">
                                                <button type="submit" onclick="return confirm('Comfirm you want to delete this message')" name="delete" class="btn btn-default btn-sm" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button>
                                                <button type="submit" name="reply" class="btn btn-default btn-sm" data-toggle="tooltip" title="Reply"><i class="fa fa-reply"></i></button>
                                                <button type="submit" name="forward" class="btn btn-default btn-sm" data-toggle="tooltip" title="Forward"><i class="fa fa-share"></i></button>
                                            </div><!-- /.btn-group -->
                                            <button type="submit" name="print" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></button>
                                        </div><!-- /.mailbox-controls -->
                                        <div class="mailbox-read-message">
                                            <p style="text-align: justify"><?php echo $message; ?></p>

                                        </div><!-- /.mailbox-read-message -->
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <div class="pull-right">
                                            <button type="submit" name="reply" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                                            <button type="submit" name="forward" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                                        </div>
                                        <button type="submit" onclick="return confirm('Comfirm you want to delete this message')" name="delete" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
                                        <button type="submit" name="print" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                                    </div><!-- /.box-footer -->
                                </div><!-- /. box -->
                            </div><!-- /.col -->
                        </form>


                    </div><!-- /.row -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper --><!-- /.content-wrapper -->
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



        <!-- DATA TABES SCRIPT -->
        <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

        <!-- FastClick -->
        <script src='plugins/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js" type="text/javascript"></script>

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