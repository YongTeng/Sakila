<?php
    
    //Function for counting number of pages based on search
    function PageCount($search, $conn){
        
        //Default query if nothing is searched
        $actors = "SELECT * FROM actor";
        $result = mysqli_query($conn, $actors) or die("could not search!");

        if(isset($search)){

            $searchq = $search;
            $searchq = trim($searchq);
            //Search based on actor id
            if (is_numeric($searchq)){

                $searchq = (int)$searchq;

                $actors = "SELECT * FROM actor WHERE actor.actor_id = $searchq";

                $result = mysqli_query($conn, $actors) or die("could not search!");

            }
            //Search based on actor name
            else{

                $searchq = preg_replace("#[^0-9a-z]#i"," ", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);

                $actors = "SELECT * FROM actor WHERE concat(actor.first_name, ' ',actor.last_name) LIKE '%$searchq%'";

                $result = mysqli_query($conn, $actors) or die("could not search!");

            }

        }

        //Return total number of pages
        return ceil( (mysqli_num_rows($result) / 100) );

    }
    
    //Function for searching and returning based on page selected
    function ListActors($search, $page, $conn){

        $start_from = ($page-1) * 100;

        //Default query if nothing is searched
        $actors = "SELECT * FROM actor ORDER BY actor.actor_id ASC LIMIT $start_from, 100";
        $result = mysqli_query($conn, $actors) or die("could not search!");

        if(isset($search)){

            $searchq = $search;
            $searchq = trim($searchq);

            //Search based on actor id
            if (is_numeric($searchq)){

                $searchq = (int)$searchq;
                $actors = "SELECT * FROM actor WHERE actor.actor_id = $searchq ORDER BY actor.actor_id ASC LIMIT $start_from, 100";

                $result = mysqli_query($conn, $actors) or die("could not search!");


            }
            //Search based on actor name
            else{

                $searchq = preg_replace("#[^0-9a-z]#i"," ", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);
                $actors = "SELECT * FROM actor WHERE concat(actor.first_name, ' ',actor.last_name) LIKE '%$searchq%' ORDER BY actor.actor_id ASC LIMIT $start_from, 100";
                $result = mysqli_query($conn, $actors) or die("could not search!");

            }

        }

        //Saving data into an array
        $datas = array();

        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){
            
            for($i = 0;$row = mysqli_fetch_assoc($result);$i++){
                
                $datas[$i]= $row;

            }

        }

        //Returning array 
        return $datas;

    }
    
?>