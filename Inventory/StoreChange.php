<?php
    
    //Function to allow header redirect
    ob_start();

    //Connect to database
    include_once('../Connect.php');

    //Include functions to be used
    include_once('InventoryFunctions.php');

    //Check if select is selected
    if(isset($_POST['Select'])){

        //Passing value of selected inventory id from Inventory.php
        session_start();
        $selectItem = $_SESSION["selectItem"];

        //Get selected store
        $selectStore= $_POST["selectStore"];

        //Change store of selected item
        StoreChange($selectItem, $selectStore, $conn);

        //Link back to Inventory.php
        header("Location: Inventory.php");

    } 
?>

<!DOCTYPE HTML>
<html>

    <head>

        <title>Change Store</title>
        <script src="../CheckboxValidation.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "../style.css" />
		<link rel="shortcut icon" type ="image/png" href="../icon.png">

    </head>

    <body>
    
        <h3>Select the store to change to:</h3>
        <!--Form to select store-->
        <form method="post">

            <!--Table to display available stores-->
            <table>

                <th>Select</th>
                <th>Store_id</th>
                <th>Manager</th>
                <th>Address</th>
                <th>District</th>
            
                <?php

                    //List avaible stores
                    $datas = ListStore($conn);

                    if(!empty($datas)){

                        foreach($datas as $data){
                            
                            echo "<tr>";
                            echo '<td><input type="radio" name="selectStore" value="'. htmlspecialchars($data['store_id']) . '"></td>';
                            echo "<td>".$data["store_id"]."</td><td>".$data["first_name"]." ".$data["last_name"] . "</td><td>".$data["address"]."</td><td>".$data["district"]."</td>";
                            echo "</tr>";
                            echo "\n\t\t\t\t";

                        }
    
                    }

                ?>  	

            </table>

            <!--Sumbit with confirmation-->
			<button class="yes" type="submit" name="Select" onclick="return CheckConfirm();">Select</button>

            <?php

                if(empty($datas)){

                    echo "<p>No stores found!</p>";

                }

            ?>

        </form>

        <!--Link back to Inventory.php-->
        <button class="go" onclick="document.location = 'Inventory.php'">Back</button>
    </body>

</html>

<?php ob_end_flush(); ?>