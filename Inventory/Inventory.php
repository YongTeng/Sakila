<?php
    
    //Function to enable header redirect
    ob_start();

    //Connect to Database
    include_once('../Connect.php');

    //Include functions to be used
    include_once('InventoryFunctions.php');

    //Check if a search is entered, if not use a default value
    if(isset($_GET["search"])){

        $search = $_GET["search"];

    }else{

        $search= "";

    }

    //Determine the number of pages based on search
    $totalpage = PageCount($search, $conn);

?>

<!DOCTYPE html>
<html>

    <head>

        <title>SAKILA | Inventory</title>
        <script src="../CheckboxValidation.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "../style.css" />
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
        
    </head>

    <body>
        <nav>
			<ul>
				<li><a id="link" href="/home/Home.php">Home</a></li>
				<li><a id="link" href="/customer/customer.php">Customer</a></li>
				<li><a id="link" href="/film/displayfilm.php">Film</a></li>
				<li><a id="link" class="active" href="Inventory.php">Inventory</a></li>
				<li><a id="link" href="/payment/Payment.php">Payment</a></li>
				<li><a id="link" href="/rental/Rental.php">Rental</a></li>
				<li><a id="link" href="/staff/Staff.php">Staff<a></li>
			</ul>
		</nav>
        <h2>Inventory Management</h2>

        
        <!--Form for search-->
        <form action="Inventory.php" method="get">

            <input id = "searchentry" type="text" name="search" placeholder="Search for inventory..." />
            <input type="submit" value="Search"/>

        </form>
        <br><br>

        <?php

            //Check if Delete is selected
            if(isset($_POST['Delete'])){
                
                //Deleting selected inventory
                $selectItem = $_POST["selectItem"];
                deleteInventory($selectItem, $conn);
                header("Refresh:0");

            }
            //Check if Change Store Location is selected
            elseif(isset($_POST['ChangeStore'])){
                
                //Passing id of selected inventory to StoreChange.php
                session_start();
                $_SESSION["selectItem"] = $_POST["selectItem"];
                header("location: StoreChange.php");

            }
            //Check if Add is selected
            elseif(isset($_POST['AddInventory'])){
                
                //Link to AddInventory.php
                header("Location: AddInventory.php");

            }
        
        ?>
             
        <form method="post">

            <!--Form submission with confirmation-->
            <input type="submit" value="Delete" name='Delete' onclick="return CheckForm();"/>
            <input type="submit" value="Change Store Location" name='ChangeStore' onclick ="return CheckForm();"/>
            <input type="submit" value="Add" name='AddInventory'/>

            <!--Display table of Inventory-->
            <table>

                <th>Select</th>
                <th>Inventory ID</th>
                <th>Film ID</th>
                <th>Title</th>
                <th>Store ID</th>
            
                <?php
                    
                    //Check if a page is selected, if not, return default value 1
                    if (isset($_GET['page'])) {

                        $page = $_GET['page'];
        
                    }
                    else{
        
                        $page = 1;
        
                    }
                    
                    //Get list of inventory based on search and page
                    $datas = ListInventory($search, $page, $conn);

                    if(!empty($datas)){

                        foreach($datas as $data){
                            
                            echo "<tr>";
                            echo '<td><input type="checkbox" name="selectItem[]" value="'. htmlspecialchars($data['inventory_id']) . '"></td>';
                            echo "<td>".$data["inventory_id"]."</td><td>".$data["film_id"] . "</td><td>".$data["title"]."</td><td>".$data["store_id"]."</td>";
                            echo "</tr>";
                            echo "\n\t\t\t\t";

                        }
                        
                    }

                

                ?>  

            </table>

            <?php
            
                    if(empty($datas)){

                        echo "<p>No results found!</p>";

                    }
            
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
            $range = 5;
            echo "<a id=\"page\" href=\"Inventory.php?search=$search&page=1\">First</a>";
            for($num=($current-$range);$num<=($current+$range);$num++){
                if(($num>0)&&($num<=$totalpage)){
                    if($num==$current){
                        echo "<b><a id=\"page\" class=\"current\" href=\"Inventory.php?search=$search&page=$num\">$num</a></b>";
                    }
                    else{
                        echo "<a id=\"page\" href=\"Inventory.php?search=$search&page=$num\">$num</a>"; 
                    }
                }
            }
            echo "<a id=\"page\" href=\"Inventory.php?search=$search&page=$totalpage\">Last</a>";

        
        ?>
        <!--Link back to Home.php-->
		<a id="home" href="/home/Home.php">Home</a>
    </body>

</html>

<?php ob_end_flush(); ?>