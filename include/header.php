
<!-- script-for sticky-nav -->
<script>
    $(document).ready(function () {
        var navoffeset = $(".agileits_header").offset().top;
        $(window).scroll(function () {
            var scrollpos = $(window).scrollTop();
            if (scrollpos >= navoffeset) {
                $(".agileits_header").addClass("fixed");
            } else {
                $(".agileits_header").removeClass("fixed");
            }
        });

    });
</script>
<!-- //script-for sticky-nav -->
<div class="logo_products">
    <div class="container" style="width: 90%;">
        <div class="w3ls_logo_products_left">
            <h1><a href="index.php"> Online Bakery Distribution<span>System</span></a></h1>
        </div>
        <div class="w3ls_logo_products_left1">
            <ul class="special_items" style=" font-weight: bold; font-size: 35px;">
                <li><a href="index">Home</a><i>|</i></li>
                <li><a href="about">About Us</a><i>|</i></li>
                <li><a href="contact">Contact Us</a><i>|</i></li>
                <?php
                if (isset($_SESSION['username'])) {
                    ?>
                    <li><a href="profile">Profile</a><i>|</i></li> 
                    <li><a href="my_order">My Orders</a><i>|</i></li> 
                    <li><a href="changepass">Change Password</a><i>|</i></li>
                    <?php
                } else {
                    ?>      

                    <?php
                }
                ?>

                
                <li><a href="services">Services</a></li>              

            </ul>
        </div>
        <div class="w3ls_logo_products_left1" style="float:right;">     <?php
            if (isset($_SESSION['username'])) {
                ?>
                <a href="Logout" class="btn btn-danger">Logout</a> 
                <?php
            } else {
                ?>      
                <a href="login" class="btn btn-success">Login</a>
                <a href="registration" class="btn btn-success">Sign Up</a>
                <?php
            }
            ?>
        </div>
        <div class="clearfix"> </div>
    </div>
</div>