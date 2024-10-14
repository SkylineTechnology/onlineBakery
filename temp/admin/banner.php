<?php
session_start();
include '../includes/connection.php';
include 'includes/functions.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

//Hiding banner from main page
if (isset($_GET['h'])) {
    $gid = base64_decode($_GET['h']);
    $hide = mysqli_query($conn, "update banner set status='NO' where bid='$gid'");
    if ($hide) {
        echo "<script>alert('file Hidden successfully!'); window.location.href='banner.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}

//adding banner to main  page
if (isset($_GET['p'])) {
    $gids = base64_decode($_GET['p']);
    $hide = mysqli_query($conn, "update banner set status='YES' where bid='$gids'");
    if ($hide) {
        echo "<script>alert('File posted on home page successfully!'); window.location.href='banner.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}

//Deleting media
if (isset($_GET['d'])) {
    $dids = base64_decode($_GET['d']);
    $med_url = mysqli_fetch_array(mysqli_query($conn, "select * from banner where bid='$dids'"));
    $delete = mysqli_query($conn, "delete from banner where bid='$dids'");
    if ($delete) {
        echo "<script>alert('Banner deleted successfully'); window.location.href='banner.php';</script>";
        $banner_url = $med_url["img_url"];
        unlink("media/banner/" . $banner_url);
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!'); window.location.href='banner.php';</script>";
    }
}



if ($role != "admin") {
    header("location:login.php");
}

if (isset($_POST["upload"])) {
    $subtext = $_POST["stitle"];
    $maintext = $_POST["btitle"];
    $date = date("Y-m-d H:i:s");
    $status = "NO";
    $link = $_POST["link"];


    // banner
    $image_name = isset($_FILES['banner']['name']) ? $_FILES['banner']['name'] : "";
    if ($image_name != "") {
        $img_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $ext_array = array("jpg", "jpeg", "gif", "png");


        if (in_array($img_ext, $ext_array)) {
            $banner_url = 'banner' . '-' . date('mdYHis.') . $img_ext;
            $move_banner = move_uploaded_file($_FILES['banner']['tmp_name'], "media/banner/" . $banner_url); 
            if ($move_banner == TRUE) {               
                $insert_banner = mysqli_query($conn, "insert into banner values ('','$subtext','$maintext','$banner_url','$link','$status','$date')");
                if ($insert_banner) {
                    echo "<script>alert('Banner Added Successfully!'); </script>";
                } else {
                    echo "<script>alert('Operations Failed, Banner could not be uploaded, try again!')</script>";
                }
            } else {
                echo "<script>alert('image file Cant be uploaded, please try again!')</script>";
            }
        } else {
            echo "<script>alert('Wrong file format, media could not be uploaded, please try again!')</script>";
        }
    } else {
        echo "<script>alert('no image selected, please try again!')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Banner Upload</title>
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
                        Banner
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
                                    $num = mysqli_num_rows(mysqli_query($conn, "select * from banner"));
                                    ?>
                                    <span class="info-box-text">Banner Images</span>
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
                                <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-film"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Media Files</span>
                                    <?php
                                    $media_num = mysqli_num_rows(mysqli_query($conn, "select * from media"));
                                    ?>

                                    <span class="info-box-number"><?php echo $media_num; ?></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->



                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Banner Upload </h3>                                   
                                </div><!-- /.box-header -->

                                <div class="nav-tabs-custom">
                                    <!-- Tabs within a box -->
                                    <ul class="nav nav-tabs pull-right">
                                        <li ><a href="#revenue-chart" data-toggle="tab">UPLOAD BANNER PHOTOS</a></li>
                                        <li class="active"><a href="#sales-chart" data-toggle="tab"> BANNER PHOTOS</a></li>

                                    </ul>
                                    <div class="tab-content no-padding">
                                        <!-- Morris chart - Sales -->
                                        <div class="chart tab-pane " id="revenue-chart" style="position: relative; height: 100%;">
                                            <div class="box-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div class="row  box-body">                                        
                                                        <div class="col-xs-6"> 
                                                            Bolder Title:
                                                            <div class="form-group has-feedback">
                                                                <input required="" name="btitle" type="text" class="form-control" placeholder="Bolder Text "/>
                                                                <span class="glyphicon glyphicon-video form-control-feedback"></span>
                                                            </div> 
                                                        </div>

                                                        <div class="col-xs-6"> 
                                                            Smaller Title:
                                                            <div class="form-group has-feedback">
                                                                <input required="" name="stitle" type="text" class="form-control" placeholder="Smaller Text"/>
                                                                <span class="glyphicon glyphicon-video form-control-feedback"></span>
                                                            </div> 
                                                        </div>
                                                    </div>

                                                    <div class="row  box-body"> 

                                                        <div class="col-xs-8"> 
                                                            URL link <span style=" color:red;">(Optional)</span>:
                                                            <div class="form-group has-feedback">
                                                                <input name="link" type="text" class="form-control" placeholder="URL link "/>
                                                                <span class="glyphicon glyphicon-video form-control-feedback"></span>
                                                            </div> 
                                                        </div>

                                                        <div class="col-xs-4">
                                                            File: <span style=" color:red;">(FILE FORMATS: .jpg, .jpeg, .png, .gif only)</span>
                                                            <div class="form-group has-feedback">
                                                                <input required="" name="banner" accept=".jpg, .jpeg, .png, .gif" type="file" class="form-control" placeholder="image "/>
                                                                <span class="glyphicon glyphicon-video form-control-feedback"></span>
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
                                                            <button type="submit" name="upload" class="btn btn-primary btn-block btn-flat">Add Banner</button>
                                                        </div><!-- /.col -->
                                                    </div>
                                                </form> 

                                            </div>

                                        </div>

                                        <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 100%;">
                                            <div class="box-body">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Uploaded Banner Images </h3>                                               
                                                </div><!-- /.box-header -->
                                                <table id="example1" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>MAIN TEXT</th>
                                                            <th>SUBTEXT</th>
                                                            <th>IMAGE</th>                                                            
                                                            <th>UPLOADED DATE</th>                                                    
                                                            <th>ACTION</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $result = mysqli_query($conn, "select * from banner order by date desc");
                                                        $posted_media = mysqli_num_rows(mysqli_query($conn, "select * from banner where status='YES'"));
                                                        $a = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $file = $row["img_url"];
                                                            $subtext = $row["subtext"];
                                                            $date = $row["date"];
                                                            $status = $row["status"];
                                                            $maintext = $row["maintext"];
                                                            $link = $row["link"];
                                                            $banner_id = $row["bid"];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $a; ?></td>
                                                                <td><?php echo $maintext; ?></td>
                                                                <td><?php echo $subtext; ?></td>
                                                                <td> <a title="click to view full image" href="media/banner/<?php echo $file; ?>" target="blank"><img src="media/banner/<?php echo $file; ?>" width="90" height="70" ></a></td>
                                                                <td> <?php echo date_format(date_create($date), " d M Y H:i:s A"); ?></td>

                                                                <td>
                                                                    <?php
                                                                    if ($posted_media < 5) {
                                                                        ?>
                                                                        <?php if ($status == "NO") { ?> 
                                                                            <a href='banner.php?p=<?php echo base64_encode($banner_id); ?>'>POST</a>
                                                                        <?php } else { ?>
                                                                            <a href='banner.php?h=<?php echo base64_encode($banner_id); ?>'>HIDE</a>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <?php if ($status == "NO") { ?>
                                                                            <input style="background-color:red;" class="btn" onclick="return alert('Maximum number of banner posted, please hide other banner images and try again')" type="submit" readonly="" value="POST">
                                                                        <?php } else { ?>
                                                                            <a href='banner.php?h=<?php echo base64_encode($banner_id); ?>'>HIDE</a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>                                                       

                                                                </td> 
                                                                <td><a onclick="return confirm('Press ok to banner delete file')" href="banner.php?d=<?php echo base64_encode($banner_id); ?>">DELETE</a></td>
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