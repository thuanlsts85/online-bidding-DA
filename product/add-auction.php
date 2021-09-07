<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if (strlen($_SESSION['login']) == 0) {
      header('location:../index.php');
} else { 
    $id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
       <?php echo $id ?>
    </h1>
</body>
</html>
<?php } ?>