<?php

	//Function to list rentals based on search
    function ListRental($search, $conn){

		//Check if pae is set, if not set to 0
		if (isset($_GET['page'])) {
			$page1 = ($_GET['page']*100)-100;
		}
		else{
			$page1 = 0;
		}
		
		
		if(isset($search)){
            $searchq = $search;
			$searchq = trim($searchq);
			
			//Search based on rental id
            if (is_numeric($searchq)){
                $searchq = (int)$searchq;
                $rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
							FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id WHERE rental.rental_id = $searchq
							LIMIT $page1,100;";
				$result = mysqli_query($conn, $rental) or die("could not search!");
			}
			//Search based on customer name
			else{
	
				$searchq = preg_replace("#[^0-9a-z]#i"," ", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);
				$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
							FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id 
							WHERE CONCAT(customer.first_name, ' ', customer.last_name) LIKE '%$searchq%' ORDER BY rental.rental_id ASC
							LIMIT $page1,100;";
				$result = mysqli_query($conn, $rental) or die("could not search!");
			}
		}
		//Default query if nothing is searched
		else{
			$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
						FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id ORDER BY rental.rental_id ASC
						LIMIT $page1,100;";
			$result = mysqli_query($conn, $rental) or die("could not search!");
		}
		
		//Display rentals
		$resultCheck = mysqli_num_rows($result);
		
        if($resultCheck > 0){
			while($data = mysqli_fetch_assoc($result)){
				echo "
					<tr>
						<td><input type=\"checkbox\" name=\"selectItem[]\" value=\"".htmlspecialchars($data['rental_id'])."\"></td>
						<td>".$data["rental_id"]."</td>
						<td>".$data["rental_date"]."</td>
						<td>".$data["inventory_id"]."</td>
						<td>".$data["first_name"]." ".$data["last_name"]."</td>
						<td>".$data["return_date"]."</td>
						<td>".$data["staff_id"]."</td>
						<td>".$data["last_update"]."</td>
					</tr>";
			}
		}
		else{
			echo "
				<tr>
					<td colspan=\"8\">No results found!</td>
				</tr>
				";
		}
    }
	
	//Function to list rental based on filter
	function FilterRental($filter, $conn){

		//Check if page is set, if not set to 0
		if (isset($_GET['page'])) {
			$page1 = ($_GET['page']*100)-100;
		}
		else{
			$page1 = 0;
		}
		if(isset($filter)){
			$filter1 = $filter;
			$filter1 = trim($filter1);

			//All rentals
            if($filter1=="all"){
				$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
							FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id ORDER BY rental.rental_id
							LIMIT $page1,100";
			}
			//Returned rentals only
			else if($filter1=="returned"){
				$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
							FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id WHERE rental.return_date != 0 ORDER BY rental.rental_id
							LIMIT $page1,100";
			}
			//Unreturned rentals only
			else{
				$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
							FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id WHERE rental.return_date = 0 ORDER BY rental.rental_id
							LIMIT $page1,100";
			}
		}
		//Default query if nothing is filtered
		else{
			$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
						FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id ORDER BY rental.rental_id
						LIMIT $page1,100";
		}

		//Display Rentals
		$result = mysqli_query($conn, $rental) or die("could not search!");
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){
			while($data = mysqli_fetch_assoc($result)){
				echo "
					<tr>
						<td><input type=\"checkbox\" name=\"selectItem[]\" value=\"".htmlspecialchars($data['rental_id'])."\"></td>
						<td>".$data["rental_id"]."</td>
						<td>".$data["rental_date"]."</td>
						<td>".$data["inventory_id"]."</td>
						<td>".$data["first_name"]." ".$data["last_name"]."</td>
						<td>".$data["return_date"]."</td>
						<td>".$data["staff_id"]."</td>
						<td>".$data["last_update"]."</td>
					</tr>";
			}
		}
		else{
			echo "
				<tr>
					<td colspan=\"8\">No results found!</td>
				</tr>
				";
		}
	}
	
	//Function to list pages based on search
	function RentalSearchPage($search, $conn){
		if(isset($search)){
            $searchq = $search;
			$searchq = trim($searchq);
			//Search based on rental id
            if (is_numeric($searchq)){
                $searchq = (int)$searchq;
                $rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
							FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id WHERE rental.rental_id = $searchq;";
				$result = mysqli_query($conn, $rental) or die("could not search!");
			}
			//Search based on customer name
			else{
				$searchq = preg_replace("#[^0-9a-z]#i"," ", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);
				$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
							FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id WHERE CONCAT(customer.first_name, ' ', customer.last_name)  LIKE '%$searchq%' ORDER BY rental.rental_id ASC;";
				$result = mysqli_query($conn, $rental) or die("could not search!");
			}
		}
		//Default query if nothing is searched
		else{
			$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
						FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id ORDER BY rental.rental_id ASC;";
			$result = mysqli_query($conn, $rental) or die("could not search!");
		}
        
		$resultCheck = mysqli_num_rows($result);
		
		//Find the total page
		$totalpage = $resultCheck / 100;
		$page = ceil($totalpage);

		//Check if page is set, if not set to 1
		if (isset($_GET['page'])) {
			$current = $_GET['page'];
		}
		else{
			$current = 1;
		}
		
		//Display list of available pages
		$range = 5;
		
			echo "<a id=\"page\" href=\"Rental.php?search=$search&page=1\">First</a>";
			for($num=($current-$range);$num<=($current+$range);$num++){
				if(($num>0)&&($num<=$totalpage+1)){
					if($num==$current){
						echo "<b><a id=\"page\" class=\"current\" href=\"Rental.php?search=$search&page=$num\">$num</a></b>";
					}
					else{
						echo "<a id=\"page\" href=\"Rental.php?search=$search&page=$num\">$num</a>"; 
					}
				}
			}
			echo "<a id=\"page\" href=\"Rental.php?search=$search&page=$page\">Last</a>";
		
		
	}
	
	//Function to list pages based on filter
	function RentalFilterPage($filter, $conn){
		if(isset($filter)){
			$filter1 = $filter;
			$filter1 = trim($filter1);

			//All rentals
            if($filter1=="all"){
				$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
						FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id ORDER BY rental.rental_id";
			}
			//Returned only
			else if($filter1=="returned"){
				$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
						FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id WHERE rental.return_date != 0 ORDER BY rental.rental_id";
			}
			//Unreturned only
			else{
				$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
						FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id WHERE rental.return_date = 0 ORDER BY rental.rental_id";
			}
		}
		//Default query when nothing is filtered
		else{
			$rental = "SELECT rental.rental_id,rental.rental_date,rental.inventory_id,customer.first_name,customer.last_name,rental.return_date,rental.staff_id,rental.last_update 
						FROM rental INNER JOIN customer ON customer.customer_id = rental.customer_id ORDER BY rental.rental_id";
		}
		$result = mysqli_query($conn, $rental) or die("could not search!");
		$resultCheck = mysqli_num_rows($result);
		
		//Find the total page
		$totalpage = $resultCheck / 100;
		$page = ceil($totalpage);

		//Check if page is set, if not set to 1
		if (isset($_GET['page'])) {
			$current = $_GET['page'];
		}
		else{
			$current = 1;
		}
		
		//Display list of available pages
		$range = 5;
		
		if($filter=="all"){
			echo "<a id=\"page\" href=\"Rental.php?filter=all&page=1\">First</a>";
			for($num=($current-$range);$num<=($current+$range);$num++){
				if(($num>0)&&($num<=$totalpage+1)){
					if($num==$current){
						echo "<b><a id=\"page\" class=\"current\" href=\"Rental.php?filter=all&page=$num\">$num</a></b>";
					}
					else{
						echo "<a id=\"page\" href=\"Rental.php?filter=all&page=$num\">$num</a>"; 
					}
				}
			}
			echo "<a id=\"page\" href=\"Rental.php?filter=all&page=$page\">Last</a>";
		}
		else if($filter=="returned"){
			echo "<a id=\"page\" href=\"Rental.php?filter=returned&page=1\">First</a>";
			for($num=($current-$range);$num<=($current+$range);$num++){
				if(($num>0)&&($num<=$totalpage+1)){
					if($num==$current){
						echo "<b><a id=\"page\" class=\"current\" href=\"Rental.php?filter=returned&page=$num\">$num</a></b>";
					}
					else{
						echo "<a id=\"page\" href=\"Rental.php?filter=returned&page=$num\">$num</a>"; 
					}
				}
			}
			echo "<a id=\"page\" href=\"Rental.php?filter=returned&page=$page\">Last</a>";
		}
		else{
			echo "<a id=\"page\" href=\"Rental.php?filter=unreturned&page=1\">First</a>";
			for($num=($current-$range);$num<=($current+$range);$num++){
				if(($num>0)&&($num<=$totalpage+1)){
					if($num==$current){
						echo "<b><a id=\"page\" class=\"current\" href=\"Rental.php?filter=unreturned&page=$num\">$num</a></b>";
					}
					else{
						echo "<a id=\"page\" href=\"Rental.php?filter=unreturned&page=$num\">$num</a>"; 
					}
				}
			}
			echo "<a id=\"page\" href=\"Rental.php?filter=unreturned&page=$page\">Last</a>";
		}
	}
	
	//Function to delete rental
    function deleteRental($selectItem, $conn){
        foreach($selectItem as $rental_id){
            $deletesql = "DELETE FROM rental WHERE rental_id = $rental_id";
            mysqli_query($conn, $deletesql) or die("could not delete!");
        }
    }
	
	//Function to edit rental
	function EditRental($selectItem,$conn){
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$date = date("Y-m-d h:i:sa");
		
		foreach($selectItem as $rental_id){
			$editrentalsql = "UPDATE rental SET return_date = '$date', last_update = '$date' WHERE rental_id = $rental_id;";
			mysqli_query($conn, $editrentalsql) or die("could not update!");
		}
	}

	//Function to add rental
    function AddRental($inventory_id,$customer_id,$staff_id,$amount,$conn){
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$date = date("Y-m-d h:i:sa");

        $addrentalsql = "INSERT INTO rental (rental_date,inventory_id,customer_id,return_date,staff_id,last_update) VALUES ('$date',$inventory_id,$customer_id,'',$staff_id,'$date')";
        mysqli_query($conn, $addrentalsql) or die("could not update!");
		$id = mysqli_insert_id($conn);
		$addpaymentsql = "INSERT INTO payment (customer_id,staff_id,rental_id,amount,payment_date,last_update) VALUES ($customer_id,$staff_id,$id,$amount,'$date','$date')";
		mysqli_query($conn, $addpaymentsql) or die("could not update!"); 
    }

?>