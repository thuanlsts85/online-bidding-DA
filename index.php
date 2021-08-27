<?php
session_start();
error_reporting(0);
include('includes/data_connect.php');
if ($_SESSION['login'] != '') {
  $_SESSION['login'] = '';
}
if (isset($_POST['login'])) {

  //code for captach verification
  // if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
  //         echo "<script>alert('Incorrect verification code');</script>" ;
  //     } 
  //         else {


  //ensure fields are not empty
  $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
  $password = !empty(md5($_POST['password'])) ? trim(md5($_POST['password'])) : null;

  //Retrieve the user account information for the given email + password.
  $sql = "SELECT email, password, id, status FROM customer WHERE email= :email AND password= :password";
  $query = $pdo->prepare($sql);

  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);

  $query->execute();

  $result = $query->fetch(PDO::FETCH_ASSOC);

  if ($result === false) {
    echo '<script>alert("invalid email or password")</script>';
  } else {

    $_SESSION['id'] = $result['id'];
    if ($result['status'] == 1) {
      $_SESSION['login'] = $email;
      echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
      exit;
    } else {
      // status != 1, account was locked by admin
      echo "<script>alert('Your Account Has been blocked .Please contact admin');</script>";
    }
  }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Online Bidding System</title>
  <!-- BOOTSTRAP CORE STYLE  -->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!-- FONT AWESOME STYLE  -->
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLE  -->
  <link href="assets/css/style.css" rel="stylesheet" />
  <!-- GOOGLE FONT -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<body>
  <!------MENU SECTION START-->
  <?php include('includes/header.php'); ?>
  <!-- MENU SECTION END-->
  <div class="content-wrapper">
    <div class="container">
      <div class="row pad-botm">
        <div class="col-md-12">
          <h4 class="header-line">USER LOGIN FORM</h4>
        </div>
      </div>

      <!--LOGIN PANEL START-->
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <div class="panel panel-info">
            <div class="panel-heading">
              LOGIN FORM
            </div>
            <div class="panel-body">
              <form role="form" method="post">

                <div class="form-group">
                  <label>Email</label>
                  <input class="form-control" type="email" name="email" required autocomplete="off" />
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input class="form-control" type="password" name="password" required autocomplete="off" />
                  <p class="help-block"><a href="forgot-password.php">Forgot Password</a></p>
                </div>

                <!-- <div class="form-group">
<label>Verification code : </label>
<input type="text" class="form-control1"  name="vercode" maxlength="5" autocomplete="off" required  style="height:25px;" />&nbsp;<img src="captcha.php">
</div>  -->

                <button type="submit" name="login" class="btn btn-info">LOGIN </button> | <a href="signup.php">Not Register Yet</a>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!---LOGIN PABNEL END-->


    </div>
  </div>
  <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php'); ?>
  <!-- FOOTER SECTION END-->
  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS  -->
  <script src="assets/js/bootstrap.js"></script>
  <!-- CUSTOM SCRIPTS  -->
  <script src="assets/js/custom.js"></script>

</body>

</html>