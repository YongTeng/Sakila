<?php

	//Function to allow header redirect
	ob_start();

	//Connect to database
	include_once('../Connect.php');

	//Include functions to be used
	include_once('PaymentFunction.php');
?>

<!DOCTYPE html>
<html>

	<head>
		<title>SAKILA | Payment</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
		<script src="../CheckboxValidation.js"></script>
	</head>
	
	<body>
		<nav>
			<ul>
				<li><a id="link" href="/home/Home.php">Home</a></li>
				<li><a id="link" href="/customer/customer.php">Customer</a></li>
				<li><a id="link" href="/film/displayfilm.php">Film</a></li>
				<li><a id="link" href="/Inventory/Inventory.php">Inventory</a></li>
				<li><a id="link"  class="active"  href="Payment.php">Payment</a></li>
				<li><a id="link" href="/rental/Rental.php">Rental</a></li>
				<li><a id="link" href="/staff/Staff.php">Staff<a></li>
			</ul>
		</nav>
		
		<h1>All Payments</h1>
		
		<!--Form for search-->
		<form action="Payment.php" method="get">
			<input type="text" name="search" placeholder="Search for payment..." />
			<input type="submit" value="Search"/>
		</form>
		
		<?php
			//Check if Delete Payment is selected
            if(isset($_POST['delete'])){

				//Get selected item
				$selectItem = $_POST["selectItem"];
				//Deleting selected Item
                deletePayment($selectItem, $conn);
                header("Refresh:0");
			}
			//Check if Edit Payment is selected
			else if(isset($_POST['edit'])){

				//Passing value of selected Payment to EditPayment.php
				session_start();
				$_SESSION["selectItem"] = $_POST["selectItem"];
				//Link to EditPayment.php
                header("Location: EditPayment.php");
            }
        
        ?>
		
		<br><br>
		
		
		<form method="post">

			<!--Form submission with confirmation-->
			<input type="submit" value="Edit payment" name='edit' onclick="return CheckOnly1()"/>
			<input type="submit" value="Delete payment" name='delete' onclick="return CheckForm();"/>
            
			<!--Display table of Payments-->
			<table>
			
				<tr>
					<th>select</th>
					<th>payment id</th>
					<th>customer name</th>
					<th>staff id</th>
					<th>rental id</th>
					<th>amount</th>
					<th>payment date</th>
					<th>last update</th>
				</tr>
				
				<?php

					//Check if a search is entered, if not use a default value
					if(isset($_GET["search"])){
                        $search = $_GET["search"];
                    }else{
                        $search= "";
                    }
					
					//Function to list payments
					$datas = ListPayment($search, $conn);
				?>
			</table>
		</form>
		
		
		<?php
			//Function to get payment pages
			$x = PaymentPage($search, $conn);
		?>	
		
		<a id="home" href="/home/Home.php">Home</a>
	</body>
</html>


				