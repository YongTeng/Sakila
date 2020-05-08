<?php

    //Function to allow header redirect
    ob_start();

    //Connect to Database
    include_once '../Connect.php';

    //Query to get list of available cities
    $sql = "SELECT city FROM city;";
    $result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type ="text/css" href="../style.css">
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
    </head>

    <body>
        <h2>Customer details</h2>

        <!--Form to enter customer information (Redirects to signup.php on submit)-->
        <form action = "signup.php" method = "POST">
            Address :<br>
            <input type = "text" name = "Address" placeholder = "Address">
            <br>
            District :<br>
            <input type = "text" name = "District" placeholder = "District">
            <br>
            City :<br>
            <select name = "city">
                <?php
                  while($rows = $result->fetch_assoc()){
                      $city = $rows['city'];
                      echo "<option value = '$city'>$city</option>";
                  }
                  ?>
            </select>
            <br>           
            Postal Code :<br>
            <input type = "number" name = "PostalCode" placeholder = "Postal Code">
            <br>
            Phone Number :<br>
            <input type = "number" name = "PhonNumber" placeholder = "Phone Number">
            <br>
            First Name :<br>
            <input type = "text" name = "FirstName" placeholder = "First Name">
            <br>
            Last Name :<br>
            <input type = "text" name = "LastName" placeholder = "Last Name">
            <br>
            Email :<br>
            <input type = "text" name = "Email" placeholder = "johndoe@sakilacustomer.org">
            <br>

            <!--Reset entered values-->
			<input class="no" type="reset" value="Reset">

            <!--Submit form-->
            <button class="yes" type = "submit" name ="submit">Sign up</button>
        </form>

        <!--Link to go back to customer.php without making any changes-->
		<button class="go" onclick="document.location = 'customer.php'">Back</button>
    </body>
</html>
<?php
ob_end_flush();
?>