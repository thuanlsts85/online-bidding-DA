<!-- Connect with the database -->

<?php
$conn = mysqli_connect("localhost", "root", "Dinhthienly1", "auction");

if(!$conn)
{
    echo "Database connection fail..." ;
}
?>