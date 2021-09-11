<?php
session_start();
include('includes/data_connect.php');
error_reporting(0);
if (isset($_POST['signup'])) {

    try {
        // store image location
        $target = "assets/img/" . basename($_FILES['img']['name']);

        // Get data from the input form
        $id = $_POST['id'];;
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $phone = $_POST['phone'];
        $balance = 0;
        $country = $_POST['country'];
        $branch_id = $_POST['branch_id'];
        $address = $_POST['address'];
        $img = $_FILES['img']['name'];
        $email = $_POST['email'];
        // hash pwd with md5
        $password = md5($_POST['password']);
        $status = 1;

        // add new customer to db
        $sql = "INSERT INTO customer (`id`, `Fname`, `Lname`, `password`, `email`, `phone`, `balance`, `country`, `branch_id`, `address`, `img`, `status`) 
                        VALUES(:id,:Fname,:Lname,:password,:email,:phone,:balance,:country,:branch_id,:address,:img,:status)";
        $query = $pdo->prepare($sql);

        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':Fname', $Fname, PDO::PARAM_STR);
        $query->bindParam(':Lname', $Lname, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':balance', $balance, PDO::PARAM_INT);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':branch_id', $branch_id, PDO::PARAM_INT);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':img', $img, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);

        $query->execute();

        //move img file to selected folder
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            echo '<script>alert("User account created.")</script>';
            echo "<script type='text/javascript'> document.location ='index.php'; </script>";
        } else {
            echo '<script>alert("An error occurred")</script>';
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        echo '<script type="text/javascript">alert("' . $error . '");</script>';
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

    <title>Online Auction Management System | Customer Signup</title>
    <!-- CUSTOM STYLE  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script type="text/javascript">
        function valid() {
            // check pwd and confirm pwd matching
            if (document.signup.password.value != document.signup.confirmpassword.value) {
                alert("Password and Confirm Password do not match  !!");
                document.signup.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    <script>
        //set check existed email function
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check-email.php",
                data: 'email=' + $("#email").val(),
                type: "POST",
                success: function(data) {
                    $("#user-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
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
                    <!-- create customer signup form -->
                    <h4 class="header-line">User Signup Form</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <form name="signup" method="post" enctype="multipart/form-data" onSubmit="return valid();">

                                <div class="form-group">
                                    <label>Identity number :</label>
                                    <input class="form-control" type="text" name="id" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Enter First Name</label>
                                    <input class="form-control" type="text" name="Fname" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Enter Last Name</label>
                                    <input class="form-control" type="text" name="Lname" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Phone Number :</label>
                                    <input class="form-control" type="text" name="phone" maxlength="10" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Enter Email</label>
                                    <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" autocomplete="off" required />
                                    <span id="user-availability-status" style="font-size:12px;"></span>
                                </div>

                                <!-- <div class="form-group">
                                    <label>Balance :</label>
                                    <input class="form-control" type="number" name="balance" autocomplete="off" required />
                                </div> -->

                                <div class="form-group">
                                    <label>Enter Address</label>
                                    <input class="form-control" type="text" name="address" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>City :</label>
                                    <div>
                                        <label class="radio-inline"><input type="radio" name="branch_id" value=1>Ho Chi Minh</label>
                                        <label class="radio-inline"><input type="radio" name="branch_id" value=2>Da Nang</label>
                                        <label class="radio-inline"><input type="radio" name="branch_id" value=3>Ha Noi</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Country :</label>
                                    <div>
                                        <label class="radio-inline"><input type="radio" name="country" value="Vietnam">Vietnam</label>
                                        <label class="radio-inline"><input type="radio" name="country" value="Others">Others</label>
                                    </div>

                                    <div class="form-group">
                                        <label>Profile Image</label>
                                        <input class="form-control" type="file" name="img" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Enter Password</label>
                                        <input class="form-control" type="password" name="password" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password </label>
                                        <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required />
                                    </div>
                                    <br>
                                    <button type="submit" name="signup" class="btn btn-danger" id="submit">Register Now </button>
                                   
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
</body>

</html>