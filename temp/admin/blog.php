<?php
session_start();
include '../includes/connection.php';
include 'includes/functions.php';

$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

if ($role != "admin") {
    header("location:login.php");
}

if (isset($_POST["add"])) {
    $title = addslashes(htmlentities($_POST["title"]));
    $msg = addslashes(htmlentities($_POST["msg"]));
    $type = $_POST["cat"];
    $author = $_POST["author"];
    $date = date("Y-m-d H:i:s");
    $blogid = "BLOG-" . date('ismymd');
    $status = "NO";

    // Images
    $pic_name = isset($_FILES['pic']['name']) ? $_FILES['pic']['name'] : "";

    if ($pic_name != "") {
        $screen_img1_ext = pathinfo($pic_name, PATHINFO_EXTENSION);
        $img_url = upload_art_img($_FILES['pic']['tmp_name'], $screen_img1_ext, 1);
        if ($img_url != "") {
            $insert_art = mysqli_query($conn, "insert into blog values ('$blogid','$title','$img_url','$author','$msg','$date','$type','$status')") or die(mysqli_error($conn));
            if ($insert_art) {
                echo "<script>alert(' Content Created Successfully!')</script>";
            } else {
                echo "<script>alert('Operations Failed, Please Try after some minutes!')</script>";
            }
        } else {
            echo "<script>alert('Operations Failed, Image could not be uploaded!')</script>";
        }
    } else {
        echo "<script>alert('Operations Failed, Image could not be uploaded!')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Create Blog</title>
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
                        Create Blog
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
                                <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-book"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Blog Contents</span>
                                    <?php
                                    /** $interval="2 months";
                                      $object=date("Y-m-d");
                                      $new_members_date_range= date_sub($object, $interval);
                                      $new_members = mysqli_num_rows(mysqli_query($conn, "select * from members where date > '$new_members_date_range'"));

                                     * */
                                    $art_num = mysqli_num_rows(mysqli_query($conn, "select * from blog"));
                                    ?>

                                    <span class="info-box-number"><?php echo $art_num; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->



                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Create Blog Article</h3>
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
                                <div class="box-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="row  box-body">
                                            <div class="col-xs-12"> 
                                                <span style="color:red;">*</span>Title
                                                <div class="form-group has-feedback">
                                                    <input required="" name="title" type="text" class="form-control" placeholder="Title, Topic "/>
                                                    <span class="glyphicon glyphicon-book form-control-feedback"></span>
                                                </div>
                                            </div> 

                                            <div class="col-xs-12"> 
                                                <span style="color:red;">*</span>Author
                                                <div class="form-group has-feedback">
                                                    <input required="" name="author" type="text" class="form-control" placeholder="Author "/>
                                                    <span class="glyphicon glyphicon-book form-control-feedback"></span>
                                                </div>
                                            </div> 
                                        </div>    

                                        <div class="row  box-body">

                                            <div class="col-xs-6"> 
                                                <span style="color:red;">*</span>Caption Image
                                                <div class="form-group has-feedback">
                                                    <input name="pic" accept=".jpg, .jpeg, .png, .jif" type="file" class="form-control" placeholder="image "/>
                                                    <span class="glyphicon glyphicon-camera form-control-feedback"></span>
                                                </div>   
                                            </div>

                                            <div class="col-xs-6"> 
                                                <span style="color:red;">*</span>Content Category
                                                <div class="form-group has-feedback">
                                                    <div class="form-group">
                                                        <select name="cat" required="" class="form-control">
                                                            <option>Select Content Category</option>
                                                            <option value="article">Article</option>
                                                            <option value="event">Events</option>
                                                            <option value="news">News</option>                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>   

                                        <div class="row  box-body"> 
                                            <div class="col-xs-12"> 
                                                <span style="color:red;">*</span>Content
                                                <div class="form-group">
                                                    <textarea class="form-control" required id="editor" name="msg" rows="3"  placeholder="contents here">Enter article, News or Event</textarea>
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
                                                <button type="submit" name="add" class="btn btn-primary btn-block btn-flat">Create</button>
                                            </div><!-- /.col -->
                                        </div>
                                    </form> 
                                    <script>
                                        initSample();
                                    </script>

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
        <script src="plugins/jQuery/jQueryk-2.1.3.min.js"></script>
        <script src="plugins/jQuery/js/jquery.min.js"></script>

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