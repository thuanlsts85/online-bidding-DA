<!-- <?php
require '../includes/data_connect.php'; //require connection script

 if(isset($_POST['submit'])){  
        try {
            $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


         $id = $_POST['id'];
         $Fname = $_POST['Fname'];
         $Lname = $_POST['Lname'];
         $phone = $_POST['phone'];
         $branch_id = $_POST['branch_id'];
         $email = $_POST['email'];
         $password=md5($_POST['password']); 
          
         //Check if email exists
         $sql = "SELECT COUNT(email) AS num FROM admin WHERE email = :email";
         $stmt = $pdo->prepare($sql);

         $stmt->bindValue(':email', $email);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

         if($row['num'] > 0){
             echo '<script>alert("Email already exists")</script>';
        }
        
       else{

    $stmt = $dsn->prepare("INSERT INTO admin (`id`, `Fname`, `Lname`, `phone`, `branch_id`, `email`, `password`) 
    VALUES (:id, :Fname, :Lname, :phone, :branch_id, :email, :password)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':Fname', $Fname);
    $stmt->bindParam(':Lname', $Lname);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':branch_id', $branch_id);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    
    

   if($stmt->execute()){
    echo '<script>alert("Admin account created.")</script>';
     
   }else{
       echo '<script>alert("An error occurred")</script>';
   }
}
}catch(PDOException $e){
    $error = "Error: " . $e->getMessage();
    echo '<script type="text/javascript">alert("'.$error.'");</script>';
}
     }

?> -->

  <!-- <form class="form-horizontal" action="register.php" method="post">
	<h1>Admin Registration</h1>

    <div class="form-group">
    <label class="control-label col-sm-2" for="id">Identity number:</label>
    <div class="col-sm-6">
      <input type="text" name="id" class="form-control" id="id" placeholder="Enter Identity number">
    </div>
  </div>

	<div class="form-group">
    <label class="control-label col-sm-2" for="Fname">First Name:</label>
    <div class="col-sm-6">
      <input type="text" name="Fname" class="form-control" id="Fname" placeholder="Enter Firstname">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="Lname">Last Name:</label>
    <div class="col-sm-6">
      <input type="text" name="Lname" class="form-control" id="Lname" placeholder="Enter Lastname">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Email:</label>
    <div class="col-sm-6">
      <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="phone">Phone Number:</label>
    <div class="col-sm-6">
      <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter phone number">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="branch_id">City:</label>
    <div class="col-sm-6">
      <label class="radio-inline"><input type="radio" name="branch_id" value=1>Ho Chi Minh</label>
	  <label class="radio-inline"><input type="radio" name="branch_id" value=2>Da Nang</label>
      <label class="radio-inline"><input type="radio" name="branch_id" value=3>Ha Noi</label>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="password">Password:</label>
    <div class="col-sm-6"> 
      <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form> -->