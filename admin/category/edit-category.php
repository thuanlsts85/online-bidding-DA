<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {

    if (isset($_POST['update'])) {
        $id = intval($_GET['id']);
        $name = $_POST['name'];

        $sql = "UPDATE category SET name= :name WHERE id= :id";
        $query = $pdo->prepare($sql);

        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);

        $query->execute();
        $_SESSION['updatemsg'] = "Category updated successfully";
        header('location:category.php');
    }
?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Auction Management System | Edit Categories</title>
        <!-- CUSTOM STYLE  -->
        <link href="../../assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    </head>

    <body>
        <!------MENU SECTION START-->
        <?php include('includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wra
    <div class=" content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Edit category</h4>

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
                                <?php
                                $id = intval($_GET['id']);
                                $sql = "SELECT * FROM category where id= :id";
                                $query = $pdo->prepare($sql);

                                $query->bindParam(':id', $id, PDO::PARAM_STR);

                                $query->execute();

                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                ?>
                                        <div class="form-group">
                                            <label>Category Name</label>
                                            <input class="form-control" type="text" name="name" value="<?php echo htmlentities($result->name); ?>" required />
                                        </div>
                                <?php }
                                } ?>
                                <button type="submit" name="update" class="btn btn-info">Update </button>

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