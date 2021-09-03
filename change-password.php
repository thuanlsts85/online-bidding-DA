<?php
session_start();
error_reporting(0);
include('includes/data_connect.php');
if (isset($_POST['change'])) {

    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $id = $_POST['id'];

    $newpassword = md5($_POST['newpassword']);

    $sql = "SELECT email FROM customer WHERE email= :email AND phone= :phone AND id= :id";
    $query = $pdo->prepare($sql);

    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);


    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($query->rowCount() > 0) {
        $con = "UPDATE customer SET password= :newpassword WHERE email= :email AND phone= :phone AND id= :id";
        $chngpwd1 = $pdo->prepare($con);

        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':phone', $phone, PDO::PARAM_STR);
        $chngpwd1->bindParam(':id', $id, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);

        $chngpwd1->execute();

        echo "<script>alert('Your Password succesfully changed');</script>";
        echo "<script type='text/javascript'> document.location ='index.php'; </script>";
    } else {
        echo "<script>alert('Email, Phone number or ID is invalid');</script>";
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
    <title>Online Auction Management System | Password Recovery </title>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match  !!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>

</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">User Password Recovery</h4>
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
                            <form role="form" name="chngpwd" method="post" onSubmit="return valid();">

                                <div class="form-group">
                                    <label>Enter Your Identity Nunmber</label>
                                    <input class="form-control" type="text" name="id" required autocomplete="off" />
                                </div>

                                <div class="form-group">
                                    <label>Enter Registered Email</label>
                                    <input class="form-control" type="email" name="email" required autocomplete="off" />
                                </div>

                                <div class="form-group">
                                    <label>Enter Registered Phone Nunmber</label>
                                    <input class="form-control" type="text" name="phone" required autocomplete="off" />
                                </div>

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control" type="password" name="newpassword" required autocomplete="off" />
                                </div>

                                <div class="form-group">
                                    <label>ConfirmPassword</label>
                                    <input class="form-control" type="password" name="confirmpassword" required autocomplete="off" />
                                </div>

                                <button type="submit" name="change" class="btn btn-info">Change Password</button> | <a href="index.php">Login</a>
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

</body>

</html>