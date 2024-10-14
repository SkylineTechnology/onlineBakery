<?php
session_start();
include '../include/connection.php';
include 'includes/functions.php';

$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

//removing post from home page
if (isset($_GET['h'])) {
    $tid = base64_decode($_GET['h']);
    $hide = mysqli_query($conn, "update testimony set status='NO' where testimony_id='$tid'");
    if ($hide) {
        echo "<script>alert('Testimony Hidden from home page successfully!'); window.location.href='testimony.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}

//adding post to home page


//Deleting testing
if (isset($_GET['id'])) {
    $dids = $_GET['id'];
    $del = mysqli_query($conn, "delete from product where p_id='$dids'");
    if ($del) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='product.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}



if ($role != "admin") {
    header("location:login.php");
}

if (isset($_POST["add"])) {
    $pname = $_POST["pname"];
    $pprice = $_POST["pprice"];
    $date = date("Y-m-d H:i:s");
    $pid = "PROD-" . date('ism');
    $status = "Approved";
    // Images
    if($_FILES['image']['error'] === 4){
        echo "<script> alert('Image Does Not Exist') </script>";
    }else{
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $tmpName = $_FILES['image']['tmp_name'];
        
        $validImageExtension = ['jpg', 'jpeg', 'png', 'jfif'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        
        if(!in_array($imageExtension, $validImageExtension)){
            echo "<script> alert('Invalid Image Extension') </script>";
        }else if($fileSize > 1000000){
            echo "<script> alert('Image Size is too Large') </script>";
        }else{
            $newImageName = uniqid('',true).".".$imageExtension;
            //$newImageName += '.'.$imageExtension;
            
            move_uploaded_file($tmpName, 'img/'.$newImageName);
            
            $insert_product = mysqli_query($conn, "insert into product values ('$pid','$pname','$pprice','$newImageName','$date')");
            if ($insert_product) {
        
                echo "<script>alert('Product Added Successfully!'); window.location.href='product.php';</script>";
            } else {
                echo "<script>alert('Operation failed! pls try after some minutes');</script>";
            }
        }
    }
   
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Create product</title>
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


                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Create Product</h3>
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
                                <div class="nav-tabs-custom">
                                    <!-- Tabs within a box -->
                                    <ul class="nav nav-tabs pull-right">                                       
                                        <li ><a href="#sales-chart" data-toggle="tab"> PRODUCTS</a></li>
                                        <li class="active" ><a href="#revenue-chart" data-toggle="tab">ADD PRODUCT</a></li>
                                    </ul>
                                    <div class="tab-content no-padding">
                                        <!-- Morris chart - Sales -->
                                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 100%;">
                                            <div class="box-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div class="row  box-body">
                                                        <div class="col-xs-6"> 
                                                            <div class="form-group has-feedback">
                                                                <input required="" name="pname" type="text" class="form-control" placeholder="Product Name "/>
                                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-6"> 
                                                            <div class="form-group has-feedback">
                                                                <input name="image" accept=".jpg, .jpeg, .png, .jif" type="file" class="form-control" placeholder="image "/>
                                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                            </div>   
                                                        </div>

                                                        <div class="col-xs-6"> 
                                                            <div class="form-group has-feedback">
                                                                <input required="" name="pprice" type="text" class="form-control" placeholder="Product Price "/>
                                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-4">
                                                            <button type="submit" name="add" class="btn btn-primary btn-block btn-flat">Add product</button>
                                                        </div>
                                                    </div>                                 


                                                    <div class="row box-body">


                                                    </div>
                                                </form> 
                                            </div>

                                        </div>

                                        <div class="chart tab-pane " id="sales-chart" style="position: relative; height: 100%;">
                                            <div class="box-body">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Create Product </h3>
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
                                                <table id="example1" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>PRODUCT NAME</th>
                                                            <th>PRODUCT PRICE</th>
                                                            <th>PRODUCT IMAGE</th>
                                                            <th>DATE</th>                                                    
                                                            <th>ACTION</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $result = mysqli_query($conn, "select * from product");

                                                        $a = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $name = $row["product_name"];
                                                            $price = $row["product_price"];
                                                            $image = $row["product_image"];
                                                            $date = $row["date"];
                                                            $pid = $row["p_id"];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $a; ?></td>
                                                                <td><?php echo $name; ?></td>
                                                                <td><?php echo $price; ?></td>
                                                                <td><img src="img/<?php echo $image; ?>" style="width: 50px; height: 50px;"/></td>                                                        
                                                                <td> <?php echo date_format(date_create($date), " d M Y"); ?></td>

                                                                <td>                                                                       
                                                                    <a href='product.php?h=<?php echo base64_encode($p_id); ?>'>UPDATE</a>
                                                                </td> 
                                                                <td><a onclick="return confirm('press ok to delete testimony')" href="product.php?id=<?php echo $pid; ?>">DELETE</a></td>
                                                            </tr>
                                                            <?php
                                                            $a++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
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