<?php
    //Function to allow header redirect
    ob_start();
    include_once '../Connect.php';

        //Passing value of selected customer id from customer.php/customerdetails.php
        session_start();
        $selectItem = $_SESSION["selectItem"];
    
    //Query to get information based on the selected customer id
    $sql = "SELECT customer.customer_id, customer.store_id, customer.first_name, customer.last_name, customer.email, address.address, address.district, customer.active, address.phone, customer.last_update FROM customer INNER JOIN address 
    ON customer.address_id = address.address_id WHERE customer.customer_id = $selectItem;";
    
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
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

    }
    }

?>

<!DOCTYPE html>

<html>
    <head>
    <script src = "../CheckboxValidation.js"></script>
    <link rel="stylesheet" type ="text/css" href="../style.css">
    <title>Updating Customer Details</title>
    </head>

    <body>

        <!--Form to update customer details with the original values provided-->
        <h2>Updating Customer Details</h2>
            <form action = "update.php" method = "POST">
            Customer ID :<br>
            <input type = "text" name = "CustomerID" value = "<?php echo $col1?>">
            <br>
            Store ID :<br>
            <input type = "text" name = "StoreID" value = "<?php echo $col2?>">
            <br>
            First Name :<br>
            <input type = "text" name = "Fname" value = "<?php echo $col3?>">
            <br>
            Last Name :<br>
            <input type = "text" name = "Lname" value = "<?php echo $col4?>">
            <br>
            Email :<br>
            <input type = "text" name = "Email" value = "<?php echo $col5?>">
            <br>
            Address :<br>
            <input type = "text" name = "Address" value = "<?php echo $col6?>">
            <br>
            District :<br>
            <input type = "text" name = "District" value = "<?php echo $col7?>">
            <br>
            Active :<br>
            <input type = "text" name = "Active" value = "<?php echo $col9?>">
            <br>
            Phone Number :<br>
            <input type = "text" name = "phone" value = "<?php echo $col10?>">
            <br>

            <button class="yes" type = "submit">Update Customer Details</button>
        </form>
        <!--Link to go back to customer.php without any changes-->
		<button class="go" onclick="document.location = 'customer.php'">Back</button>
    </body>
</html>

<?php
    ob_end_flush();
?>