<div class="navbar navbar-inverse set-radius-zero">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand">
                <img src="../assets/img/logo.jpg" style="width:120px; height:120px" />
            </div>

        </div>
        <?php if ($_SESSION['login']) {
        ?>
            <div class="right-div">
                <a href="../logout.php" class="btn btn-danger pull-right">LOGOUT</a>
            </div>
        <?php } ?>
    </div>
</div>
<!-- LOGO HEADER END-->
<?php if ($_SESSION['login']) {
?>
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right" style="display: flex; list-style: none;">
                            <li><a href="../product/bidding.php">BIDDING</a></li>

                            <li><a href="../product/product.php">SALE</a></li>

                            <li>
                                <div class="dropdown">
                                    <a href="#" class="dropbtn">ACCOUNT</a>
                                    <div class="dropdown-content">
                                        <a href="../profile.php">My Profile</a>
                                        <a href="../change-password.php">Change Password</a>
                                    </div>
                                </div>
                            </li>

                        </ul>
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
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right" style="display: flex; list-style: none;">

                            <li><a href="signup.php">Signup</a></li>

                            <li>
                                <div class="dropdown">
                                    <a href="#" class="dropbtn">Login</a>
                                    <div class="dropdown-content">
                                        <a href="adminLogin.php">Admin Login</a>
                                        <a href="index.php">User Login</a>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php } ?>