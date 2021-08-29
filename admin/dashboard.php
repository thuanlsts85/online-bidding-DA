<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:../index.php');
}
else{?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Online Auction Management System | Admin Dash Board</title>
    <!-- CUSTOM STYLE  -->
    <link href="../assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">ADMIN DASHBOARD</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="alert alert-success back-widget-set text-center">
                        <i class="fa fa-book fa-5x"></i>
                        <?php
                        $sql = "SELECT id from product ";
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $listdbooks = $query->rowCount();
                        ?>


                        <h3>Number of products: <?php echo htmlentities($listdbooks); ?></h3>
                        Products Listed
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('../includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
</body>

</html>
<?php } ?>