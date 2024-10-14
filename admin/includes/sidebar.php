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
                    <li class="active treeview">
                            <a href="viewcustomer">
                                <i class="fa fa-share"></i> <span>View Customer's</span>
                            </a>
                        </li>                        
                        <li class="active treeview">
                            <a href="product">
                                <i class="fa fa-share"></i> <span>Create Product</span>
                            </a>
                        </li> 
                         <li class="active treeview">
                            <a href="charges">
                                <i class="fa fa-share"></i> <span>Create Charges</span>
                            </a>
                        </li> 
                        <li class="active treeview">
                            <a href="vieworder">
                                <i class="fa fa-share"></i> <span>View Order's</span>
                            </a>
                        </li>
                        <li class="active treeview">
                            <a href="orderHistory">
                                <i class="fa fa-share"></i> <span>Order History</span>
                            </a>
                        </li>
                        

               <!-- <li class="active treeview">
                    <a href="sms.php">
                        <i class="fa fa-share"></i> <span>Bulk SMS</span>
                    </a>
                </li>

                <li class="active treeview">
                    <a href="feedbacks.php">
                        <i class="fa fa-share"></i> <span>Feedback Message</span>
                    </a>
                </li>-->

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
          

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
