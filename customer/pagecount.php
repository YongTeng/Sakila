<?php
    
    //Function for counting number of pages based on search
    function PageCount($search, $conn){

        //Default query if nothing is searched
        $sql = "SELECT * FROM customer";
        $result = mysqli_query($conn, $sql) or die("could not search!");

        if(isset($search)){

            $searchq = $search;
            $searchq = trim($searchq);

            //Search based on id
            if (is_numeric($searchq)){

                $searchq = (int)$searchq;

                $sql = "SELECT * FROM customer WHERE customer.customer_id = $searchq";

                $result = mysqli_query($conn, $sql) or die("could not search!");

            }
            //Search based on customer name
            else{

                $searchq = preg_replace("#[^0-9a-z]#i","", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);

                $customer = "SELECT * FROM customer WHERE concat(customer.first_name, ' ', customer.last_name) LIKE '%$searchq%'";

                $result = mysqli_query($conn, $customer) or die("could not search!");

            }

        }

        //Return total number of pages
        return ceil((mysqli_num_rows($result)/100));

    }