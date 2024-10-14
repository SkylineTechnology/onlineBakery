<?php
session_start();
include '../includes/connection.php';
include 'includes/functions.php';

$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

if ($role != "admin") {
    header("location:login.php");
}
$b_id = base64_decode($_GET['e']);
if (isset($_POST["update"])) {
    $title = $_POST["title"];
    $msg = $_POST["msg"];
    $type = $_POST["cat"];
    $author = $_POST["author"];

    $insert_art = mysqli_query($conn, "update blog set topic='$title', author='$author', message='$msg', type='$type' where blog_id='$b_id'");
    if ($insert_art) {
        echo "<script>alert(' Content Updated Successfully!')</script>";
    } else {
        echo "<script>alert('Operations Failed, Please Try after some minutes!')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Update Blog Content</title>
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
                        Update Blog Content
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
                                    <span class="info-box-text">Blog Content</span>
                                    <?php
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
                                    <h3 class="box-title">Update Blog Content</h3>
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
                                //$row=mysqli_fetch_array(mysqli_query($conn,"select * from blog where blog_id='$b_id'")) or die(mysqli_query($conn));
                                $row = mysqli_fetch_array(mysqli_query($conn, "select * from blog where blog_id='$b_id'")) or die(mysqli_error($conn));
                                $blog_title = $row["topic"];
                                $blog_msg = $row["message"];
                                $blog_img = $row["img"];
                                $blog_author = $row["author"];
                                $blog_category = $row["type"];
                                $blog_date = $row["date"];
                                ?>
                                <div class="box-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="row  box-body">
                                            <div class="col-xs-12"> 
                                                <span style="color:red;">*</span>Title
                                                <div class="form-group has-feedback">
                                                    <input required="" name="title" value="<?php echo $blog_title; ?>" type="text" class="form-control" placeholder="Title, Topic "/>
                                                    <span class="glyphicon glyphicon-book form-control-feedback"></span>
                                                </div>
                                            </div>  

                                            <div class="col-xs-12"> 
                                                <span style="color:red;">*</span>Author
                                                <div class="form-group has-feedback">
                                                    <input required="" name="author" value="<?php echo $blog_author; ?>" type="text" class="form-control" placeholder="Author "/>
                                                    <span class="glyphicon glyphicon-book form-control-feedback"></span>
                                                </div>
                                            </div>  
                                        </div>    

                                        <div class="row  box-body">

                                            <div class="col-xs-2"> 
                                                <span style="color:red;">*</span>Caption Image<br>
                                                <img width="170" height="150" src="media/blog_images/<?php echo $blog_img; ?>">

                                            </div>

                                            <div class="col-xs-10"> 
                                                <span style="color:red;">*</span>Content Category
                                                <div class="form-group has-feedback">
                                                    <div class="form-group">
                                                        <select name="cat" required="" class="form-control">
                                                            <option>Select Content Category</option>
                                                            <option <?php
                                                            if ($blog_category == "article") {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                                            ?> value="article">Article</option>
                                                            <option <?php
                                                            if ($blog_category == "event") {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                                            ?> value="event">Events</option>
                                                            <option <?php
                                                            if ($blog_category == "news") {
                                                                echo "selected='selected'";
                                                            } else {
                                                                
                                                            }
                                                            ?> value="news">News</option>                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>   

                                        <div class="row  box-body"> 
                                            <div class="col-xs-12"> 
                                                <span style="color:red;">*</span>Content
                                                <div class="form-group">
                                                    <textarea class="form-control" required id="editor" name="msg" rows="3"  placeholder="contents here"><?php echo $blog_msg; ?></textarea>
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
                                                <button type="submit" name="update" class="btn btn-primary btn-block btn-flat">Update Content</button>
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