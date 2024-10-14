<?php
session_start();
include '../includes/connection.php';
include 'includes/functions.php';
$role = isset($_SESSION['urole']) ? $_SESSION['urole'] : "";
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";

//Hiding media from main page
if (isset($_GET['h'])) {
    $gid = base64_decode($_GET['h']);
    $hide = mysqli_query($conn, "update media set status='NO' where media_id='$gid'");
    if ($hide) {
        echo "<script>alert('file Hidden successfully!'); window.location.href='media.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}

//adding media to main  page
if (isset($_GET['p'])) {
    $gids = base64_decode($_GET['p']);
    $hide = mysqli_query($conn, "update media set status='YES' where media_id='$gids'");
    if ($hide) {
        echo "<script>alert('File posted on home page successfully!'); window.location.href='media.php'</script>";
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}

//Deleting media
if (isset($_GET['d'])) {
    $dids = base64_decode($_GET['d']);
    $med_url = mysqli_fetch_array(mysqli_query($conn, "select * from media where media_id='$dids'"));
    $delete = mysqli_query($conn, "delete from media where media_id='$dids'");
    if ($delete) {
        $media_url = $med_url["url"];
        $media_type = $med_url["type"];
        if ($media_type == "audio") {
            unlink("media/audio/" . $media_url);
            echo "<script>alert('Audio File deleted successfully!'); window.location.href='media.php' </script>";
        } elseif ($media_type == "video") {
            unlink("media/video/" . $media_url);
            echo "<script>alert('Video File deleted successfully!'); window.location.href='media.php' </script>";
        }
    } else {
        echo "<script>alert('Operations Failed, Please try again after some minutes!')</script>";
    }
}



if ($role != "admin") {
    header("location:login.php");
}

if (isset($_POST["upload"])) {
    $desc = $_POST["desc"];
    $preacher = $_POST["artist"];
    $date = date("Y-m-d H:i:s");
    $mid = "MEDIA-" . date('ismymd');
    $status = "NO";
    $title = $_POST["title"];


    // media
    $media_name = isset($_FILES['media']['name']) ? $_FILES['media']['name'] : "";
    if ($media_name != "") {
        $media_ext = strtolower(pathinfo($media_name, PATHINFO_EXTENSION));
        $audio_ext_array = array("mp3", "wma");
        $video_ext_array = array("mp4", "3gp", "3gpp");

        if ($media_ext == "mp4" || $media_ext == "3gp" || $media_ext == "3gpp") {
            if (in_array($media_ext, $video_ext_array)) {
                $vid_url = 'HFMIFilevid' . '_' . date('mdYHis.') . $media_ext;
                $move_video = move_uploaded_file($_FILES['media']['tmp_name'], "media/video/" . $vid_url); // upload_video($_FILES['media']['name'], $media_ext);
                if ($move_video == TRUE) {
                    $mtype = "video";
                    $insert_video = mysqli_query($conn, "insert into media values ('$mid','$title','$preacher','$vid_url','$mtype','$desc','$status','$date')");
                    if ($insert_video) {
                        echo "<script>alert('Video File Added Successfully!'); window.location.href='media.php';</script>";
                    } else {
                        echo "<script>alert('Operations Failed, Media could not be uploaded, try again!')</script>";
                    }
                } else {
                    echo "<script>alert('Video file Cant be uploaded, please try again!')</script>";
                }
            } else {
                echo "<script>alert('Wrong file format, media could not be uploaded, please try again!')</script>";
            }
        } elseif ($media_ext == "mp3" || $media_ext == "wma") {
            if (in_array($media_ext, $audio_ext_array)) {
                $aud_url = 'AUDIO' . '-' . date('mdYHis.'). $media_ext;
                $move_audio = move_uploaded_file($_FILES['media']['tmp_name'], "media/audio/" . $aud_url); // upload_video($_FILES['media']['name'], $media_ext);
                if ($move_audio == TRUE) {
                    $atype = "audio";
                    $insert_audio = mysqli_query($conn, "insert into media values ('$mid','$title','$preacher','$aud_url','$atype','$desc','$status','$date')");
                    if ($insert_audio) {
                        echo "<script>alert('Audio File Added Successfully!'); window.location.href='media.php';</script>";
                    } else {
                        echo "<script>alert('Operations Failed, Media could not be uploaded, try again!')</script>";
                    }
                } else {
                    echo "<script>alert('Audio file Cant be uploaded, please try again!')</script>";
                }
            } else {
                echo "<script>alert('Wrong file format, media could not be uploaded, please try again!')</script>";
            }
        }
    } else {
        echo "<script>alert('no media selected, please try again!')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | Media Upload</title>
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
                        Multimedia
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
                                    <h3 class="box-title">Multimedia Upload </h3>
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
                                        <li ><a href="#revenue-chart" data-toggle="tab">UPLOAD MEDIA FILE</a></li>
                                        <li class="active"><a href="#sales-chart" data-toggle="tab"> MEDIA FILES</a></li>

                                    </ul>
                                    <div class="tab-content no-padding">
                                        <!-- Morris chart - Sales -->
                                        <div class="chart tab-pane " id="revenue-chart" style="position: relative; height: 100%;">
                                            <div class="box-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div class="row  box-body">                                        
                                                        <div class="col-xs-8"> 
                                                            Media Title:
                                                            <div class="form-group has-feedback">
                                                                <input required="" name="title" type="text" class="form-control" placeholder="Media Title "/>
                                                                <span class="glyphicon glyphicon-video form-control-feedback"></span>
                                                            </div> 
                                                        </div>

                                                        <div class="col-xs-4">
                                                            Media Artist (Preacher Name):
                                                            <div class="form-group has-feedback">
                                                                <input required="" name="artist" type="text" class="form-control" placeholder="Media Artist "/>
                                                                <span class="glyphicon glyphicon-video form-control-feedback"></span>
                                                            </div>  
                                                        </div>
                                                    </div>

                                                    <div class="row  box-body"> 

                                                        <div class="col-xs-8"> 
                                                            Media Description:
                                                            <div class="form-group">
                                                                <textarea required="" name="desc" class="form-control" rows="3" placeholder="Enter media description..."></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-4">
                                                            File: <span style=" color:red;">(FILE FORMATS: mp3, mp4, 3gp, 3gpp, .wma only)</span>
                                                            <div class="form-group has-feedback">
                                                                <input required="" name="media" accept=".mp3, .mp4, .3gp, .3gpp, .wma" type="file" class="form-control" placeholder="image "/>
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
                                                            <button type="submit" name="upload" class="btn btn-primary btn-block btn-flat">Upload Media</button>
                                                        </div><!-- /.col -->
                                                    </div>
                                                </form> 

                                            </div>

                                        </div>

                                        <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 100%; overflow-x: scroll;">
                                            <div class="box-body">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Uploaded Media Files </h3>
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
                                                            <th>TITLE</th>
                                                            <th>ARTIST(Preacher)</th>
                                                            <th>TYPE</th>
                                                            <th>DESCRIPTION</th>
                                                            <th>UPLOADED DATE</th>                                                    
                                                            <th>ACTION</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $result = mysqli_query($conn, "select * from MEDIA order by date desc");
                                                        $posted_media = mysqli_num_rows(mysqli_query($conn, "select * from media where status='YES'"));
                                                        $a = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $file = $row["url"];
                                                            $desc = $row["description"];
                                                            $date = $row["date"];
                                                            $status = $row["status"];
                                                            $type = $row["type"];
                                                            $artist = $row["artist"];
                                                            $title = $row["title"];
                                                            $file_id = $row["media_id"];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $a; ?></td>
                                                                <td><?php echo $title; ?></td>
                                                                <td><?php echo $artist; ?></td>
                                                                <td><?php echo $type; ?></td>
                                                                <td><?php echo $desc; ?></td>
                                                                <td> <?php echo date_format(date_create($date), " d M Y H:i:s A"); ?></td>

                                                                <td>
                                                                    <?php
                                                                    if ($posted_media < 10) {
                                                                        ?>
                                                                        <?php if ($status == "NO") { ?> 
                                                                            <a href='media.php?p=<?php echo base64_encode($file_id); ?>'>POST</a>
                                                                        <?php } else { ?>
                                                                            <a href='media.php?h=<?php echo base64_encode($file_id); ?>'>HIDE</a>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <?php if ($status == "NO") { ?>
                                                                            <input style="background-color:red;" class="btn" onclick="return alert('Maximum number of media posted, please hide other media files and try again')" type="submit" readonly="" value="POST">
                                                                        <?php } else { ?>
                                                                            <a href='media.php?h=<?php echo base64_encode($file_id); ?>'>HIDE</a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>                                                       

                                                                </td> 
                                                                <td><a onclick="return confirm('Press ok to media delete file')" href="media.php?d=<?php echo base64_encode($file_id); ?>">DELETE</a></td>
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