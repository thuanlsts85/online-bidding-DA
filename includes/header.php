 <!-- LOGO HEADER END-->
 <!-- header for signed in user -->
 <?php if ($_SESSION['login']) {
    ?>
     <section class="menu-section">
         <div class="container">
             <div class="row ">

                 <div class="col-md-3">
                     <div class="navbar-brand">
                         <img src="../assets/img/logo.jpg" style="width:80px; height:80px" />
                     </div>
                 </div>

                 <div class="col-md-9">
                     <div class="topnav">

                         <div class="right-div">
                             <a href="../logout.php" class="btn btn-danger pull-right">LOGOUT</a>
                         </div>

                         <div class="left-div">
                             <a href="../product/bidding.php">BIDDING</a>
                         </div>

                         <div class="left-div">
                             <a href="../product/product.php">SELL</a>
                         </div>

                         <button class="dropdown">
                             <div class="left-div">
                                 <a href="#" class="dropbtn">ACCOUNT</a>
                             </div>
                             <div class="dropdown-content account">
                                 <a href="../change-password.php">Change Password</a>
                                 <a href="../profile.php">My Profile</a>
                             </div>
                         </button>

                     </div>
                 </div>

             </div>
         </div>
     </section>
 <?php } else { ?>
    <!-- header for none sign in user -->
     <section class="menu-section">
         <div class="container">
             <div class="row ">

                 <div class="col-md-3">
                     <div class="navbar-brand">
                         <img src="../assets/img/logo.jpg" style="width:80px; height:80px" />
                     </div>
                 </div>

                 <div class="col-md-9">
                     <div class="topnav">
                         <div class="left-div">
                             <a href="signup.php">SIGNUP</a>
                         </div>

                         <button class="dropdown">
                             <div class="left-div">
                                 <a href="#" class="dropbtn">LOGIN</a>
                             </div>
                             <div class="dropdown-content">
                                 <a href="adminLogin.php">Admin Login</a>
                                 <a href="index.php">User Login</a>
                             </div>
                         </button>
                     </div>
                 </div>

             </div>
         </div>
     </section>

 <?php } ?>