<?php
session_start();
include('includes/data_connect.php');
error_reporting(0);
//make sure user signed in
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {

  //Set new img and delete old img
  if (isset($_POST['update_img'])) {
    // Get data from the update img form
    $id = $_SESSION['id'];
    // get old img to delete on the folder
    $sql1 = "SELECT * FROM customer WHERE id= :id";
    $query1 = $pdo->prepare($sql1);

    $query1->bindParam(':id', $id, PDO::PARAM_STR);

    $query1->execute();

    $fetch_record = $query1->fetch(PDO::FETCH_ASSOC);
    $old_img = $fetch_record['img'];
    $delete_path = "assets/img/" . $old_img;

    //if found image location to delete, delete others data
    if (unlink($delete_path)) {
      // store image location
      $target = "assets/img/" . basename($_FILES['img']['name']);

      $img = $_FILES['img']['name'];
      
      //update image profile
      $sql = "UPDATE customer SET img= :img WHERE id= :id";
      $query = $pdo->prepare($sql);

      $query->bindParam(':id', $id, PDO::PARAM_STR);
      $query->bindParam(':img', $img, PDO::PARAM_STR);

      $query->execute();
      
      //add new img to selected folder
      if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
        echo '<script>alert("Your image profile has been updated")</script>';
        echo "<script type='text/javascript'> document.location ='profile.php'; </script>";
      } else {
        echo '<script>alert("An error occurred")</script>';
      }
    }
  }

  //Set update information without img
  if (isset($_POST['update'])) {
    
    // Get data from the input form
    $id = $_SESSION['id'];
    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $phone = $_POST['phone'];
    $balance = $_POST['balance'];
    $address = $_POST['address'];

    $sql = "UPDATE customer set Fname= :Fname, Lname= :Lname, phone= :phone, balance= :balance, address= :address WHERE id= :id";
    $query = $pdo->prepare($sql);

    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':Fname', $Fname, PDO::PARAM_STR);
    $query->bindParam(':Lname', $Lname, PDO::PARAM_STR);
    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
    $query->bindParam(':balance', $balance, PDO::PARAM_INT);
    $query->bindParam(':address', $address, PDO::PARAM_STR);

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
    <!-- CUSTOM STYLE  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
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

                <!-- create profile form that receive input from user -->
                <form name="signup" method="post" enctype="multipart/form-data">
                  <?php
                  $id = $_SESSION['id'];

                  $sql = "SELECT id, Fname, Lname, email, phone, balance, country, branch_id, address, img, status FROM customer where id= :id";
                  $query = $pdo->prepare($sql);

                  $query->bindParam(':id', $id, PDO::PARAM_STR);

                  $query->execute();

                  $results = $query->fetchAll(PDO::FETCH_OBJ);

                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                  ?>
                      <div class="form-group">
                        <?php echo "<img src='assets/img/" . htmlentities($result->img) . "' style='max-height: 200px; max-width: 200px'> " ?>
                      </div>

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
                        <label>Email : </label>
                        <span> <?php echo htmlentities($result->email); ?> </span>
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
                        <label>Balance:</label>
                        <span><?php echo htmlentities($result->balance); ?> VND</span>
                      </div>

                      <div class="form-group">
                        <label>Country : </label>
                        <span> <?php echo htmlentities($result->country); ?> </span>
                      </div>

                      <div class="form-group">
                        <label>City : </label>
                        <?php if ($result->branch_id == 1) { ?>
                          <span>Ho Chi Minh</span>
                        <?php }
                        if ($result->branch_id == 2) { ?>
                          <span>Da Nang</span>
                        <?php }
                        if ($result->branch_id == 3) { ?>
                          <span>Ha Noi</span>
                        <?php } ?>
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" type="text" name="address" value="<?php echo htmlentities($result->address); ?>" autocomplete="off" required />
                      </div>

                      <br>
                  <button type="submit" name="update" class="btn btn-primary" id="submit">Update Now </button>
                  <?php }
                  } ?>
                  </form>
                  

                  <!---------------Update Avatar---------------->
                <br>
                <form action="#" name="signup" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Update Image profile</label>
                    <input class="form-control" type="file" name="img" value="<?php echo htmlentities($result->img); ?>" autocomplete="off" required />
                    <br>
                    <button type="submit" name="update_img" class="btn btn-primary" id="submit">Update Now </button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
  </body>

  </html>
<?php } ?>