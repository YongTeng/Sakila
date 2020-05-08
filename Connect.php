<?php

    $servername = "mercury";
    $username = "hfyyk4_hfyyk4";
    $password = "DatabaseBitch2020";
    $dbname = "hfyyk4_sakila";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>