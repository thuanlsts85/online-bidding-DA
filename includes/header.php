        <div class="navbar-brand">
            <img src="../assets/img/logo.jpg" style="width:120px; height:120px" />
        </div>

        <?php if ($_SESSION['login']) {
        ?>
            <div class="right-div">
                <a href="../logout.php" class="btn btn-danger pull-right">LOGOUT</a>
            </div>
        <?php } ?>
 
<!-- LOGO HEADER END-->
<?php if ($_SESSION['login']) {
?>
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="topnav">

                        <a href="../product/bidding.php">BIDDING</a>

                        <a href="../product/product.php">SALE</a>

                        <div class="dropdown">
                            <a href="#" class="dropbtn">ACCOUNT</a>
                            <div class="dropdown-content">
                                <a href="../profile.php">My Profile</a>
                                <a href="../change-password.php">Change Password</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
<?php } else { ?>
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="topnav">
                            <a href="signup.php">SIGNUP</a>

                                <div class="dropdown">
                                    <a href="#" class="dropbtn">LOGIN</a>
                                    <div class="dropdown-content">
                                        <a href="adminLogin.php">Admin Login</a>
                                        <a href="index.php">User Login</a>
                                    </div>
                                </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php } ?>