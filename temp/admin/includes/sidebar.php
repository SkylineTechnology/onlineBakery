<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="images/logo4.png" width="60" height="48" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <?php
                if ($role == "admin") {
                    ?> 
                    <p style="text-transform: uppercase;"><?php echo $role; ?></p>

                    <?php
                } else {
                    ?>                    
                    <p style="text-transform: uppercase;"><?php echo $role ?></p>
                    <?php
                }
                ?>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <a href="index.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            <?php
            if ($role == "admin") {
                ?> 
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span><b>Register</b></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class="active treeview">
                            <a href="regDept.php">
                                <i class="fa fa-share"></i> <span>Create Department</span>
                            </a>
                        </li>
                        <li class="active treeview">
                            <a href="regHod">
                                <i class="fa fa-share"></i> <span>Register HOD</span>
                            </a>
                        </li>
                        <li class="active treeview">
                            <a href="regmember.php">
                                <i class="fa fa-share"></i> <span>Register Member</span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span><b>View content</b></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class="active treeview">
                            <a href="viewHod.php">
                                <i class="fa fa-share"></i> <span>View HOD's</span>
                            </a>
                        </li>

                        <li class="active treeview">
                            <a href="viewmembers.php">
                                <i class="fa fa-share"></i> <span>View Members</span>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span><b>Multimedia content</b></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class="active treeview">
                            <a href="gallery.php">
                                <i class="fa fa-share"></i> <span>Photo Gallery</span>
                            </a>
                        </li>
                        <li class="active treeview">
                            <a href="project.php">
                                <i class="fa fa-share"></i> <span>Project Gallery</span>
                            </a>
                        </li>
                        <li class="active treeview">
                            <a href="media.php">
                                <i class="fa fa-share"></i> <span>Multimedia</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span><b>Create content</b></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class="active treeview">
                            <a href="blog.php">
                                <i class="fa fa-share"></i> <span>Create Blog</span>
                            </a>
                        </li> 
                        <li class="active treeview">
                            <a href="program.php">
                                <i class="fa fa-share"></i> <span>Create Programme</span>
                            </a>
                        </li>
                        <li class="active treeview">
                            <a href="blog_content.php">
                                <i class="fa fa-share"></i> <span>Blog Contents</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="active treeview">
                    <a href="testimony.php">
                        <i class="fa fa-share"></i> <span>Testimonies</span>
                    </a>
                </li>

                <li class="active treeview">
                    <a href="sms.php">
                        <i class="fa fa-share"></i> <span>Bulk SMS</span>
                    </a>
                </li>

                <li class="active treeview">
                    <a href="feedbacks.php">
                        <i class="fa fa-share"></i> <span>Feedback Message</span>
                    </a>
                </li>

                <li class="active treeview">
                    <a href="changepass.php">
                        <i class="fa fa-share"></i> <span>Change Password</span>
                    </a>
                </li>

                <li class="active treeview">
                    <a href="logout.php">
                        <i class="fa fa-share"></i> <span>Logout</span>
                    </a>
                </li>
                <?php
            } else {
                ?>
                <li class="active treeview">
                    <a href="register.php">
                        <i class="fa fa-share"></i> <span>Register Member</span>
                    </a>
                </li>
                <li class="active treeview">
                    <a href="view.php">
                        <i class="fa fa-share"></i> <span>View Members</span>
                    </a>
                </li>
                <li class="active treeview">
                    <a href="changepass.php">
                        <i class="fa fa-share"></i> <span>Change Password</span>
                    </a>
                </li>
                <li class="active treeview">
                    <a href="logout.php">
                        <i class="fa fa-share"></i> <span>Logout</span>
                    </a>
                </li> 

                <?php
            }
            ?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
