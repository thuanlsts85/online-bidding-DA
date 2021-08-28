<?php
session_start();
include('includes/data_connect.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
  if (isset($_POST['update'])) {
    $id = $_SESSION['id'];
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $phone = $_POST['phone'];
    $balance = $_POST['balance'];
    $address = $_POST['address'];
    $img = $_POST['img'];

      $sql = "UPDATE customer set Fname= :Fname, Lname= :Lname, phone= :phone, balance= :balance, address= :address, img= :img WHERE id= :id";
      $query = $pdo->prepare($sql);

      $query->bindParam(':id', $id, PDO::PARAM_STR);
      $query->bindParam(':Fname', $Fname, PDO::PARAM_STR);
      $query->bindParam(':Lname', $Lname, PDO::PARAM_STR);
      $query->bindParam(':phone', $phone, PDO::PARAM_STR);
      $query->bindParam(':balance', $balance, PDO::PARAM_INT);
      $query->bindParam(':address', $address, PDO::PARAM_STR);
      $query->bindParam(':img', $img, PDO::PARAM_STR);

      if ($query->execute()) {
        echo '<script>alert("Your profile has been updated")</script>';
        echo "<script type='text/javascript'> document.location ='profile.php'; </script>";
      } else {
        echo '<script>alert("An error occurred")</script>';
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

    <title>Online Aunction Management System | Customer Profile</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

  </head>

  <body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
      <div class="container">
        <div class="row pad-botm">
          <div class="col-md-12">
            <h4 class="header-line">My Profile</h4>

          </div>

        </div>
        <div class="row">

          <div class="col-md-9 col-md-offset-1">
            <div class="panel panel-danger">
              <div class="panel-body">
                <form name="signup" method="post">
                  <?php
                  $id = $_SESSION['id'];

                  $sql = "SELECT id, Fname, Lname, email, phone, balance, country, branch_id, address, img, status FROM customer where id= :id";
                  $query = $pdo->prepare($sql);

                  $query->bindParam(':id', $id, PDO::PARAM_STR);

                  $query->execute();

                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                  ?>

                      <div class="form-group">
                        <label>Customer ID : </label>
                        <?php echo htmlentities($result->id); ?>
                      </div>

                      <div class="form-group">
                        <label>Profile Status : </label>
                        <?php if ($result->status == 1) { ?>
                          <span style="color: green">Active</span>
                        <?php } else { ?>
                          <span style="color: red">Blocked</span>
                        <?php } ?>
                      </div>


                      <div class="form-group">
                        <label>First Name</label>
                        <input class="form-control" type="text" name="Fname" value="<?php echo htmlentities($result->Fname); ?>" autocomplete="off" required />
                      </div>

                      <div class="form-group">
                        <label>Last Name</label>
                        <input class="form-control" type="text" name="Lname" value="<?php echo htmlentities($result->Lname); ?>" autocomplete="off" required />
                      </div>

                      <div class="form-group">
                        <label>Phone Number :</label>
                        <input class="form-control" type="text" name="phone" maxlength="10" value="<?php echo htmlentities($result->phone); ?>" autocomplete="off" required />
                      </div>

                      <div class="form-group">
                        <label>Email : </label>
                        <span>  <?php echo htmlentities($result->email); ?>  </span>
                      </div>

                      <div class="form-group">
                        <label>Balance</label>
                        <input class="form-control" type="number" name="balance" value="<?php echo htmlentities($result->balance); ?>" autocomplete="off" required />
                      </div>

                      <div class="form-group">
                        <label>Country : </label>
                        <span>  <?php echo htmlentities($result->country); ?>  </span>
                      </div>

                      <div class="form-group">
                        <label>City : </label>
                        <?php if ($result->branch_id == 1) { ?>
                          <span>Ho Chi Minh</span>
                        <?php } 
                         if ($result->branch_id == 2) { ?>
                          <span>Da Nang</span>
                        <?php }if ($result->branch_id == 3) { ?>
                          <span>Ha Noi</span>
                        <?php } ?>
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" type="text" name="address" value="<?php echo htmlentities($result->address); ?>" autocomplete="off" style="width: 300px;" required />
                      </div>

                      <div class="form-group">
                        <label>Image profile link</label>
                        <input class="form-control" type="text" name="img" value="<?php echo htmlentities($result->img); ?>" autocomplete="off" required />
                      </div>
                  <?php }} ?>

                  <button type="submit" name="update" class="btn btn-primary" id="submit">Update Now </button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
  </body>

  </html>
<?php } ?>