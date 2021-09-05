<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {

    if (isset($_POST['create'])) {
        // store image location
        $target = "../assets/img/" . basename($_FILES['img']['name']);

        // Get data from the input form
        $id = $_POST['id'];
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $start_price = $_POST['start_price'];
        $end_time = $_POST['end_time'];
        $img = $_FILES['img']['name'];
        $attributes = ['4G' => 'true', '2SIM' => 'Yes', 'brand' => 'Nokia'];

        $sql = "INSERT INTO product(`id`,`name`,`category_id`,`description`,`start_price`,`end_time`,`img`) VALUES(:id,:name,:category_id,:description,:start_price,:end_time,:img)";
        $query = $pdo->prepare($sql);

        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':start_price', $start_price, PDO::PARAM_STR);
        $query->bindParam(':end_time', $end_time, PDO::PARAM_STR);
        $query->bindParam(':img', $img, PDO::PARAM_STR);

        $query->execute();

        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            $_SESSION['addmsg'] = "Product added successfully";
            header('location:product.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again";
        }

        // Use insertOne to insert a collection
        $res = $collection->insertOne([
            '_id' => $id,
            'attributes' => $attributes
        ]);
    }
}
