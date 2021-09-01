<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {

    if (isset($_POST['create'])) {

        $name = $_POST['name'];

        $sql = "INSERT INTO category(`name`) VALUES(:name)";
        $query = $pdo->prepare($sql);

        $query->bindParam(':name', $name, PDO::PARAM_STR);

        $query->execute();
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