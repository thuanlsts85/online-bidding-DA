<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
//make sure admin signed in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {

    if (isset($_POST['create'])) {
        // get input name from admin
        $name = $_POST['name'];

        // add data to category table
        $sql = "INSERT INTO category(`name`) VALUES(:name)";
        $query = $pdo->prepare($sql);

        $query->bindParam(':name', $name, PDO::PARAM_STR);

        $query->execute();
        // make sure new category added
        $lastInsertId = $pdo->lastInsertId();
        if ($lastInsertId) {
            $_SESSION['addmsg'] = "Category added successfully";
            header('location:category.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again";
        }
    }
}
?>