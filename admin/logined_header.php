<?php
define('BASEPATH', true); //access connection script if you omit this line file will be blank
require '../data_connect.php'; //require connection script

include_once('../script.php');
session_start();
$email = $_SESSION['email'];
$id = $_SESSION['id'];

$sql = 'SELECT * FROM admin WHERE id= $id';
$statement = $pdo->prepare($sql);
$statement->execute([':id' => $id ]);
$admin = $statement->fetch(PDO::FETCH_OBJ);



// $Fname = $Lname = $phone = $balance = $country = $branch_id = $address = '';
// $sql = "SELECT * FROM customer WHERE id='$id'";
// $result = mysqli_query($conn, $sql);
// if(mysqli_num_rows($result) > 0)
// {
// 	while($row = mysqli_fetch_assoc($result))
// 	{
// 		$Fname = $row["Fname"];
// 		$Lname = $row["Lname"];
// 		$phone = $row["phone"];
//     	$balance = $row["balance"];
//     	$country = $row["country"];
//     	$branch_id = $row["branch_id"];
//     	$address = $row["address"];
// 	}
// }
?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a href="Homepage.php" class="navbar-brand">Auction VN</a>
		</div>

		<div class="dropdown navbar-right">
  			<button class="dropbtn">
	  			<?php echo $admin['email']; ?>
  			</button>
  			<div id="myDropdown" class="dropdown-content">
    			<a href="dashboard.php">Profile</a>
    			<a href="../Logout.php">Logout</a>
  			</div>
		</div>

	</div>
</nav>