<?php
    //Function to allow header redirect
    ob_start();
    //Connect to database
    include_once '../Connect.php';

    //Save information from form into variables
    $addrs = $_POST['Address'];
    $dis = $_POST['District'];
    $cty = $_POST['city'];
    $postal_code = $_POST['PostalCode'];
    $phone_number = $_POST['PhonNumber'];
    $first_name = $_POST['FirstName'];
    $last_name = $_POST['LastName'];
    $emel = $_POST['Email'];

    //Query to enter form information into database
    $sql = "INSERT INTO address(address, district, city_id, postal_code, phone, last_update) VALUES ('$addrs', '$dis', (SELECT city.city_id FROM city WHERE city.city = '$cty'), '$postal_code', '$phone_number', CURRENT_TIMESTAMP);";
    $seql = "INSERT INTO customer(store_id, first_name, last_name, email, address_id, active, create_date, last_update) VALUES ( 1, '$first_name', '$last_name', '$emel', last_insert_id(), 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
    mysqli_query($conn, $sql);
    mysqli_query($conn, $seql);

    //Link back to customer.php after finish query
    header("Location: customer.php");
    ob_end_flush();

?>