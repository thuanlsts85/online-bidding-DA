<?php
session_start();
error_reporting(0);
include('../includes/data_connect.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_GET['end'])) {
        $auction_id = $_GET['end'];

        // get old img to delete on the folder
        $sql1 = "CALL end_bidding(:auctionID)";
        $query1 = $pdo->prepare($sql1);

        $query1->bindParam(':auctionID', $auction_id, PDO::PARAM_STR);
        $query1->execute();
        $result = $query1->fetch(PDO::FETCH_ASSOC);
        if($result['status']=1){
            header('location: product.php');
            $_SESSION['error'] = "Cannot End: The auction is in process !!!";
        }elseif($result['status']=0){
            header('location: product.php');
            $_SESSION['endmsg'] = "Auction End Success";
        } 
    }
}
?>