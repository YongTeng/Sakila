<?php

	//Function to allow header redirect
	ob_start();

	//Connect to database
	include_once('../Connect.php');
	
	//Include functions to be used
    include_once('PaymentFunction.php');

	///Passing value of selected Payment id from Payment.php
	session_start();
    $selectItem = $_SESSION["selectItem"];
	
	//Get the payment id
	foreach($selectItem as $try){
		
		$payment_id = $try;
		
	}
	
	//Detect if form is submitted
    if(isset($_POST['Edit'])){
		$amount = $_POST["amount"];
		//Edit the ammount of the selected payment
		EditPayment($payment_id,$amount,$conn);
		//Link back to Payment.php
        header("Location: Payment.php");
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit payment</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
		<script src="../CheckboxValidation.js"></script>
	</head>
	
	<body>

		<!--Form to edit payment ammount-->
		<form method="post">
			<label>Enter amount: </label>
			<input type="number" min="0" name="amount" step="0.01" required>
			<br>
			<!--Reset form-->
			<input class="no" type="reset" value="Reset">
			<!--Submit form with confirmation-->
			<button type="submit" class="yes" name='Edit' onclick="return CheckConfirm();">Edit</button>
		</form>

		<!--Link to return to Payment.php without making any changes-->
		<button class="go" onclick="document.location = 'Payment.php'">Back</button>
		
			
	</body>
</html>