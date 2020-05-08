<?php

    //Function to allow header redirect
    ob_start();
    
    //Connect to database
    include_once '../Connect.php';
    include_once 'pagecount.php';

    //Check if a search is entered, if not use a default value
    if(isset($_GET["Search"])){

        $Search = $_GET["Search"];

    }else{

        $Search= "";

    }

    //Calculate total page based on queries (limit of 100 queries per page)
    $totalpage = PageCount($Search, $conn);

?>

<!DOCTYPE html>
    <html>
        <head>
			<title>SAKILA | Customers</title>
            <link rel="stylesheet" type ="text/css" href="../style.css">
			<link rel="shortcut icon" type ="image/png" href="../icon.png">
            <script src = "../CheckboxValidation.js"></script>
        </head>

        <body>
		<nav>
			<ul>
				<li><a id="link" href="/home/Home.php">Home</a></li>
				<li><a id="link" class="active" href="customer.php">Customer</a></li>
				<li><a id="link" href="/film/displayfilm.php">Film</a></li>
				<li><a id="link" href="/Inventory/Inventory.php">Inventory</a></li>
				<li><a id="link" href="/payment/Payment.php">Payment</a></li>
				<li><a id="link" href="/rental/Rental.php">Rental</a></li>
				<li><a id="link" href="/staff/Staff.php">Staff<a></li>
			</ul>
		</nav>
            <h2>Customers</h2><br>

            <!--Form for search-->
            <form action = "customerdetails.php" method = "POST">
                <input type = "text" name = "search" placeholder = "Search for customer...">
                <input type = "submit" value = "Search"/>
            </form>

            <?php
            
                //Check if Update customer details is selected and redirect to UpdateCustomer.php
                if(isset($_POST['updatecus'])){

                    //Passing value of selected customer id to UpdateCustomer.php
                    session_start();
                    $_SESSION["selectItem"] = $_POST["selectItem"];
                    header("Location: UpdateCustomer.php");
                }

            ?>

            <!--Link to NewCustomer.php-->
            <button class="go" onclick="document.location = 'NewCustomer.php'">Add New Customer</button>

            <!--Update customer form submission with confirmation-->
            <form method = "POST">
				
                <input type = "submit" name = 'updatecus' value = "Update Customer Details" onclick = "return CheckConfirm();">

            <?php
                
                //Check if a page is selected, if not, return default value 1
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                }
                else{
                    $page = 1;
                }

                //Query to display the customers based on page
                $start_from = ($page -1) *100;

                $sql = "SELECT customer.customer_id, customer.store_id, customer.first_name, customer.last_name, customer.email, address.address, address.district, customer.active, address.phone, customer.last_update 
                FROM customer INNER JOIN address ON customer.address_id = address.address_id LIMIT $start_from, 100;";
                $result = mysqli_query($conn, $sql);
                $resultcheck = mysqli_num_rows($result);

                //Displaying table based on query results
                echo '<table> 
                    <tr> 
                        <th> <font face="Arial">Select</font> </th>
                        <th> <font face="Arial">Customer ID</font> </th> 
                        <th> <font face="Arial">Store ID</font> </th> 
                        <th> <font face="Arial">First Name</font> </th> 
                        <th> <font face="Arial">Last Name</font> </th> 
                        <th> <font face="Arial">Email</font> </th>
                        <th> <font face="Arial">Address</font> </th>
                        <th> <font face="Arial">District</font> </th>
                        <th> <font face="Arial">Active</font> </th> 
                        <th> <font face="Arial">Phone Number</font> </th> 
                        <th> <font face="Arial">Last Update</font> </th>  
                    </tr>';

                if($resultcheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $col1 = $row['customer_id'];
                        $col2 = $row['store_id'];
                        $col3 = $row['first_name'];
                        $col4 = $row['last_name'];
                        $col5 = $row['email'];
                        $col6 = $row['address'];
                        $col7 = $row['district'];
                        $col9 = $row['active'];
                        $col10 = $row['phone'];
                        $col11 = $row['last_update'];

                        echo '<tr>
                                <td><input type = "radio" name = "selectItem" required value = "'.htmlspecialchars($row['customer_id']).'"></td>
                                <td>'.$col1.'</td>
                                <td>'.$col2.'</td>
                                <td>'.$col3.'</td>
                                <td>'.$col4.'</td>
                                <td>'.$col5.'</td>
                                <td>'.$col6.'</td>
                                <td>'.$col7.'</td>
                                <td>'.$col9.'</td>
                                <td>'.$col10.'</td>
                                <td>'.$col11.'</td>
                            </tr>';

                    }
                }
				echo '</table>';
            ?>
            </form>

            <?php

            //Check if a page is selected, if not, return default value 1
            if (isset($_GET['page'])) {
                $current = $_GET['page'];
            }
            else{
                $current = 1;
            }

            //Display available pages based on the current page and total number of pages
            $range = 8;
            echo "<a id=\"page\" href=\"customer.php?search=$Search&page=1\">First</a>";
            for($num=($current-$range);$num<=($current+$range);$num++){
                if(($num>0)&&($num<=$totalpage)){
                    if($num==$current){
                        echo "<b><a id=\"page\" class=\"current\" href=\"customer.php?search=$Search&page=$num\">$num</a></b>";
                    }
                    else{
                        echo "<a id=\"page\" href=\"customer.php?search=$Search&page=$num\">$num</a>"; 
                    }
                }
            }
            echo "<a id=\"page\" href=\"customer.php?search=$Search&page=$totalpage\">Last</a>";
            ?>
			<a id="home" href="/home/Home.php">Home</a>
        </body>
    </html>
    <?php
        ob_end_flush();
    ?>