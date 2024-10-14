<?php
session_start();
include '../include/connection.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";



if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $delete_customer_order = mysqli_query($conn, "DELETE FROM customer_order WHERE cus_id = '$id'");

    if ($delete_customer_order) {
        header("Location: vieworder.php");
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];

    $status = "received";

    $update_cus_order = mysqli_query($conn, "update customer_order set status='$status'where cus_id ='$id'");

    $user = mysqli_fetch_array(mysqli_query($conn, "select * from customer where cus_id='$id'"));

    function sendsms_post($url, array $params) {
        $params = http_build_query($params);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    function validate_sendsms($response) {
        $validate = explode('||', $response);
        if ($validate[0] == '1000') {
            return TRUE;
            //return custom response here instead.
            // header("location:" . $path);
        } else {
            return FALSE;
            //return custom response here instead.
        }
    }

    $message = 'Dear customer your order as been recieved, we will deliver it to your location soon. Thank You!';
    $senderid = 'ETransaction';
    $recipients = $user['phone'];
    $token = 'U7hrGA0fwlVs0zF6B5ehyJwW7QLRVpua0RN5IJJdNsusXaJJV54dcu1I4ldKBNyAKu0w5vHd8114rqIszg8iUEPeowya4juDJESA';

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
    if (validate_sendsms($response) == TRUE) {
        echo "<script> alert('Message has been sent to your mobile phone!');</script>";
    } else {
        echo "<script> alert('Message not sent. OTP saved to database!');</script>";
    }
    //end of token api
    //updating sender acct_balance from the db 
    //echo "<script>window.location.href='token.php';</script>";
    //$_SESSION['message'] = $amount ." has been transferred to " . $reciever_name . " successfully";
    if ($update_cus_order) {
        //header("Location: vieworder.php");
        echo "<script> window.location.href='vieworder.php';</script>";
    } else {
        echo mysqli_error($conn);
    }
} /* else {
  echo "<script>alert('wrong account number, please confirm and try again');</script>";
  } */
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
                                                <th>VENTURE</th>
                                                <th>PRODUCT</th>
                                                <th>QUANTITY</th>
                                                <th>PHONE</th>
                                                <th>EMAIL</th>
                                                <th>LOCATION</th>
                                                <th>ADDRESS</th>
                                                <th>STATUS</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = mysqli_query($conn, "select * from customer_order");
                                            $a = 1;
                                            while ($row = mysqli_fetch_array($result)) {
                                                $prod_id = $row["p_id"];
                                                $cus_name = $row["cus_id"];
                                                $rw1 = mysqli_fetch_array(mysqli_query($conn, "select * from product where p_id ='$prod_id'"));

                                                $prud_name = $rw1["product_name"];
                                                $rw2 = mysqli_fetch_array(mysqli_query($conn, "select * from customer where cus_id ='$cus_name'"));
                                                $get_name = $rw2["fullname"];
                                                $get_venture = $rw2["venture"];
                                                $get_location = $rw2["location"];
                                                $get_address = $rw2["address"];
                                                $get_phone = $rw2["phone"];
                                                $get_email = $rw2["email"];
                                                ?>
                                                <tr>
                                                    <td><?php echo $a; ?></td>
                                                    <td><?php echo $get_name; ?></td>                                                    
                                                    <td><?php echo $get_venture; ?></td>
                                                    <td><?php echo $prud_name ?></td>
                                                    <td><?php echo $row["product_qty"]; ?></td>
                                                    <td> <?php echo $get_phone; ?></td>
                                                    <td> <?php echo $get_email; ?></td>
                                                    <td> <?php echo $get_location; ?></td>
                                                    <td> <?php echo $get_address; ?></td>
                                                    <td><?php echo $row["status"]; ?></td>
                                                    <td>
                                                        <a href="viewprintproduct.php?m=<?php echo base64_encode($cus_name); ?>">PRINT</a> |
                                                        <a href="vieworder.php?del_id=<?php echo $row['p_id']; ?>">DELETE</a>
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