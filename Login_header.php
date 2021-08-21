<!--
this is the header which is visible after login.
-->

<?php
include_once('script.php');
require_once('data_connect.php');
session_start();
$email = $_SESSION['email'];
$id = $_SESSION['id'];

$Fname = $Lname = $phone = $balance = $country = $branch_id = $address = '';
$sql = "SELECT * FROM customer WHERE id='$id'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		$Fname = $row["Fname"];
		$Lname = $row["Lname"];
		$phone = $row["phone"];
    	$balance = $row["balance"];
    	$country = $row["country"];
    	$branch_id = $row["branch_id"];
    	$address = $row["address"];
	}
}
?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a href="Homepage.php" class="navbar-brand">Auction VN</a>
		</div>

		<div class="dropdown navbar-right">
  			<button class="dropbtn">
	  			<?php echo $email; ?>
  			</button>
  			<div id="myDropdown" class="dropdown-content">
    			<a href="Profile.php">Profile</a>
    			<a href="Logout.php">Logout</a>
  			</div>
		</div>

	</div>
</nav>