<?php

	//Function to list Payments
	function ListPayment($search, $conn){
		//Check if page is set, if not set to 0
		if (isset($_GET['page'])) {
			$page1 = ($_GET['page']*100)-100;
		}
		else{
			$page1 = 0;
		}
		
        if(isset($search)){
            $searchq = $search;
			$searchq = trim($searchq);
			
			//Search based on payment id
            if (is_numeric($searchq)){
                $searchq = (int)$searchq;
                $payment = "SELECT payment.payment_id,customer.first_name,customer.last_name,payment.staff_id,payment.rental_id,payment.amount,payment.payment_date,payment.last_update 
							FROM payment INNER JOIN customer ON customer.customer_id = payment.customer_id WHERE payment.payment_id = $searchq;";
                $result = mysqli_query($conn, $payment) or die("could not search!");
			}
			//Search based on customer name
			else{
				$searchq = preg_replace("#[^0-9a-z]#i"," ", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);
				$payment = "SELECT payment.payment_id,customer.first_name,customer.last_name,payment.staff_id,payment.rental_id,payment.amount,payment.payment_date,payment.last_update 
							FROM payment INNER JOIN customer ON customer.customer_id = payment.customer_id 
							WHERE concat(customer.first_name, ' ', customer.last_name) LIKE '%$searchq%' ORDER BY payment.payment_id ASC
							LIMIT $page1,100;";
				$result = mysqli_query($conn, $payment) or die("could not search!");
			}
        }
		else{

			//Default query if nothing is searched
			$payment = "SELECT payment.payment_id,customer.first_name,customer.last_name,payment.staff_id,payment.rental_id,payment.amount,payment.payment_date,payment.last_update 
					FROM payment INNER JOIN customer ON customer.customer_id = payment.customer_id ORDER BY payment.payment_id ASC LIMIT $page1,100;";
			$result = mysqli_query($conn, $payment) or die("could not search!");
		}

		//Display Payments
		$resultCheck = mysqli_num_rows($result);
		
		if($resultCheck > 0){
			while($data = mysqli_fetch_assoc($result)){
				echo "
					<tr>
						<td><input type=\"checkbox\" name=\"selectItem[]\" value=\"".htmlspecialchars($data['payment_id'])."\"></td>
						<td>".$data["payment_id"]."</td>
						<td>".$data["first_name"]." ".$data["last_name"]."</td>
						<td>".$data["staff_id"]."</td>
						<td>".$data["rental_id"]."</td>
						<td>".$data["amount"]."</td>
						<td>".$data["payment_date"]."</td>
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
	
	//Function to list pages
	function PaymentPage($search, $conn){
        if(isset($search)){
            $searchq = $search;
			$searchq = trim($searchq);
			//Search based on payment id
            if (is_numeric($searchq)){
                $searchq = (int)$searchq;
                $payment = "SELECT payment.payment_id,customer.first_name,customer.last_name,payment.staff_id,payment.rental_id,payment.amount,payment.payment_date,payment.last_update 
							FROM payment INNER JOIN customer ON customer.customer_id = payment.customer_id WHERE payment.payment_id = $searchq;";
                $result = mysqli_query($conn, $payment) or die("could not search!");
			}
			//Search based on customer name
			else{
				$searchq = preg_replace("#[^0-9a-z]#i"," ", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);
				$payment = "SELECT payment.payment_id,customer.first_name,customer.last_name,payment.staff_id,payment.rental_id,payment.amount,payment.payment_date,payment.last_update 
							FROM payment INNER JOIN customer ON customer.customer_id = payment.customer_id WHERE concat(customer.first_name, ' ', customer.last_name) LIKE '%$searchq%' ORDER BY payment.payment_id ASC;";
				$result = mysqli_query($conn, $payment) or die("could not search!");
			}
        }
		else{
			//Default query if nothing is searched
			$payment = "SELECT payment.payment_id,customer.first_name,customer.last_name,payment.staff_id,payment.rental_id,payment.amount,payment.payment_date,payment.last_update 
					FROM payment INNER JOIN customer ON customer.customer_id = payment.customer_id ORDER BY payment.payment_id ASC;";
			$result = mysqli_query($conn, $payment) or die("could not search!");
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
		
		echo "<a id=\"page\" href=\"Payment.php?search=$search&page=1\">First</a>";
		for($num=($current-$range);$num<=($current+$range);$num++){
			if(($num>0)&&($num<=$totalpage+1)){
				if($num==$current){
					echo "<b><a id=\"page\" class=\"current\" href=\"Payment.php?search=$search&page=$num\">$num</a></b>";
				}
				else{
					echo "<a id=\"page\" href=\"Payment.php?search=$search&page=$num\">$num</a>"; 
				}
			}
		}
		echo "<a id=\"page\" href=\"Payment.php?search=$search&page=$page\">Last</a>";
	};
    
	
	//Function to delete payment
    function deletePayment($selectItem, $conn){
        foreach($selectItem as $payment_id){
            $deletesql = "DELETE FROM payment WHERE payment_id = $payment_id";
            mysqli_query($conn, $deletesql) or die("could not delete!");
        }
    }
	
	//Function to edit payment
	function EditPayment($payment_id,$amount,$conn){
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$date = date("Y-m-d h:i:sa");
		$editpaymentsql = "UPDATE payment SET amount = $amount, last_update = '$date' WHERE payment_id = $payment_id;";
		mysqli_query($conn, $editpaymentsql) or die("could not update!");
		
	}
?>