<?php
session_start();
include '../includes/connection.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

if ($role != "admin") {
    header("location:login.php");
}

//removing content from home page
if (isset($_GET['h'])) {
    $tid = base64_decode($_GET['h']);
    $hide = mysqli_query($conn, "update blog set status='NO' where blog_id='$tid'");
    if ($hide) {
        echo "<script>alert('Content Hidden from home page successfully!'); window.location.href='blog_content.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}

//adding content to home page
if (isset($_GET['p'])) {
    $tids = base64_decode($_GET['p']);
    $hide = mysqli_query($conn, "update blog set status='YES' where blog_id='$tids'");
    if ($hide) {
        echo "<script>alert('Content posted on home page successfully!'); window.location.href='blog_content.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}

//Deleting content
if (isset($_GET['d'])) {
    $dids = base64_decode($_GET['d']);
    $hide = mysqli_query($conn, "delete from blog where blog_id='$dids'");
    if ($hide) {
        echo "<script>alert('Content deleted successfully!'); window.location.href='blog_content.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Blog Content</title>
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
                                    <h3 class="box-title">Blog Contents</h3>
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
                                                <th>TITLE</th>
                                                <th>CATEGORY</th>                                                  
                                                <th>DATE</th>                                                    
                                                <th>ACTION</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = mysqli_query($conn, "select * from blog");
                                            $posted_testimonies = mysqli_num_rows(mysqli_query($conn, "select * from blog where status='YES'"));
                                            $a = 1;
                                            while ($row = mysqli_fetch_array($result)) {
                                                $topic = $row["topic"];
                                                $type = $row["type"];
                                                $caption_image = $row["img"];
                                                $date = $row["date"];
                                                $status = $row["status"];
                                                $blog_id = $row["blog_id"];
                                                ?>
                                                <tr>
                                                    <td><?php echo $a; ?></td>
                                                    <td><?php echo $topic; ?></td>
                                                    <td><?php echo $type; ?></td>                                                                                                              
                                                    <td> <?php echo date_format(date_create($date), " d M Y H:i:s A"); ?></td>
                                                    <td>
                                                        <?php
                                                        if ($posted_testimonies < 6) {
                                                            ?>
                                                            <?php if ($status == "NO") { ?> 
                                                                <a href='blog_content.php?p=<?php echo base64_encode($blog_id); ?>'>POST</a>
                                                            <?php } else { ?>
                                                                <a href='blog_content.php?h=<?php echo base64_encode($blog_id); ?>'>HIDE</a>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <?php if ($status == "NO") { ?>
                                                                <input style="background-color:red;" class="btn" onclick="return alert('Maximum amount of testimonies posted on home page, please hide other testimonies and try again')" type="submit" readonly="" value="POST">
                                                            <?php } else { ?>
                                                                <a href='blog_content.php?h=<?php echo base64_encode($blog_id); ?>'>HIDE</a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>                                                       

                                                    </td> 
                                                    <td><a onclick="return confirm('press ok to delete content')" href="blog_content.php?d=<?php echo base64_encode($blog_id); ?>">DELETE</a> | 
                                                        <a href="edit_content.php?e=<?php echo base64_encode($blog_id); ?>">UPDATE</a>
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