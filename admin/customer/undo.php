<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {
    // Undo transaction
    $id = $_GET['undo'];
    // Get customer and seller id to reset balance
    $sql = "SELECT customer_id, seller_id, current_price FROM auction WHERE id= :id";
    $query = $pdo->prepare($sql);

    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    $customer = $result['customer_id'];
    $seller = $result['seller_id'];
    $price = $result['current_price'];

    //Reset balance for customer
    $sql1 = "UPDATE customer SET balance= balance + :price WHERE id= :customer";
    $query1 = $pdo->prepare($sql1);

    $query1->bindParam(':customer', $customer, PDO::PARAM_STR);
    $query1->bindParam(':price', $price, PDO::PARAM_STR);

    if ($query1->execute()) {
        //Reset balance for seller
        $sql2 = "UPDATE customer SET balance= balance - :price WHERE id= :seller";
        $query2 = $pdo->prepare($sql2);

        $query2->bindParam(':seller', $seller, PDO::PARAM_STR);
        $query2->bindParam(':price', $price, PDO::PARAM_STR);
        if ($query2->execute()) {
            $sql3 = "UPDATE auction SET isUndo= 1 WHERE id= :id";
            $query3 = $pdo->prepare($sql3);

            $query3->bindParam(':id', $id, PDO::PARAM_STR);
            $query3->execute();
            echo "<script>alert('Undo Success');document.location ='detail-customer.php?view=$customer'; </script>";
        }
    }
}
