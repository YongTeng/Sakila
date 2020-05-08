<?php

    //Function to allow header redirect
    ob_start();

    //Connect to database
    include_once '../Connect.php';

?>
<!DOCTYPE html>
<html>
        <head>
            <link rel="stylesheet" type ="text/css" href="../style.css">
            <link rel="shortcut icon" type ="image/png" href="../icon.png">
            <script src = "../CheckboxValidation.js"></script>
        </head>

        <body>
            <h2>Customer</h2>
                    <form action = "customerdetails.php" method = "POST">
                        <input type = "text" name = "search" placeholder = "Search for Customer Details">
                        <input type = "submit" value = ">>"/>
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
                    <button class = "go" onclick="document.location = 'NewCustomer.php'">Add New Customer</button>

                    <!--Update customer form submission with confirmation-->
                    <form method = "POST">
                        <input type = "submit" name = 'updatecus' value = "Update Customer Details" onclick = "return CheckConfirm();">
                        <?php

                            //Query to display results based on search
                            $csid = $_POST['search'];
                            $csid = trim($csid);
                            $csid = preg_replace("#[^0-9a-z]#i"," ", $csid);
                            $csid = preg_replace('/\s\s+/', ' ', $csid);
                            $sql = "SELECT customer.customer_id, customer.store_id, customer.first_name, customer.last_name, customer.email, address.address, address.district, customer.active, address.phone, customer.last_update FROM customer INNER JOIN address
                            ON customer.address_id = address.address_id WHERE customer.customer_id = '$csid' OR concat(customer.first_name, ' ', customer.last_name) like '%$csid%';";
                            $result = mysqli_query($conn, $sql);
                            $resultcheck = mysqli_num_rows($result);

                            echo '<table border="0" cellspacing="2" cellpadding="2"> 
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
                                    $col8 = $row['active'];
                                    $col9 = $row['phone'];
                                    $col10 = $row['last_update'];

                                    echo '<tr>
                                            <td><input type = "radio" name = "selectItem" value = "'.htmlspecialchars($row['customer_id']).'"></td>
                                            <td>'.$col1.'</td>
                                            <td>'.$col2.'</td>
                                            <td>'.$col3.'</td>
                                            <td>'.$col4.'</td>
                                            <td>'.$col5.'</td>
                                            <td>'.$col6.'</td>
                                            <td>'.$col7.'</td>
                                            <td>'.$col8.'</td>
                                            <td>'.$col9.'</td>
                                            <td>'.$col10.'</td>
                                        </tr>';

                                }
                            }
                            mysqli_query($conn, $sql);
                        ?>
                    </form>
                    
                    <!--Link back to customer.php-->
                    <form action = "customer.php" method = "POST">
                        <input type="submit" value = "Back to Customer Page">
                    </form>
        </body>
</html>

<?php
ob_end_flush();
?>