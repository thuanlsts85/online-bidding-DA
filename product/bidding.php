<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
//make sure user signed in
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

            <div class="bidding-page">
                  <div class="bidding">
                        <h1>Current Bidding Product</h1>
                        <!-- create sort function for end time, current price, bid count -->
                        <div class="sort">
                              <b>Sort product by:</b>
                              <form method="post" class="sort_att">
                                    <div class="sort-url"></div>
                                    <a class="sort-item" href="bidding.php?sort=end_time" name="sort" style="text-decoration: none;">Close Time</a>
                                    <a class="sort-item" href="bidding.php?sort=current_price" name="sort">Current Price</a>
                                    <a class="sort-item" href="bidding.php?sort=count_bid" name="sort">Bid Counts</a>

                              </form>
                              <!-- clear button to return default order - ASC -->
                              <a class="sort-item" href="bidding.php?sor1=end_time" name="sor1"><button>CLEAR</button></a>
                        </div>

                        <div class="content">
                              <?php

                              $id = $_SESSION['id'];
                              // get data for each product card
                              $sql = "SELECT p.id as product_id, p.name, c.name as cat_name, description, end_time, start_price, current_price, img, status, count_bid 
                                          FROM product p JOIN category c ON p.category_id = c.id JOIN auction a ON p.id = product_id 
                                          WHERE status = 1 AND uid <> :id AND end_time-now()>0
                                          ";

                              if (isset($_GET['sort']) && strlen(trim($_GET['sort'])) > 0) {
                                    //need to protect this because it is not a string being prepared
                                    $sort = addslashes(trim($_GET['sort']));
                                    $sql .= " ORDER BY $sort DESC";
                              } 
                                    elseif (isset($_GET['sor1']) && strlen(trim($_GET['sor1'])) > 0) {
                                          //need to protect this because it is not a string being prepared
                                          $sort1 = addslashes(trim($_GET['sor1']));
                                          $sql .= " ORDER BY $sort1 ASC";
                              } 
                              else {
                                    $sql;
                              }

                              $query = $pdo->prepare($sql);

                              $query->bindParam(':id', $id, PDO::PARAM_STR);

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
                                                      <h2 class="name">
                                                            <?php echo htmlentities($result->name) ?>
                                                      </h2>
                                                      <p class="bid">Number of Bid:
                                                            <?php echo htmlentities($result->count_bid); ?>
                                                      </p>
                                                      <p class="status">Status:
                                                            <?php if ($result->status == 1) { ?>
                                                                  <span style="color: green">Active</span>
                                                            <?php } else { ?>
                                                                  <span style="color: red">Blocked</span>
                                                            <?php } ?>
                                                      </p>
                                                      <p class="price">Highest Bid:
                                                            <?php echo htmlentities($result->current_price); ?>
                                                            VND
                                                      </p>
                                                      <p class="close">Close At:
                                                            <?php echo htmlentities($result->end_time); ?>
                                                      </p>
                                                      <!-- get data from mongodb -->
                                                      <?php
                                                      $features = $collection->find(['_id' => $result->product_id]);
                                                      foreach ($features as $one) {

                                                            // Use for loop to extract the keys and values
                                                            foreach ($one['attributes'] as $key => $val) {
                                                                  echo "$key : $val " . '<br>';
                                                            }
                                                      }
                                                      ?>

                                                </div>
                                                <div class="button">
                                                      <a href="detail.php?view=<?php echo htmlentities($result->product_id); ?>">
                                                            VIEW DETAIL
                                                      </a>
                                                </div>

                                          </div>
                              <?php
                                    }
                              }
                              ?>
                        </div>
                  </div>
                  <!-- CONTENT-WRAPPER SECTION END-->
                  <?php include('../includes/footer.php'); ?>
                  <!-- FOOTER SECTION END-->
            </div>


      </body>

      </html>

      <script>
           document.querySelector('.sort-url').innerHTML = window.location.href.substring(47).replace('_',' ')
      </script>
<?php } ?>