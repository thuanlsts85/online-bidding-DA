<?php
require_once('data_connect.php');

$id = $Fname = $Lname = $email = $phone = $balance = $country = $branch_id = $address = $img = $password = $pwd = '';

$id = $_POST['id'];
$Fname = $_POST['Fname'];
$Lname = $_POST['Lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$balance = $_POST['balance'];
$country = $_POST['country'];
$branch_id = $_POST['branch_id'];
$address = $_POST['address'];
$img = $_POST['img'];

// Hash password by md5
$pwd = $_POST['password'];
$password = MD5($pwd);

$sql = "INSERT INTO customer (`id`, `Fname`, `Lname`, `password`, `email`, `phone`, `balance`, `country`, `branch_id`, `address`, `img`) 
        VALUES ('$id', '$Fname', '$Lname', '$password', '$email', '$phone', $balance, '$country', $branch_id, '$address', '$img')";

$result = mysqli_query($conn, $sql);
if($result)
{
    header("Location: Login_page.php");
}
else
{
    echo "Error :".mysqli_error($conn);
}
?>