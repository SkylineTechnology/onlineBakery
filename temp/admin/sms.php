<?php
ini_set("max-excecution", 999);
session_start();
include '../includes/connection.php';
include 'includes/functions.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
if ($role != "admin") {
    header("location:login.php");
}
$error_msg = [];
$success_msg = [];

//for single individual contact
if (isset($_POST["sendsingle"])) {
    $date = date("Y-m-d H:i:s");
    $message = $_POST["messagesingle"];
    $respo = "YES";
    $contactsingle = isset($_POST['phonesingle']) ? $_POST["phonesingle"] : '';

    if ($contactsingle != "") {
        if ($contactsingle != "" && strlen($contactsingle) >= 11) {
            $phoneContact = $contactsingle;
            $senderid = 'doofan';
            $recipients = $phoneContact;
            $token = '##';

//The generated code from api-x token page
            $url = 'https://smartsmssolutions.com/api/';


            $sms_array = array(
                'sender' => $senderid,
                'to' => $recipients,
                'message' => $message,
                'type' => '0', //This can be set as desired. 0 = Plain text ie the normal SMS
                'routing' => '3', //This can be set as desired. 3 = Deliver message to DND phone numbers via the corporate route
                'token' => $token
            );

//Call sendsms_post function to send SMS        
            $response = sendsms_post($url, $sms_array);

//Echo the reply
//echo $response;
//Or to validate by calling the validate_sendsms function
            //  var_dump(validate_sendsms($response, "sms.php"));

            $result = validate_sendsms($response);

            if ($result == 1) {
                $message_records = mysqli_query($conn, "INSERT INTO sms (sn,phone, message,status,date) VALUES ('','$phoneNumber','$message','$respo','$date')");
                if ($message_records) {
                    array_push($success_msg, "SMS sent Successfully!");
                } else {
                    array_push($error_msg, "Operations Failed, Please Try after some minutes!");
                }
            } else {
                array_push($error_msg, "Unable to send SMS messages, either poor network or low credit unit, Please try after some minutes!");
            }
        } else {
            array_push($error_msg, "Invalid phone number,please check number again, Unable to send SMS message!");
        }
    } else {
        echo "<script>alert('No contacts number entered, please enter contact number.')</script>";
    }
}


//for selected contacts
if (isset($_POST["send"])) {
    $date = date("Y-m-d H:i:s");
    $message = $_POST["message"];
    $respo = "YES";
    $contacts = isset($_POST['phone']) ? $_POST["phone"] : '';

    if ($contacts != "") {
        foreach ($contacts as $phone) {
            if ($phone != "" && strlen($phone) >= 11) {
                $phoneNumber = $phone;
                $senderid = 'doofan';
                $recipients = $phoneNumber;
                $token = '#';

//The generated code from api-x token page
                $url = 'https://smartsmssolutions.com/api/';


                $sms_array = array(
                    'sender' => $senderid,
                    'to' => $recipients,
                    'message' => $message,
                    'type' => '0', //This can be set as desired. 0 = Plain text ie the normal SMS
                    'routing' => '3', //This can be set as desired. 3 = Deliver message to DND phone numbers via the corporate route
                    'token' => $token
                );

//Call sendsms_post function to send SMS        
                $response = sendsms_post($url, $sms_array);

//Echo the reply
//echo $response;
//Or to validate by calling the validate_sendsms function
                //  var_dump(validate_sendsms($response, "sms.php"));

                $result = validate_sendsms($response);

                if ($result == 1) {
                    $send_selected = mysqli_query($conn, "INSERT INTO sms (sn,phone, message,status,date) VALUES ('','$phoneNumber','$message','$respo','$date')");
                    if ($send_selected) {
                        array_push($success_msg, "SMS sent Successfully!");
                    } else {
                        array_push($error_msg, "Operations Failed, Please Try after some minutes!");
                    }
                } else {
                    array_push($error_msg, "Unable to send SMS messages, either poor network or low credit unit, Please try after some minutes!");
                }
            } else {
                array_push($error_msg, "Invalid phone number, Unable to send SMS messages!");
            }
        }
    } else {
        echo "<script>alert('No contacts selected, please select some contacts.')</script>";
    }
}


//for all contacts
if (isset($_POST["sendall"])) {
    $message = $_POST["messageall"];
    $date = date("Y-m-d H:i:s");
    $get_contacts = mysqli_query($conn, "select phone from members");
    $db_contacts = mysqli_fetch_array($get_contacts);
    $no_contacts = mysqli_num_rows($get_contacts);
    $contact = $db_contacts["phone"];
    // print_r($contact);
    // print_r($db_contacts);
    $respo = "YES";

    if ($no_contacts > 0) {
        foreach ($db_contacts as $key => $db_phone) {
            if ($db_phone != "" && strlen($db_phone) >= 11) {
                $contactNumber = $db_phone;

                $senderid = 'doofan';
                $recipients = $contactNumber;
                $token = '##';

                //The generated code from api-x token page
                $url = 'https://smartsmssolutions.com/api/';

                $sms_array = array(
                    'sender' => $senderid,
                    'to' => $recipients,
                    'message' => $message,
                    'type' => '0', //This can be set as desired. 0 = Plain text ie the normal SMS
                    'routing' => '3', //This can be set as desired. 3 = Deliver message to DND phone numbers via the corporate route
                    'token' => $token
                );

                //Call sendsms_post function to send SMS        
                $response = sendsms_post($url, $sms_array);

                //Echo the reply
                //echo $response;
                //Or to validate by calling the validate_sendsms function
                //  var_dump(validate_sendsms($response, "sms.php"));

                $result = validate_sendsms($response);

                if ($result == 1) {
                    $send_selected = mysqli_query($conn, "INSERT INTO sms (sn,phone, message,status,date) VALUES ('','$contactNumber','$message','$respo','$date')");
                    if ($send_selected) {
                        array_push($success_msg, "SMS sent Successfully!");
                    } else {
                        array_push($error_msg, "SMS sending operations failed!");
                    }
                } else {
                    array_push($error_msg, "Unable to send SMS messages, either poor network or low credit unit, Please try after some minutes!");
                }
            } else {
                array_push($error_msg, "Invalid Phone number, Unable to send SMS message!");
            }
        }
    } else {
        echo "<script>alert('No contacts in database, please register members with contacts and try again.')</script>";
    }
}
//echoing success messages
foreach ($success_msg as $key => $msg) {
    if ($key < 1) {
        echo "<script>alert('$msg')</script>";
    } else {
        break;
    }
}

//echoing error messages
foreach ($error_msg as $k => $error) {
    if ($k < 1) {
        echo "<script>alert('$error')</script>";
    } else {
        break;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Send Bulk SMS</title>
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
                        Send Bulk SMS
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
                                <span class="info-box-icon bg-aqua"><i class=" glyphicon glyphicon-camera"></i></span>
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
                                <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-bullhorn"></i></span>
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
                                <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
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
                                <span class="info-box-icon bg-yellow"><i  class=" glyphicon glyphicon-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">New Members</span>
                                    <?php $interval="2 months";
                                    $date=date("Y-m-d");
                                    $date_object= date_create($date);
                                    $added_date=date_sub($date_object, date_interval_create_from_date_string($interval));
                                    $new_members_date_range= date_format($added_date, "Y-m-d");                                      
                                      $new_members = mysqli_num_rows(mysqli_query($conn, "select * from members where date > '$new_members_date_range'"));

                                     ?>

                                    <span class="info-box-number"><?php echo $new_members; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->



                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Send SMS Message</h3>
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

                                <!-- Custom tabs (Charts with tabs)-->
                                <div class="nav-tabs-custom">
                                    <!-- Tabs within a box -->
                                    <ul class="nav nav-tabs pull-right">
                                        <li><a href="#single" data-toggle="tab"> SEND TO SINGLE</a></li>
                                        <li><a href="#sales-chart" data-toggle="tab"> SEND TO ALL</a></li>
                                        <li class="active"><a href="#revenue-chart" data-toggle="tab">SEND TO SELECTED</a></li>
                                    </ul>
                                    <div class="tab-content no-padding">
                                        <!-- Morris chart - Sales -->
                                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 100%;">
                                            <form name="form3" action="" method="post" enctype="multipart/form-data">
                                                <div class="box-body">

                                                    <div class="row  box-body">                                           
                                                        <div class="col-xs-12"> 
                                                            Enter Message:
                                                            <div class="form-group">
                                                                <textarea required="" name="message" class="form-control" rows="4" placeholder="Enter Message..."></textarea>
                                                            </div>
                                                        </div>                                          

                                                    </div>


                                                    <div class="box-body">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Select Members </h3>
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
                                                        <table style="" id="example1" class="table table-bordered table-hover">
                                                            <thead >
                                                                <tr style="text-align: center;">
                                                                    <th>TICK</th>
                                                                    <th>FULLNAME</th>
                                                                    <th>PHONE</th>                                                       
                                                                    <th>DEPARTMENT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $result = mysqli_query($conn, "select * from members");
                                                                $a = 1;
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><input id="pns" title="Select to send sms." class="flat-red" value="<?php echo $row["phone"]; ?>" type="checkbox" name="phone[]"></td>
                                                                        <td><?php echo $row["fullname"]; ?></td>
                                                                        <td> <?php echo $row["phone"]; ?></td>                                                           
                                                                        <td> <?php echo $row["dept"]; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                    $a++;
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row box-body">

                                                        <div class="col-xs-8">    
                                                            <div class="checkbox icheck">
                                                                <label>
                                                                </label>
                                                            </div>                        
                                                        </div><!-- /.col -->
                                                        <div class="col-xs-4">
                                                            <button type="submit" name="send" class="btn btn-primary btn-block btn-flat">Send Message</button>
                                                        </div><!-- /.col -->
                                                    </div>
                                                </div>
                                            </form> 
                                        </div>
                                        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 100%;">
                                            <form name="form2" action="" method="post" enctype="multipart/form-data">
                                                <div class="box-body">

                                                    <div class="row  box-body">                                           
                                                        <div class="col-xs-12"> 
                                                            Enter Message:
                                                            <div class="form-group">
                                                                <textarea required="" name="messageall" class="form-control" rows="4" placeholder="Enter Message..."></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-4">
                                                            <button type="submit" name="sendall" class="btn btn-primary btn-block btn-flat">Send to Everyone</button>
                                                        </div><!-- /.col -->

                                                    </div>                                                 

                                                </div>
                                            </form>
                                        </div>

                                        <div class="chart tab-pane" id="single" style="position: relative; height: 100%;">
                                            <form name="form2" action="" method="post" enctype="multipart/form-data">
                                                <div class="box-body">

                                                    <div class="row  box-body">                                           
                                                        <div class="col-xs-12"> 
                                                            Enter Message:
                                                            <div class="form-group has-feedback">
                                                                <textarea required="" name="messagesingle" class="form-control" rows="4" placeholder="Enter Message..."></textarea>
                                                                <span class="glyphicon glyphicon-book form-control-feedback"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-6"> 
                                                            Phone Number:
                                                            <div class="form-group has-feedback">
                                                                <input required="" type="text" name="phonesingle" class="form-control" />
                                                                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-6">
                                                            &nbsp;
                                                            <div class="form-group">
                                                                <button type="submit" name="sendsingle" class="btn btn-primary btn-block btn-flat">Send to Individual</button>
                                                            </div>
                                                        </div><!-- /.col -->

                                                    </div>                                                 

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- /.nav-tabs-custom -->



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