<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Auction Management System | User Dash Board</title>
    <!-- CUSTOM STYLE  -->
    <link href="../assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('../includes/header.php');?>

<h1>User Dashboard</h1>

     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('../includes/footer.php');?>
      <!-- FOOTER SECTION END-->
</body>
</html>
<?php } ?>
