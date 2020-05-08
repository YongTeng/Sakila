<?php

	//Function to allow header redirect
	ob_start();

	//Connect to database
	include_once('../Connect.php');

	//Include functions to be used
	include_once('RentalFunction.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>SAKILA | Rental</title>
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
				<li><a id="link" href="/payment/Payment.php">Payment</a></li>
				<li><a id="link" class="active"  href="Rental.php">Rental</a></li>
				<li><a id="link" href="/staff/Staff.php">Staff<a></li>
			</ul>
		</nav>
		
		<h1>
			All Rentals
		</h1>

		<!--Form for filtering results-->
		<form action="Rental.php" method="get">
			<select name="filter">
				<option value="all">All</option>
				<option value="returned">Returned only</option>
				<option value="unreturned">Unreturned only</option>
			</select>
			<input type="submit" value="Filter"/>
		</form>

		<!--Form for search-->
		<form action="Rental.php" method="get">
			<input type="text" name="search" placeholder="Search for rental...">
			<input type="submit" value="Search"/>
		</form>
		
		<?php

			//Check if Delete rental is selected
            if(isset($_POST['delete'])){

				//Get selected Item
				$selectItem = $_POST["selectItem"];
				//Delete selected item
                deleteRental($selectItem, $conn);
                header("Refresh:0");
			}
			
			//Check if Edit rental is selected
			else if(isset($_POST['edit'])){

				//Get selected Item
				$selectItem = $_POST["selectItem"];
				//edit selected item
				editRental($selectItem,$conn);
				header("Refresh:0");
			}
			//Check if Add rental is selected
            else if(isset($_POST['add'])){

				//Link to AddRental.php
                header("Location: AddRental.php");
            }
        
        ?>
		
		<br><br>
		
		<form method="post">

			<!--Form submission with confirmation-->
			<input type="submit" value="Add rental" name='add' onclick="AddRental.php"/>
			<input type="submit" value="Return rental" name='edit' onclick="return CheckForm()"/>
			<input type="submit" value="Delete rental" name='delete' onclick="return CheckForm();"/>
			
			<!--Display table of rentals-->
			<table>
				<tr>
					<th>select</th>
					<th>rental id</th>
					<th>rental date</th>
					<th>inventory id</th>
					<th>customer name</th>
					<th>return date</th>
					<th>staff id</th>
					<th>last update</th>
				</tr>
				
				<?php

					//Check if filter is selected, if not use search
					if(isset($_GET["filter"])){

						//Filter based on type selected
						$filter = $_GET["filter"];
						$datas = FilterRental($filter, $conn);
					}
					else
					{
						//Check if a search is entered, if not use a default value
						if(isset($_GET["search"])){
							$search = $_GET["search"];
						}else{
							$search = "";
						}

						//Function to list rentals
						$datas = ListRental($search, $conn);
					}
				?>
			</table>
		</form>

		
		
		<?php

			//Check if search is entered
			if(isset($_GET["search"])){

				//Function to get rental pages based on search
				$x = RentalSearchPage($search, $conn);

			}
			//Check if filter is entered
			else if(isset($_GET["filter"])){

				//Function to get rental pages based on filter
				$x = RentalFilterPage($filter, $conn);

			}
			else{

				//Function to get rental pages based on search
				$x = RentalSearchPage($search, $conn);
			}
		?>
		<a id="home" href="/home/Home.php">Home</a>
	</body>

</html>