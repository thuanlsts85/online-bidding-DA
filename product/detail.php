<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_POST['bid'])) {

        $cus_id = $_SESSION['id'];
        $productID = $_GET['view'];

        // Get data from the input form
        $bid_amount = $_POST['bid_amount'];

        $sql = "CALL valid_bidding(:cus_id,:productID,:bid_amount)";
        $query = $pdo->prepare($sql);

        // $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':cus_id', $cus_id, PDO::PARAM_STR);
        $query->bindParam(':productID', $productID, PDO::PARAM_STR);
        $query->bindParam(':bid_amount', $bid_amount, PDO::PARAM_INT);

        $query->execute();

        $sql1 = "SELECT * FROM auction WHERE product_id = :productID";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(':productID', $productID, PDO::PARAM_STR);
        $query1->execute();

        $result = $query1->fetch(PDO::FETCH_ASSOC);
        if ($result['current_price'] != $bid_amount) {
            echo '<script>alert("Fail: Please check your balance, current product price or bid END")</script>';
            echo "<script type=text/javascript'> document.location ='detail.php?view=$productID'; </script>";
        } else {
            echo '<script>alert("Bidding Success")</script>';
            echo "<script type=text/javascript'> document.location ='detail.php?view=$productID'; </script>";
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
        <link href="../assets/css/style.css" rel="stylesheet" />

    </head>

    <body>
        <!------MENU SECTION START-->
        <?php include('../includes/header.php'); ?>
        <!-- MENU SECTION END-->

        <?php
        $productID = $_GET['view'];
        $sql = "SELECT name, description, uid, customer_id, product_id, end_time, start_price, current_price, img, p.date_created as start_time 
                FROM product p JOIN auction ON p.id = product_id WHERE p.id= :id";
        $query = $pdo->prepare($sql);

        $query->bindParam(':id', $productID, PDO::PARAM_STR);

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
        ?>
                <div class="container" style="background-color: #eee; padding: 20px;">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                        <p><?php echo "<img src='../assets/img/product/" . htmlentities($result->img) . "' style='height: 350px; width: 350px'> " ?></p>
                        <div style="display: flex;">
                            <b>Created by: </b>
                            <?php
                            $user_id = $result->uid;
                            $sql1 = "SELECT email FROM customer WHERE id= :id";
                            $query1 = $pdo->prepare($sql1);

                            $query1->bindParam(':id', $user_id, PDO::PARAM_STR);

                            $query1->execute();
                            $emails = $query1->fetchAll(PDO::FETCH_OBJ);
                            if ($query1->rowCount() > 0) {
                                foreach ($emails as $email) {
                            ?>
                                    <p><?php echo htmlentities($email->email); ?></p>
                            <?php }
                            } ?>
                        </div>
                        <p><b>Start On: </b> <?php echo htmlentities($result->start_time); ?></p>
                        <p><b>End On: </b> <?php echo htmlentities($result->end_time); ?></p>
                        </div>
                        <div class="col-md-5">
                        <h1><?php echo htmlentities($result->name); ?></h1>
                        <p><b>Description: </b> <?php echo htmlentities($result->description); ?></p>
                        <b>Features</b>
                        <br>
                        <?php
                        $features = $collection->find(['_id' => $result->product_id]);
                        foreach ($features as $one) {
                            // Use for loop to extract the keys and values
                            foreach ($one['attributes'] as $key => $val) {
                                echo "$key : $val " . '<br>';
                            }
                        }
                        ?>
                        <br>
                        <p><b>Start Price: </b> <?php echo htmlentities($result->start_price); ?> VND</p>
                        <p><b>Highest Bid: </b> <?php echo htmlentities($result->current_price); ?> VND</p>
                        <div style="display: flex;">
                            <b>Current Winner: </b>
                            <?php
                            $customer_id = $result->customer_id;
                            $sql2 = "SELECT email FROM customer WHERE id= :id";
                            $query2 = $pdo->prepare($sql2);

                            $query2->bindParam(':id', $customer_id, PDO::PARAM_STR);

                            $query2->execute();
                            $customers = $query2->fetchAll(PDO::FETCH_OBJ);
                            if ($query2->rowCount() > 0) {
                                foreach ($customers as $customer) {
                            ?>
                                    <p><?php echo htmlentities($customer->email); ?></p>
                            <?php }
                            } ?>
                        </div>
                        

                <?php
            }
        } ?>
                <br>
                <form role="form" method="post">
                    <div class="form-group">
                        <label>Bid Amount</label>
                        <input class="form-control" type="text" name="bid_amount" autocomplete="off" require />
                    </div>
                    <br>
                    <button type="submit" name="bid" class="btn btn-info">Submit</button>
                </form>
                </div>
                <div class="col-md-1"></div>
                    </div>
                </div>

                <!-- CONTENT-WRAPPER SECTION END-->
                <?php include('../includes/footer.php'); ?>
                <!-- FOOTER SECTION END-->
    </body>

    </html>
<?php } ?>