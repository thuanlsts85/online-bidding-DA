<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {
    // Update customer balance
    if (isset($_POST['update_balance'])) {
        $id = $_GET['view'];
        $balance = $_POST['balance'];
        $sql = "UPDATE customer SET balance= :balance WHERE id= :id";
        $query = $pdo->prepare($sql);

        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':balance', $balance, PDO::PARAM_STR);

        if ($query->execute()) {
            echo '<script>alert("Update Success")</script>';
            echo "<script type=text/javascript'> document.location ='detail-customer.php?view=$id'; </script>";
        } else {
            echo '<script>alert("Fail: Please try again!")</script>';
            echo "<script type=text/javascript'> document.location ='detail-customer.php?view=$id'; </script>";
        }
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Auction Management System | Manage Products</title>
        <!-- CUSTOM STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link href="../../assets/css/style.css" rel="stylesheet" />

    </head>

    <body>
        <!------MENU SECTION START-->
        <?php include('../includes/header.php'); ?>
        <!-- MENU SECTION END-->

        <?php
        $id = $_GET['view'];
        $sql = "SELECT Fname, Lname, balance, img
                FROM customer 
                WHERE id= :id";
        $query = $pdo->prepare($sql);

        $query->bindParam(':id', $id, PDO::PARAM_STR);

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
        ?>
                <div class="container" style="background-color: #eee; padding: 20px;">
                    <div class="row">
                        <div class="col-md-1"></div>

                        <div class="col-md-3">
                            <p><?php echo "<img src='../../assets/img/" . htmlentities($result->img) . "' style='height: 300px; width: 300px'> " ?></p>
                            <div style="display: flex;">
                                <b><?php echo htmlentities($result->Fname); ?></b>
                                <b><?php echo htmlentities($result->Lname); ?></b>
                            </div>

                            <form action="#" name="update" method="post">
                                <div class="form-group">
                                    <label>Balance (VND)</label>
                                    <input class="form-control" type="number" name="balance" value="<?php echo htmlentities($result->balance); ?>" autocomplete="off" required />
                                    <br>
                                    <button type="submit" name="update_balance" class="btn btn-primary" id="submit">Update Balance</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-1"></div>

                        <div class="col-md-7">
                            <h4 class="text-center">Bidding History of 
                            <?php echo $id; ?>
                            </h4>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Image</th>
                                                <th>Bidded Price</th>
                                                <th>Status</th>
                                                <th>Seller</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $sql = "SELECT a.id as auction_id, seller_id, current_price, img, name, product_id, isUndo
                                                FROM auction a JOIN product p ON p.id = a.product_id
                                                WHERE a.condition = 0 AND a.customer_id = :uid";
                                            $query = $pdo->prepare($sql);
                                            $query->bindParam(':uid', $id, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                            ?>
                                                    <tr class="odd gradeX">
                                                        <td class="center"><?php echo htmlentities($result->auction_id); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->name); ?></td>
                                                        <td class="center"><?php echo "<img src='../../assets/img/product/" . htmlentities($result->img) . "' style='max-height: 50px; max-width: 50px'> " ?></td>
                                                        <td class="center"><?php echo htmlentities($result->current_price); ?></td>
                                                        <td class="center">WIN</td>
                                                        <td class="center"><?php echo htmlentities($result->seller_id); ?></td>
                                                        <?php if($result->isUndo==0) { ?>
                                                        <td class="center">
                                                            <div class="button" onclick="return confirm('Are you sure you want to undo transaction?');">
                                                                <a href="undo.php?undo=<?php echo htmlentities($result->auction_id); ?>">
                                                                    UNDO
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <?php } else{ ?>
                                                            <td class="center">
                                                            <div class="button" onclick="return confirm('Already Undo');">
                                                                <a>
                                                                    DISUNDO
                                                                </a>
                                                            </div>
                                                        </td>
                                                       <?php } ?>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
        <?php }
        } ?>
        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('../includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
    </body>

    </html>

<?php } ?>