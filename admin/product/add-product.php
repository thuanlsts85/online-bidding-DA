<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {

    if (isset($_POST['create'])) {

        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $start_price = $_POST['start_price'];
        $end_time = $_POST['end_time'];
        $img = $_POST['img'];

        $sql = "INSERT INTO product(`name`,`category_id`,`description`,`start_price`,`end_time`,`img`) VALUES(:name,:category_id,:description,:start_price,:end_time,:img)";
        $query = $pdo->prepare($sql);

        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':start_price', $start_price, PDO::PARAM_STR);
        $query->bindParam(':end_time', $end_time, PDO::PARAM_STR);
        $query->bindParam(':img', $img, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $pdo->lastInsertId();
        if ($lastInsertId) {
            $_SESSION['addmsg'] = "Product added successfully";
            header('location:product.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again";
        }
    }
}
?>