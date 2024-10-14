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
$msg_read_status = isset($_GET["msg"]) ? $_GET["msg"] : "";

$error_message = [];
$success_message = [];
if (isset($_POST["delete"])) {
    //$id = $_POST["contact_id"];
    $id = isset($_POST['contact_id']) ? $_POST["contact_id"] : '';

    if ($id != "") {
        foreach ($id as $contid) {
            $del_query = mysqli_query($conn, "delete from contact where contact_id='$contid'");
            if ($del_query) {
                array_push($success_message, "Message(s) deleted successfully");
            } else {
                array_push($error_message, "Operations Failed, please try after some minutes");
            }
        }
    } else {
        array_push($error_message, "Please Select message to delete,select and try again");
    }
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
        <title>Admin | Feedback Messages</title>
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
                        <div class="col-md-9">
                            <form method="post" action="" >
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <?php
                                            if ($msg_read_status == "unread") {
                                                echo "Unread Message(s)";
                                            } elseif ($msg_read_status == "read") {
                                                echo "Read Message(s)";
                                            } else {
                                                echo "Inbox Message(s)";
                                            }
                                            ?>  
                                        </h3>
                                        <div class="box-tools pull-right">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control input-sm" placeholder="Search Mail"/>
                                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                            </div>
                                        </div><!-- /.box-tools -->
                                    </div><!-- /.box-header -->
                                    <div class="box-body no-padding">

                                        <div class="table-responsive mailbox-messages">
                                            <table  id="example1" class="table table-hover table-striped">
                                                <tbody>
                                                    <?php
                                                    if ($msg_read_status == "") {

                                                        $get_feedbacks = mysqli_query($conn, "select * from contact order by date desc");
                                                        while ($row = mysqli_fetch_array($get_feedbacks)) {
                                                            $contact_id = $row["contact_id"];
                                                            $fullname = $row["fullname"];
                                                            $email = $row["email"];
                                                            $status = $row["status"];
                                                            $date = $row["date"];
                                                            $message = $row["message"];
                                                            $title = $row["title"]
                                                            ?>
                                                            <tr>
                                                                <td><input title="select message to delete" name="contact_id[]" value="<?php echo $contact_id; ?>" type="checkbox" /></td>
                                                                <td class="mailbox-star">
                                                                    <?php
                                                                    if ($status == "yes") {
                                                                        ?>
                                                                        <a href="#"><i class="fa fa-star text-blue"></i></a>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <a href="#"><i class="fa fa-star text-yellow"></i></a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class = "mailbox-name"><a href = "read_mail.php?cid=<?php echo base64_encode($contact_id); ?>"><?php echo $fullname;
                                                                    ?></a></td>
                                                                <td class="mailbox-subject"><b><?php echo $title; ?></b> - <?php echo substr($message, 0, 30); ?>...</td>
                                                                <td class="mailbox-attachment"></td>
                                                                <td class="mailbox-date">
                                                                    <?php
                                                                    //here am getting dates intervals to add on the messages feedback
                                                                    $intervals = gatDates($date);
                                                                    echo $intervals;
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } elseif ($msg_read_status == "read") {
                                                        $get_feedbacks = mysqli_query($conn, "select * from contact where status='yes' order by date desc");
                                                        while ($row = mysqli_fetch_array($get_feedbacks)) {
                                                            $contact_id = $row["contact_id"];
                                                            $fullname = $row["fullname"];
                                                            $email = $row["email"];
                                                            $status = $row["status"];
                                                            $date = $row["date"];
                                                            $message = $row["message"];
                                                            $title = $row["title"]
                                                            ?>
                                                            <tr>
                                                                <td><input  title="select message to delete" name="contact_id[]"  value="<?php echo $contact_id; ?>" type="checkbox" /></td>
                                                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-blue"></i></a></td>
                                                                <td class="mailbox-name"><a href="read_mail.php?cid=<?php echo base64_encode($contact_id); ?>"><?php echo $fullname; ?></a></td>
                                                                <td class="mailbox-subject"><b><?php echo $title; ?></b> - <?php echo substr($message, 0, 30); ?>...</td>
                                                                <td class="mailbox-attachment"></td>
                                                                <td class="mailbox-date">
                                                                    <?php
                                                                    //here am getting dates intervals to add on the messages feedback
                                                                    $intervals = gatDates($date);
                                                                    echo $intervals;
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } elseif ($msg_read_status == "unread") {
                                                        $get_feedbacks = mysqli_query($conn, "select * from contact where status='no' order by date desc");
                                                        while ($row = mysqli_fetch_array($get_feedbacks)) {
                                                            $contact_id = $row["contact_id"];
                                                            $fullname = $row["fullname"];
                                                            $email = $row["email"];
                                                            $status = $row["status"];
                                                            $date = $row["date"];
                                                            $message = $row["message"];
                                                            $title = $row["title"]
                                                            ?>
                                                            <tr>
                                                                <td><input  title="select message to delete" name="contact_id[]" value="<?php echo $contact_id; ?>" type="checkbox" /></td>
                                                                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                                                <td class="mailbox-name"><a href="read_mail.php?cid=<?php echo base64_encode($contact_id); ?>"><?php echo $fullname; ?></a></td>
                                                                <td class="mailbox-subject"><b><?php echo $title; ?></b> - <?php echo substr($message, 0, 30); ?>...</td>
                                                                <td class="mailbox-attachment"></td>
                                                                <td class="mailbox-date">
                                                                    <?php
                                                                    //here am getting dates intervals to add on the messages feedback
                                                                    $intervals = gatDates($date);
                                                                    echo $intervals;
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table><!-- /.table -->
                                        </div><!-- /.mail-box-messages -->
                                    </div><!-- /.box-body -->
                                    <div class="box-footer no-padding">
                                        <div class="mailbox-controls">
                                            <!-- Check all button -->
                                            <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>                    
                                            <div class="btn-group">
                                                <button type="submit"  title="click to delete seleted messages" name="delete" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                                <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                                <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                                            </div><!-- /.btn-group -->
                                            <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                            <div class="pull-right">
                                                1-50/200
                                                <div class="btn-group">
                                                    <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                                    <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                                </div><!-- /.btn-group -->
                                            </div><!-- /.pull-right -->
                                        </div>
                                    </div>
                                </div><!-- /. box -->
                            </form>

                        </div><!-- /.col -->
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