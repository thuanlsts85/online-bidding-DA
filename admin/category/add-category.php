<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {

    if (isset($_POST['create'])) {

        $name = $_POST['name'];

        $sql = "INSERT INTO category(`name`) VALUES(:name)";
        $query = $pdo->prepare($sql);

        $query->bindParam(':name', $name, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $pdo->lastInsertId();
        if ($lastInsertId) {
            $_SESSION['addmsg'] = "Category added successfully";
            header('location:category.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again";
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
        <title>Online Auction Management System | Add Categories</title>
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    </head>

    <body>
        <!------MENU SECTION START-->
        <?php include('includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wra
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Add category</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
                        <div class=" panel panel-info">
                        <div class="panel-heading">
                            Category Info
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input class="form-control" type="text" name="name" autocomplete="off" require />
                                </div>
                                <button type="submit" name="create" class="btn btn-info">Create</button>
                            </form>
                            <a href="category.php"><button>Close</button></a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </div>
        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
    </body>

    </html>
<?php } ?>