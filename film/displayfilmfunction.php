<?php

//Function for counting number of pages based on search
function PageCount($search_box, $searchchoice, $conn){

//Default query if nothing is searched
$sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
FROM film 
INNER JOIN language ON film.language_id = language.language_id
INNER JOIN film_category ON film_category.film_id = film.film_id
INNER JOIN category ON category.category_id = film_category.category_id
ORDER BY film.film_id;";

$result = mysqli_query($conn, $sql) or die("could not search!");

        //Search based on actor name
        if($searchchoice == 1){
            $search_box = preg_replace("#[^0-9a-z]#i"," ", $search_box);
            $search_box = preg_replace('/\s\s+/', ' ', $search_box);

            $sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
            FROM film 
            INNER JOIN language ON film.language_id = language.language_id
            INNER JOIN film_category ON film_category.film_id = film.film_id
            INNER JOIN category ON category.category_id = film_category.category_id
            INNER JOIN film_actor ON film_actor.film_id = film.film_id
            INNER JOIN actor ON film_actor.actor_id = actor.actor_id
            WHERE concat(actor.first_name, ' ', actor.last_name) LIKE '%$search_box%' ORDER BY film.film_id";

            $result = mysqli_query($conn, $sql) or die("could not search!");

        }
        //Search based on category
        else if($searchchoice == 2){
            $search_box = preg_replace("#[^0-9a-z]#i"," ", $search_box);
            $search_box = preg_replace('/\s\s+/', ' ', $search_box);

            $sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
            FROM film
            INNER JOIN language ON film.language_id = language.language_id
            INNER JOIN film_category ON film_category.film_id = film.film_id
            INNER JOIN category ON category.category_id = film_category.category_id
            WHERE category.name LIKE '%$search_box%' ORDER BY film.film_id";

            $result = mysqli_query($conn, $sql) or die("could not search!");

        }
        //Search based on language
        else if ($searchchoice == 3){
            $search_box = preg_replace("#[^0-9a-z]#i"," ", $search_box);
            $search_box = preg_replace('/\s\s+/', ' ', $search_box);
            $sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
            FROM film 
            INNER JOIN language ON film.language_id = language.language_id
            INNER JOIN film_category ON film_category.film_id = film.film_id
            INNER JOIN category ON category.category_id = film_category.category_id
            WHERE language.language_name LIKE '%$search_box%' ORDER BY film.film_id";

            $result = mysqli_query($conn, $sql) or die("could not search!");

        }
        //Search based on title
        else if ($searchchoice == 4){
            $search_box = preg_replace("#[^0-9a-z]#i"," ", $search_box);
            $search_box = preg_replace('/\s\s+/', ' ', $search_box);

            $sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
            FROM film 
            INNER JOIN language ON film.language_id = language.language_id
            INNER JOIN film_category ON film_category.film_id = film.film_id
            INNER JOIN category ON category.category_id = film_category.category_id
            WHERE film.title LIKE '%$search_box%' ORDER BY film.film_id";

            $result = mysqli_query($conn, $sql) or die("could not search!");
        }
            
  
//Return total number of pages
return ceil( (mysqli_num_rows($result) / 100) );
}
?>

<?php

//Function for searching and returning based on page selected
function ListFilm($search_box, $searchchoice, $page, $conn){

$start_from = ($page-1) * 100;

//Default query if nothing is searched
$sql = "SELECT  film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name
FROM film 
INNER JOIN language ON film.language_id = language.language_id
INNER JOIN film_category ON film_category.film_id = film.film_id
INNER JOIN category ON category.category_id = film_category.category_id ORDER BY film.film_id LIMIT $start_from, 100";

$result = mysqli_query($conn, $sql) or die("could not search!");

        //search based on actor name
        if($searchchoice == 1){
            $search_box = preg_replace("#[^0-9a-z]#i"," ", $search_box);
            $search_box = preg_replace('/\s\s+/', ' ', $search_box);

            $sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
            FROM film 
            INNER JOIN language ON film.language_id = language.language_id
            INNER JOIN film_category ON film_category.film_id = film.film_id
            INNER JOIN category ON category.category_id = film_category.category_id
            INNER JOIN film_actor ON film_actor.film_id = film.film_id
            INNER JOIN actor ON film_actor.actor_id = actor.actor_id
            WHERE concat(actor.first_name, ' ', actor.last_name) LIKE '%$search_box%' ORDER BY film.film_id LIMIT $start_from, 100";

            $result = mysqli_query($conn, $sql) or die("could not search!");

        }
        //search based on category
        else if($searchchoice == 2){
            $search_box = preg_replace("#[^0-9a-z]#i"," ", $search_box);
            $search_box = preg_replace('/\s\s+/', ' ', $search_box);

            $sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
            FROM film
            INNER JOIN language ON film.language_id = language.language_id
            INNER JOIN film_category ON film_category.film_id = film.film_id
            INNER JOIN category ON category.category_id = film_category.category_id
             WHERE category.name LIKE '%$search_box%' ORDER BY film.film_id LIMIT $start_from, 100";

            $result = mysqli_query($conn, $sql) or die("could not search!");

        }
        //Search based on language
        else if ($searchchoice == 3){
            $search_box = preg_replace("#[^0-9a-z]#i"," ", $search_box);
            $search_box = preg_replace('/\s\s+/', ' ', $search_box);

            $sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
            FROM film 
            INNER JOIN language ON film.language_id = language.language_id
            INNER JOIN film_category ON film_category.film_id = film.film_id
            INNER JOIN category ON category.category_id = film_category.category_id
            WHERE language.language_name LIKE '%$search_box%' ORDER BY film.film_id LIMIT $start_from, 100";

            $result = mysqli_query($conn, $sql) or die("could not search!");

        }
        //Search based on title
        else if ($searchchoice == 4){
            $search_box = preg_replace("#[^0-9a-z]#i"," ", $search_box);
            $search_box = preg_replace('/\s\s+/', ' ', $search_box);

            $sql = "SELECT film.film_id, film.title, category.name, film.description, film.rental_duration, film.rental_rate, film.length, film.replacement_cost, film.rating, film.special_features, language.language_name 
            FROM film 
            INNER JOIN language ON film.language_id = language.language_id
            INNER JOIN film_category ON film_category.film_id = film.film_id
            INNER JOIN category ON category.category_id = film_category.category_id
            WHERE film.title LIKE '%$search_box%' ORDER BY film.film_id LIMIT $start_from, 100";

            $result = mysqli_query($conn, $sql) or die("could not search!");
            
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