<?php
ini_set("max-excecution", 999);
session_start();
include '../includes/connection.php';
include 'includes/functions.php';
require_once 'vendor/autoload.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

if ($role != "admin") {
    header("location:login.php");
}
$unread_msg = mysqli_num_rows(mysqli_query($conn, "select * from contact where status='no'"));
$read_msg = mysqli_num_rows(mysqli_query($conn, "select * from contact where status='yes'"));
$inbox = mysqli_num_rows(mysqli_query($conn, "select * from contact"));
$reply_status = isset($_GET["reply"]) ? $_GET["reply"] : "";


$contact_id = $_SESSION["contact_id"];
$fullname = $_SESSION["fullname"];
$email = $_SESSION["email"];
$status = $_SESSION["status"];
$date = $_SESSION["date"];
$message = $_SESSION["message"];
$title = $_SESSION["title"];

$error_message = [];
$success_message = [];
if (isset($_POST["send"])) {
    $subject = $_POST["subject"];
    $text = $_POST["message"];
    $email = $_POST["email"];
    $status = "yes";
    if ($reply_status == "yes") {
        $contact_id = $_SESSION["contact_id"];
    } else {
        $contact_id = "mail";
    }
    $date = date("Y-m-d H:i:s");

    //Send email
    $user_name = "higherfortressintl@gmail.com";
    $password = "emailhigherfortress247";
    $receiver = $email;
    $body = "<html><head><title>Higher Fortress Ministry International</title></head>"
            . "<body>"
            . "<p style='text-align:justify;'>"
            . "$text"
            . "</p>"
            . "</body></html>";

    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
            ->setUsername($user_name)
            ->setPassword($password)
    ;

    // Create a message
    $message = Swift_Message::newInstance();
    $message->setSubject($subject);
    $message->setFrom([$user_name => 'Higher fortress Min. Int\'l']);
    $message->setTo([$receiver => 'Receiver']);
    $message->setContentType('text/html');
    $message->setBody($body);

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Send the message and save details to Database 
    $result = $mailer->send($message);

    if ($result) {
        $inser_query = mysqli_query($conn, "insert into emails values('','$email','$subject','$text','$status','$contact_id','$date')");
        if ($inser_query) {
            array_push($success_message, "Email sent successfully");
        } else {
            array_push($error_message, "Operations Failed, please try after some minutes");
        }
    } else {
        array_push($error_message, "Poor Network, Unable to send email, please try after some minutes");
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

        <!-- CK-EDITOR -->
        <script src="ckeditor/ckeditor.js"></script>
        <script src="ckeditor/samples/js/sample.js"></script>


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
                            <a href="feedbacks.php" class="btn btn-primary btn-block margin-bottom">back to Inbox</a>
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
                                        <h3 class="box-title">Compose Message</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <?php
                                        if ($reply_status == "yes") {
                                            ?>
                                            <div class="form-group">
                                                <input type="email" value="<?php echo $email; ?>" name="email" class="form-control" placeholder="To:"/>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="form-group">
                                                <input type="email" value="" name="email" class="form-control" placeholder="To:"/>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="form-group">
                                            <input type="text" name="subject" class="form-control" placeholder="Subject:"/>
                                        </div>                                   
                                        <div class="form-group">
                                            <textarea name="message" id="editor" class="form-control" style="height: 300px">Enter message here...</textarea>
                                        </div>

                                        <script>
                                            initSample();
                                        </script>
                                        <!--  <div class="form-group">
                                              <div class="btn btn-default btn-file">
                                                  <i class="fa fa-paperclip"></i> Attachment
                                                  <input readonly="" name="file" type="file" name="attachment"/>
                                              </div>
                                              <p class="help-block">Max. 32MB</p>
                                          </div>
                                        -->
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <div class="pull-right">
                                            &nbsp; &nbsp;
                                         <!--     <button type="submit" readonly class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button> -->
                                        </div>
                                        <button name="send" type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>

                                        &nbsp;  &nbsp;
                                        <!--  <button type="submit" readonly class="btn btn-default"><i class="fa fa-times"></i> Discard</button> -->
                                    </div><!-- /.box-footer -->
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
        <script src="plugins/jQuery/jQueryk-2.1.3.min.js"></script>
        <script src="plugins/jQuery/js/jquery.min.js"></script>

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

                                            $(function () {
                                                //Add text editor
                                                $("#compose-textarea").wysihtml5();
                                            });
        </script>
    </body>
</html>