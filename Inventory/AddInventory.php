<?php
    
    //Function to enable header redirect
    ob_start();

    //Connect to database
    include_once('../Connect.php');

    //include functions to be used
    include_once('InventoryFunctions.php');

    //Check if add is selected
    if(isset($_POST['Add'])){

        $film_id = $_POST["film_id"];
        $store_id = $_POST["store_id"];

        //Add a new inventory entry based on selected film and store
        AddInventory($film_id, $store_id , $conn);
        //Link to go back to Inventory.php
        header("Location: Inventory.php");

    }

?>

<!DOCTYPE HTML>
<html>

    <head>

        <title>Add Inventory</title>
        <script src="../CheckboxValidation.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "../style.css" />
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
        
    </head>

    <body>

        <h2>Add Inventory</h2>

    </body>

    <!--Form to select film and store of new inventory entry-->
    <form method=post>

        <label>Select Film : </label>

            <select id = "film_id" name = "film_id" required>

                <option value="">Choose Film...</option> 
                <?php

                    //List all films in database
                    $films = ListFilms($conn);

                    if(!empty($films)){

                        foreach($films as $film){
                                
                            echo '<option value="'.$film['film_id'].'">';
                            echo $film['film_id'].' '.$film['title'];
                            echo '</option>';
                            echo "\n\t\t\t\t";
                        }
                            
                    }

                ?> 
            </select>

        </br></br>

        <label>Select Store: </label>

            <select id = "store_id" name = "store_id" required>

                <option value="">Choose Store...</option> 
                <?php

                    //List all films in database
                    $stores = ListStore($conn);

                    if(!empty($stores)){

                        foreach($stores as $store){
                                
                            echo '<option value="'.$store['store_id'].'">';
                            echo $store['store_id'].' '.$store['address'].', '.$store['district'];
                            echo '</option>';
                            echo "\n\t\t\t\t";

                        }
                            
                    }

                ?>
            
            </select>
			<br>
		
        <!--Reset the entries-->
		<input class="no" type="reset" value="Reset">
        <!--Select to submit form with confirmation-->
		<button class="yes" type="submit" name="Add" onclick="return CheckConfirm();">Add</button>
        
    </form>

    <!--Link to go back to Inventory.php without making changes-->
	<button class="go" onclick="document.location = 'Inventory.php'">Back</button>

</html>

<?php ob_end_flush(); ?>
