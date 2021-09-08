<!-- Connect with the database -->

<?php
// MongoDB connectionn
require_once ("vendor/autoload.php");

$client = new MongoDB\Client ('mongodb://localhost:27017');
$collection = $client->aunction_db->product;

// MySQL connection
$host = 'localhost';
$user = 'root'; //replace with your database username
$password = 'Anhthu123'; //replace with your database password
$dbname = 'auction'; //replace with your database name
$dsn = '';

try {
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'connection failed: ' . $e->getMessage();
}
?>