<?php
    
    //Function for counting number of pages based on search
    function PageCount($search, $conn){


        //Default query if nothing is searched
        $inventory = "SELECT * FROM inventory";
        $result = mysqli_query($conn, $inventory) or die("could not search!");

        if(isset($search)){

            $searchq = $search;
            $searchq = trim($searchq);

            //Search based on film id or inventory id
            if (is_numeric($searchq)){

                $searchq = (int)$searchq;

                $inventory = "SELECT * FROM inventory WHERE inventory.film_id = $searchq OR inventory.inventory_id = $searchq";

                $result = mysqli_query($conn, $inventory) or die("could not search!");

            }
            //Searched based on film title
            else{

                $searchq = preg_replace("#[^0-9a-z]#i"," ", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);

                $inventory = "SELECT * FROM inventory INNER JOIN film ON film.film_id = inventory.film_id WHERE film.title LIKE '%$searchq%'";

                $result = mysqli_query($conn, $inventory) or die("could not search!");

            }

        }

        //Return total number of pages
        return ceil( (mysqli_num_rows($result) / 100) );

    }
    
    //Function for searching and returning list of inventory based on page selected
    function ListInventory($search, $page, $conn){

        $start_from = ($page-1) * 100;

        //Default query if nothing is searched
        $inventory = "SELECT inventory.inventory_id, inventory.film_id, film.title, inventory.store_id 
                        FROM inventory INNER JOIN film ON film.film_id = inventory.film_id
                        ORDER BY inventory.inventory_id ASC LIMIT $start_from, 100";
        $result = mysqli_query($conn, $inventory) or die("could not search!");

        

        if(isset($search)){

            $searchq = $search;
            $searchq = trim($searchq);

            //Searched based on film id or inventory id
            if (is_numeric($searchq)){

                $searchq = (int)$searchq;
                $inventory = "SELECT inventory.inventory_id, inventory.film_id, film.title, inventory.store_id
                                FROM inventory INNER JOIN film ON film.film_id = inventory.film_id
                                WHERE inventory.film_id = $searchq OR inventory.inventory_id = $searchq
                                ORDER BY inventory.inventory_id ASC LIMIT $start_from, 100";

                $result = mysqli_query($conn, $inventory) or die("could not search!");


            }
            //Search based on film title
            else{

                $searchq = preg_replace("#[^0-9a-z]#i"," ", $searchq);
                $searchq = preg_replace('/\s\s+/', ' ', $searchq);
                $inventory = "SELECT inventory.inventory_id, inventory.film_id, film.title, inventory.store_id
                                FROM inventory INNER JOIN film ON film.film_id = inventory.film_id
                                WHERE film.title LIKE '%$searchq%'
                                ORDER BY inventory.inventory_id ASC LIMIT $start_from, 100";
                $result = mysqli_query($conn, $inventory) or die("could not search!");

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

    //Function for listing available stores
    function ListStore($conn){

        //Query for selecting stores in database
        $store = "SELECT store.store_id, staff.first_name, staff.last_name, address.address, address.district FROM store 
                    INNER JOIN staff ON staff.staff_id = store.manager
                    INNER JOIN address ON address.address_id = store.address_id
                    ORDER BY store.store_id ASC";

        $result = mysqli_query($conn, $store) or die("could not search!");


        //Saving data into an array
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){
            
            for($i = 0;$row = mysqli_fetch_assoc($result);$i++){
                
                $datas[$i]= $row;

            }

        }

        //Returning array
        return $datas;

    }

    //Function for listing available films
    function ListFilms($conn){

        //Query for selecting available films
        $film = "SELECT film.film_id, film.title FROM film
                    ORDER BY film.film_id ASC";

        $result = mysqli_query($conn, $film) or die("could not search!");

        //Saving data into an array
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){
            
            for($i = 0;$row = mysqli_fetch_assoc($result);$i++){
                
                $datas[$i]= $row;

            }
        }

        //Returning array
        return $datas;
    }

    //Function for deleting selected items
    function deleteInventory($selectItem, $conn){

        //Query to delete each item stored in selectItem 
        foreach($selectItem as $Inventory_id){
            
            $deletesql = "DELETE FROM inventory WHERE inventory_id = $Inventory_id";
            mysqli_query($conn, $deletesql) or die("could not delete!");

        }

    }

    //Function for changing store of selected items
    function StoreChange($selectItem, $selectStore, $conn){


        //Query to change store of each item stored in selectItem to selected store
        foreach($selectItem as $Inventory_id){

            $storechangesql = "UPDATE inventory SET store_id = $selectStore WHERE inventory_id = $Inventory_id";
            mysqli_query($conn, $storechangesql) or die("could not update!");

        }

    }

    //Function for adding a new entry in inventory
    function AddInventory($film_id, $store_id, $conn){

        //Query to add item based on selected film and store
        $addinventorysql = "INSERT INTO inventory (film_id, store_id)
                            VALUES ($film_id, $store_id)";
        mysqli_query($conn, $addinventorysql) or die("could not update!");
        
    }

?>