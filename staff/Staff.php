<?php
	
	//Connect to database
	include_once('../Connect.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>SAKILA | Staff</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
	</head>
	<body>
	
		<nav>
			<ul>
				<li><a id="link" href="/home/Home.php">Home</a></li>
				<li><a id="link" href="/customer/customer.php">Customer</a></li>
				<li><a id="link" href="/film/displayfilm.php">Film</a></li>
				<li><a id="link" href="/Inventory/Inventory.php">Inventory</a></li>
				<li><a id="link" href="/payment/Payment.php">Payment</a></li>
				<li><a id="link" href="/rental/Rental.php">Rental</a></li>
				<li><a id="link" class="active"  href="Staff.php">Staff<a></li>
			</ul>
		</nav>
		
		<h1>
			Our Staffs
		</h1>
		

		<!--Table to display staff-->
		<table>
			<tr>
			    <th>Staff ID</th>
			    <th>Store ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Address</th>
				<th>District</th>
			</tr>
			<?php

				//Check if page is set, if not then set page to 0
				if (isset($_GET['page'])) {
					$page1 = ($_GET['page']*100)-100;
				}
				else{
					$page1 = 0;
				}
				
				//Display staff
				$sql = "SELECT * FROM staff INNER JOIN address ON staff.address_id = address.address_id WHERE active = 1 LIMIT $page1,100;";
				$result = mysqli_query($conn,$sql);
				$resultRows = mysqli_num_rows($result);
				if($resultRows > 0){
					while($row = mysqli_fetch_assoc($result)){
						echo "
						<tr>
						    <td>".$row["staff_id"]."</td>
						    <td>".$row["store_id"]."</td>
							<td>".$row["first_name"]."</td>
							<td>".$row["last_name"]."</td>
							<td>".$row["email"]."</td>
							<td>".$row["address"]."</td>
							<td>".$row["district"]."</td>
						</tr>";
					}
				}
			?>
		</table>
		
		<?php
			$sql2 = "SELECT * FROM staff;";
			$table = mysqli_query($conn,$sql2);
			$rows = mysqli_num_rows($table);

			//Calculate total pages
			$totalpage = $rows / 100;
			$page = ceil($totalpage);
			if (isset($_GET['page'])) {
				$current = $_GET['page'];
			}
			else{
				$current = 1;
			}
			
			//Display pages based on current page and total pages
			$range = 5;			
			echo "<a id=\"page\" href=\"Staff.php?page=1\">First</a>";
			for($num=($current-$range);$num<=($current+$range);$num++){
				if(($num>0)&&($num<=$totalpage+1)){
					if($num==$current){
						echo "<b><a id=\"page\" class=\"current\" href=\"Staff.php?page=$num\">$num</a></b>";
					}
					else{
						echo "<a id=\"page\" href=\"Staff.php?page=$num\">$num</a>"; 
					}
				}
			}
			echo "<a id=\"page\" href=\"Staff.php?page=$page\">Last</a>";
		?>
		<a id="home" href="/home/Home.php">Home</a>
	</body>
</html>