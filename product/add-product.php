<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
//make sure user signed in
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

        //get length of attribute that will be add on mongodb 
        $length = $_POST['mongoLength'];

        $attributes = [];

        // create loop to add attributes and values for them on mongodb
        for ($i=0; $i < $length; $i++) { 
            $string = strval($i);
            $att[$i] = $_POST['att'.$string];
            $value[$i] = $_POST['value'.$string];
            $attributes+=([$att[$i] => $value[$i]]);
        }

        //add data into product table
        $sql = "INSERT INTO product(`name`,`uid`,`category_id`,`description`,`start_price`,`end_time`,`img`) VALUES(:name,:uid,:category_id,:description,:start_price,:end_time,:img)";
        $query = $pdo->prepare($sql);

        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':start_price', $start_price, PDO::PARAM_STR);
        $query->bindParam(':end_time', $end_time, PDO::PARAM_STR);
        $query->bindParam(':img', $img, PDO::PARAM_STR);

        $query->execute();

        // add product img into selected folder
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            //get id of the current added product
            $product_id = $pdo->lastInsertId();

            // create auction with product id
            $sql1 = "INSERT INTO auction(`product_id`,`seller_id`) VALUES(:product_id, :seller_id)";
            $query1 = $pdo->prepare($sql1);

            $query1->bindParam(':product_id', $product_id, PDO::PARAM_STR);
            $query1->bindParam(':seller_id', $uid, PDO::PARAM_STR);

            if ($query1->execute()) {
                // Use insertOne to insert a collection
                $res = $collection->insertOne([
                    '_id' => $product_id,
                    'attributes' => $attributes
                ]);
                $_SESSION['addmsg'] = "Product added successfully";
                header('location:product.php');
            } else {
                $_SESSION['error'] = "Something went wrong in database";
            }
        } else {
            $_SESSION['error'] = "Image file are too big or wrong type";
        }
    }
}
