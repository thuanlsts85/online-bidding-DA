<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:../index.php');
} else {

    if (isset($_POST['create'])) {
        // store image location
        $target = "../assets/img/product/" . basename($_FILES['img']['name']);

        $uid = $_SESSION['id'];

        // Get data from the input form
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $start_price = $_POST['start_price'];
        $end_time = $_POST['end_time'];
        $img = $_FILES['img']['name'];

        $att1 = $_POST['att1'];
        $att2 = $_POST['att2'];
        $att3 = $_POST['att3'];
        $value1 = $_POST['value1'];
        $value2 = $_POST['value2'];
        $value3 = $_POST['value3'];

        $attributes = [$att1 => $value1, $att2 => $value2, $att3 => $value3];


        $sql = "INSERT INTO product(`name`,`uid`,`category_id`,`description`,`start_price`,`end_time`,`img`) VALUES(:name,:uid,:category_id,:description,:start_price,:end_time,:img)";
        $query = $pdo->prepare($sql);

        // $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
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
        //get id of the current added product
        $product_id = $pdo->lastInsertId();

        // create empty auction
        $sql1 = "INSERT INTO auction(`product_id`,`current_price`) VALUES(:product_id, :current_price)";
        $query1 = $pdo->prepare($sql1);

        $query1->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $query1->bindParam(':current_price', $start_price, PDO::PARAM_STR);

        $query1->execute();

        // Use insertOne to insert a collection
        $res = $collection->insertOne([
            '_id' => $product_id,
            'attributes' => $attributes
        ]);

        
    }
}
