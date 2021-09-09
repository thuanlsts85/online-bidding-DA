<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_GET['end'])) {
        $auction_id = $_GET['end'];
        $sql1 = "CALL end_bidding(:auctionID)";
        $query1 = $pdo->prepare($sql1);
        $query1->bindParam(':auctionID', $auction_id, PDO::PARAM_STR);
        $query1->execute();


        $sql = "SELECT * FROM auction WHERE id= :id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':id', $auction_id, PDO::PARAM_STR);
        $query->execute();
        $conditions = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            foreach ($conditions as $condition) {
                if ($condition->condition == 0) {
                    header('location: product.php');
                    $_SESSION['endmsg'] = "Auction End Success";
                } else {
                    header('location: product.php');
                    $_SESSION['error'] = "Cannot end: The auction is in process";
                }
            }
        }
    }
}
