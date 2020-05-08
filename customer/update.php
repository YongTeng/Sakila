<?php
    //Function to allow header redirect
    ob_start();
    include_once '../Connect.php';

    //Save information from form into variables
    $id = $_POST['CustomerID'];
    $stid = $_POST['StoreID'];
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $email = $_POST['Email'];
    $addrs = $_POST['Address'];
    $dis = $_POST['District'];
    $act = $_POST['Active'];
    $cd = $_POST['phone'];
    $lu = $_POST['LastU'];

    //Query to update form information into database
    $sql = "UPDATE customer INNER JOIN address ON customer.address_id = address.address_id INNER JOIN city ON address.city_id = city.city_id SET customer_id = '$id', store_id = '$stid',
    first_name = '$fname', last_name = '$lname', email = '$email', address = '$addrs', district = '$dis', active = '$act', phone = '$cd', customer.last_update = CURRENT_TIMESTAMP, address.last_update = CURRENT_TIMESTAMP, city.last_update = CURRENT_TIMESTAMP 
    WHERE customer_id = '$id';";
    mysqli_query($conn, $sql);

    //Link back to customer.php after finish query
    header("Location: customer.php");
    ob_end_flush();