<!--
Into this file, we write a code for display user information.
-->

<?php

?>

<div id="account">
<div class="col-lg-6 col-sm-6">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" src="http://lorempixel.com/100/100/people/9/">
        </div>
        <!-- <div class="useravatar">
            <img alt="" src="img/user.svg">
        </div> -->
        <div class="card-info"> <span class="card-title"><?php echo $Fname." ".$Lname; ?></span>

        </div>
    </div>
    <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" id="stars" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">Information</div>
            </button>
        </div>
        
    </div>

        <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
          <table class="table">

            <tr>
          		<td>Identity Number</td>
          		<td><?php echo $id; ?></td>
          	</tr>

          	<tr>
          		<td>First Name</td>
          		<td><?php echo $Fname; ?></td>
          	</tr>

          	<tr>
          		<td>Last Name</td>
          		<td><?php echo $Lname; ?></td>
          	</tr>

          	<tr>
          		<td>Phone Number</td>
          		<td><?php echo $phone; ?></td>
          	</tr>

          	<tr>
          		<td>Email</td>
          		<td><?php echo $email; ?></td>
          	</tr>

            <tr>
          		<td>Balance</td>
          		<td><?php echo $balance.' '.'VND'; ?></td>
          	</tr>

            <tr>
          		<td>Country</td>
          		<td><?php echo $country; ?></td>
          	</tr>

            <tr>
          		<td>City</td>
          		<td><?php echo $branch_id; ?></td>
          	</tr>

            <tr>
          		<td>Address</td>
          		<td><?php echo $address; ?></td>
          	</tr>
          </table>
        </div>
        
      </div>
    </div>
    
    </div>
    </div>    
