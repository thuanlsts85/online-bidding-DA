<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_GET['del'])) {
        $id = $_GET['del'];

        // get old img to delete on the folder
        $sql1 = "SELECT * FROM product WHERE id= :id";
        $query1 = $pdo->prepare($sql1);

        $query1->bindParam(':id', $id, PDO::PARAM_STR);

        $query1->execute();

        $fetch_record = $query1->fetch(PDO::FETCH_ASSOC);
        $old_img = $fetch_record['img'];
        $delete_path = "../assets/img/product/" . $old_img;

        //if found image location to delete, delete others data
        if (unlink($delete_path)) {

            $sql = "DELETE FROM product  WHERE id= :id";
            $query = $pdo->prepare($sql);

            $query->bindParam(':id', $id, PDO::PARAM_STR);

            $query->execute();

            header('location:product.php');
            $_SESSION['delmsg'] = "Product deleted successfully ";
        } else {
            $_SESSION['error'] = "Unable to delete product";
        }
        // delete data on mongodb
        $delete_result = $collection->deleteMany(['_id' => $id]);
    }
?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Auction Management System | Manage Products</title>
        <!-- CUSTOM STYLE  -->
        <link href="../assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    </head>

    <body>
        <!------MENU SECTION START-->
        <?php include('../includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Manage Products</h4>
                    </div>
                    <div class="row">
                        <?php if ($_SESSION['error'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-danger">
                                    <strong>Error :</strong>
                                    <?php echo htmlentities($_SESSION['error']); ?>
                                    <?php echo htmlentities($_SESSION['error'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['msg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['msg']); ?>
                                    <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['addmsg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['addmsg']); ?>
                                    <?php echo htmlentities($_SESSION['addmsg'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['delmsg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['delmsg']); ?>
                                    <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Products Listing of
                                <p><?php
                                    $uid = $_SESSION['id'];
                                    echo $uid;
                                    ?>
                                </p>
                            </div>
                            <!-- <a href="add-category.php"><button>Add Category</button></a> -->
                            <?php  ?>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Information</th>
                                                <th>Close At</th>
                                                <th>Start Price</th>
                                                <th>Image</th>
                                                <th>Created On</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $uid = $_SESSION['id'];
                                            $sql = "SELECT p.id as product_id, p.name, c.name as cat_name, description, end_time, start_price, img, p.date_created, status FROM product p 
                                                    JOIN category c ON p.category_id = c.id
                                                    WHERE uid= :uid";
                                            $query = $pdo->prepare($sql);

                                            $query->bindParam(':uid', $uid, PDO::PARAM_STR);

                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                            ?>
                                                    <tr class="odd gradeX">
                                                        <td class="center"><?php echo htmlentities($result->product_id); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->name); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->cat_name); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->description); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->end_time); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->start_price); ?></td>
                                                        <td class="center"><?php echo "<img src='../assets/img/product/" . htmlentities($result->img) . "' style='max-height: 50px; max-width: 50px'> " ?></td>
                                                        <td class="center"><?php echo htmlentities($result->date_created); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->status); ?></td>
                                                        <td class="center">
                                                            <a href="product.php?del=<?php echo htmlentities($result->product_id); ?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class=" btn btn-danger">Delete</button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } ?>
                                        </tbody>
                                    </table>

                                    <!-- Add Product -->
                                    <form role="form" method="post" action="add-product.php" enctype="multipart/form-data">
                                        <label><b>Add New Product</b></label>

                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <input class="form-control" type="text" name="name" autocomplete="off" require />
                                        </div>

                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" type="text" name="category_id" autocomplete="off" require>
                                                <option value="">Select Category</option>
                                                <?php

                                                $sql = "SELECT * from  category ";
                                                $query = $pdo->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {
                                                ?>
                                                        <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->name); ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <input class="form-control" type="text" name="description" autocomplete="off" require />
                                        </div>

                                        <div class="form-group">
                                            <label>Start Price</label>
                                            <input class="form-control" type="number" name="start_price" autocomplete="off" require />
                                        </div>

                                        <div class="form-group">
                                            <label>Close Time</label>
                                            <input class="form-control" type="datetime-local" name="end_time" autocomplete="off" require />
                                        </div>

                                        <div class="form-group">
                                            <label>Image</label>
                                            <input class="form-control" type="file" name="img" autocomplete="off" require />
                                        </div>

                                        <button type="submit" name="create" class="btn btn-info">Create</button>
                                    </form>

                                </div>

                            </div>
                        </div>
                        <!--End Advanced Tables -->
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