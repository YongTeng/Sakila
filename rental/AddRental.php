<?php

	//Function to allow header redirect
	ob_start();

	//Connect to database
	include_once('../Connect.php');
	
	//Include functions to be used
    include_once('RentalFunction.php');

	//Detect if form is submitted
    if(isset($_POST['Add'])){
        $inventory_id = $_POST["inv_id"];
        $customer_id = $_POST["cus_id"];
        $staff_id = $_POST["staff_id"];
		$amount = $_POST["amount"];
		//Add a new rental
        AddRental($inventory_id,$customer_id,$staff_id,$amount,$conn);
		//Link back to Rental.php
		header("Location: Rental.php");
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Add Rental</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
		<script src="../CheckboxValidation.js"></script>
	</head>
	
	<body>

		<!--Form to enter new rental information-->
		<form method="post">
			<label>Enter inventory id: </label>
			<input type="number" min="0" name="inv_id" required>
			<br>
			<label>Enter customer id: </label>
			<input type="number" min="0" name="cus_id" required>
			<br>
			<label>Enter amount: </label>
			<input type="number" min="0" name="amount" step="0.01" required>
			<br>
			<label>Enter staff id: </label>
			<select name="staff_id">
				<option value="1">1</option>
				<option value="2">2</option>
			</select>
			<br>
			<!--Reset form-->
			<input class="no" type="reset" value="Reset">

			<!--Submit with confirmation-->
			<button type="submit" class="yes" name='Add' onclick="return CheckConfirm();">Edit</button>
		</form>

		<!--Go back to Rental.php without making changes-->
		<button class="go" onclick="document.location = 'Rental.php'">Back</button>
		
			
	</body>
</html>