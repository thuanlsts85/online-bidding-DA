<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if (strlen($_SESSION['login']) == 0) {
      header('location:../index.php');
} else {
?>
      <!DOCTYPE html>
      <html xmlns="http://www.w3.org/1999/xhtml">

      <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
            <meta name="description" content="" />
            <meta name="author" content="" />
            <title>Online Auction Management System | User Dash Board</title>
            <!-- CUSTOM STYLE  -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
            <link href="../assets/css/style.css" rel="stylesheet" />
            <!-- GOOGLE FONT -->
            <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

      </head>

      <body>
            <!------MENU SECTION START-->
            <?php include('../includes/header.php'); ?>

            <h1>Current Bidding Product</h1>


            <div class="bidding-page">
                  <?php
                  $sql = "SELECT p.id as product_id, p.name, c.name as cat_name, description, end_time, start_price, img, p.date_created, status FROM product p 
                                                    JOIN category c ON p.category_id = c.id";
                  $query = $pdo->prepare($sql);

                  $query->execute();

                  $results = $query->fetchAll(PDO::FETCH_OBJ);

                  if ($query->rowCount() > 0) {

                        foreach ($results as $result) {
                  ?>
                              <div class="card">
                                    <div class="img">
                                          <?php echo "<img src='../assets/img/product/" . htmlentities($result->img) . "' style='max-height: 100%; max-width: 100%'> " ?>
                                    </div>
                                    <div class="info">
                                          <h1 class="name">
                                                <?php echo htmlentities($result->name) ?>
                                          </h1>
                                          <p class="status">Status:
                                                <?php if ($result->status == 1) { ?>
                                                      <span style="color: green">Active</span>
                                                <?php } else { ?>
                                                      <span style="color: red">Blocked</span>
                                                <?php } ?>
                                          </p>
                                          <p class="price">Start price:
                                                <?php echo htmlentities($result->start_price); ?>
                                                VND
                                          </p>
                                          <p class="close">Close At:
                                                <?php echo htmlentities($result->end_time); ?>
                                          </p>
                                          <?php
                                          $features = $collection->find(['_id' => $result->product_id]);
                                          foreach ($features as $one) {

                                                // Use for loop to extract the keys and values
                                                foreach ($one['attributes'] as $key => $val) {
                                                      echo "$key : $val " . '<br>';
                                                }
                                          }
                                          ?>
                                          <div class="button">
                                                <a href="bidding.php?bid=<?php echo htmlentities($result->product_id); ?>">
                                                      Bid
                                                </a>
                                          </div>
                                    </div>

                              </div>
                  <?php
                        }
                  }
                  ?>
            </div>
            <!-- CONTENT-WRAPPER SECTION END-->
            <?php include('../includes/footer.php'); ?>
            <!-- FOOTER SECTION END-->
      </body>

      </html>
<?php } ?>