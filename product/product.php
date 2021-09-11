<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
//make sure user signed in
if (strlen($_SESSION['login']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_GET['del'])) {
        try {
            // received product id when user decide delete
            $id = $_GET['del'];

            // get old img to delete on the folder
            $sql1 = "SELECT * FROM product WHERE id= :id";
            $query1 = $pdo->prepare($sql1);

            $query1->bindParam(':id', $id, PDO::PARAM_STR);

            $query1->execute();

            $fetch_record = $query1->fetch(PDO::FETCH_ASSOC);
            $old_img = $fetch_record['img'];
            $delete_path = "../assets/img/product/" . $old_img;

            // delete product with received id
            $sql = "DELETE FROM product  WHERE id= :id";
            $query = $pdo->prepare($sql);

            $query->bindParam(':id', $id, PDO::PARAM_STR);

            //delete existed img on the folder
            if ($query->execute()) {
                unlink($delete_path);
                header('location:product.php');
                $_SESSION['delmsg'] = "Product deleted successfully ";
            } else {
                $_SESSION['error'] = "Unable to delete product";
            }

            // delete data on mongodb
            $delete_result = $collection->deleteMany(['_id' => $id]);
        } catch (PDOException $e) {
            $error = $e->getMessage();
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
        <title>Online Auction Management System | Manage Products</title>
        <!-- CUSTOM STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
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
                        <!-- set notification of function status return to this page -->
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

                        <?php if ($_SESSION['endmsg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['endmsg']); ?>
                                    <?php echo htmlentities($_SESSION['endmsg'] = ""); ?>
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
                                Products List of seller:
                                <?php
                                $uid = $_SESSION['id'];
                                echo $uid;
                                ?>
                            </div>

                            <!-- create sell list of product for customer -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Detail</th>
                                                <th>Close At</th>
                                                <th>Start Price</th>
                                                <th>Highest Price</th>
                                                <th>Current Winner</th>
                                                <th>Image</th>
                                                <th>Created On</th>
                                                <th>Status</th>
                                                <th>Bid Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $uid = $_SESSION['id'];
                                            $sql = "SELECT p.id as product_id, a.id as auction_id, p.name, c.name as cat_name, description, end_time, start_price, current_price, a.customer_id as cus_id, img, p.date_created, p.status, count_bid FROM product p 
                                                    JOIN category c ON p.category_id = c.id JOIN auction a ON a.product_id = p.id
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
                                                        <td class="center"><?php echo htmlentities($result->start_price); ?> VND</td>
                                                        <td class="center"><?php echo htmlentities($result->current_price); ?> VND</td>
                                                        <!-- get customer email with the highest bid -->
                                                        <td class="center">
                                                            <?php
                                                            $cus_id = $result->cus_id;
                                                            $sql1 = "SELECT email FROM customer WHERE id= :id";
                                                            $query1 = $pdo->prepare($sql1);

                                                            $query1->bindParam(':id', $cus_id, PDO::PARAM_STR);

                                                            $query1->execute();
                                                            $email = $query1->fetch(PDO::FETCH_ASSOC);
                                                            echo $email['email'];                                                      
                                                            ?>
                                                        </td>
                                                        <td class="center"><?php echo "<img src='../assets/img/product/" . htmlentities($result->img) . "' style='max-height: 50px; max-width: 50px'> " ?></td>
                                                        <td class="center"><?php echo htmlentities($result->date_created); ?></td>
                                                        <td class="center">
                                                            <?php if ($result->status == 1) { ?>
                                                                <span style="color: green">Active</span>
                                                            <?php } else { ?>
                                                                <span style="color: red">Blocked</span>
                                                            <?php } ?>
                                                        </td>
                                                        
                                                        <!-- set condition for end button -->
                                                        <td class="center"><?php echo htmlentities($result->count_bid); ?></td>
                                                        <?php if($result->status==1) { ?>
                                                        <td class="center">
                                                            <!-- <a href="product.php?del=<?php echo htmlentities($result->product_id); ?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class=" btn btn-danger">Delete</button> -->
                                                            <a href="end-auction.php?end=<?php echo htmlentities($result->auction_id); ?>" onclick="return confirm('Are you sure you want to end bid?');"" >  <button class=" btn btn-danger">End</button>
                                                        </td>
                                                        <?php } else{ ?>
                                                            <td class="center">
                                                            <!-- <a href="product.php?del=<?php echo htmlentities($result->product_id); ?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class=" btn btn-danger">Delete</button> -->
                                                            <a href="#" onclick="return confirm('This auction was ended');"" >  <button class=" btn btn-danger">Ended</button>
                                                        </td>
                                                       <?php } ?>
                                                    </tr>
                                            <?php
                                                }
                                            } ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>

                            <!-- Add Product For Bidding Form -->
                            <form role="form" method="post" action="add-product.php" enctype="multipart/form-data">


                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input class="form-control" type="text" name="name" autocomplete="off" require />
                                </div>

                                <div class="form-group">
                                    <!-- get category for selection option -->
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
                                    <label>Close Time - Must be more than 5 minutes</label>
                                    <input class="form-control" type="datetime-local" name="end_time" id="end_time" autocomplete="off" require step="any" />
                                </div>

                                <div class="form-group">
                                    <label>Image</label>
                                    <input class="form-control" type="file" name="img" autocomplete="off" require />
                                </div>
                                <br>
                                
                                <!-- create feature form with unlimited input on mongodb -->
                                <div id="att-form">
                                    <input type="text" id="mongoLength" name="mongoLength">
                                </div>

                                <br>
                                <button type="submit" name="create" class="btn btn-info">Create</button>
                            </form>

                            <!-- add feature button -->
                            <button class="get-input-att" onclick="newinput()">+</button>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('../includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
    </body>

    </html>
    <!-- set limit time for bidding (bidding time = current time + 5 minutes) -->
    <script>
        let newDate = new Date().valueOf()
        let t = newDate + 86700000 - 61200000
        newDate = new Date(t).toISOString().split('.')[0]
        document.getElementById('end_time').min = newDate
    </script>

    <!-- create input form for extra attributes for product -->
    <script>
        var id = 0;
        var newinput = function() {
            var parent = document.getElementById('att-form')
            var header = document.createElement("h4")
            var field = document.createElement("input")
            var attName = document.createElement("input")

            header.innerHTML = "Feature " + id

            //Attribute name
            attName.id = "attName" + id;
            attName.name = "att" + id
            attName.class = "feature-mongo"
            attName.type = "text"
            attName.placeholder = "Name of feature"

            //Attriube value
            field.id = "attValue" + id;
            field.name = "value" + id
            field.class = "form-control"
            field.type = "text"
            field.placeholder = "Value of this feature"

            parent.appendChild(header);
            parent.appendChild(attName);
            parent.appendChild(field);

            id += 1;
            document.getElementById('mongoLength').value = id


        }
    </script>
<?php } ?>