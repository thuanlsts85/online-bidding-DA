<!--
Into this file, we create a layout for registration page.
-->
<?php
include_once('Header.php');
include_once('script.php');
?>

<div id="formRegistration">
<form class="form-horizontal" action="Register.php" method="POST">
	<h1>User Registration</h1>

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
    <label class="control-label col-sm-2" for="balance">Balance:</label>
    <div class="col-sm-6">
      <input type="number" name="balance" class="form-control" id="balance" placeholder="Enter your balance">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="country">Country:</label>
    <div class="col-sm-6">
      <label class="radio-inline"><input type="radio" name="country" value="Vietnam">Vietnam</label>
      <label class="radio-inline"><input type="radio" name="country" value="Others">Others</label>
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
    <label class="control-label col-sm-2" for="address">Address:</label>
    <div class="col-sm-6">
      <input type="text" name="address" class="form-control" id="address" placeholder="Enter your address">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="img">Profile Image:</label>
    <div class="col-sm-6">
      <input type="text" name="img" class="form-control" id="img" placeholder="Put your image link here">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Password:</label>
    <div class="col-sm-6"> 
      <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="create" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>
</div>