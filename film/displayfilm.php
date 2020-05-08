<?php

    //Function to enable header redirect
    ob_start();

    //Connect to database
    include_once('../Connect.php');

    //include functions to be used
    include_once('displayfilmfunction.php');

    //Check if a search is entered, if not use a default value
    if(isset($_GET["search_box"])){

        $search_box = $_GET["search_box"];

    }else{
        
    
        $search_box = "";
    

    }

    //Check if a search choice is selected, if not use a default value
    if(isset($_GET["searchchoice"])){

        $searchchoice = $_GET["searchchoice"];

    }else{

        $searchchoice = 0;

    }

    //Determine the number of pages based on search
    $totalpage = PageCount($search_box, $searchchoice, $conn);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SAKILA | Films</title>
		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
    </head>
<body>

    <nav>
        <ul>
            <li><a id="link" href="/home/Home.php">Home</a></li>
            <li><a id="link" href="/customer/customer.php">Customer</a></li>
            <li><a id="link" class="active" href="displayfilm.php">Film</a></li>
            <li><a id="link" href="/Inventory/Inventory.php">Inventory</a></li>
            <li><a id="link" href="/payment/Payment.php">Payment</a></li>
            <li><a id="link" href="/rental/Rental.php">Rental</a></li>
            <li><a id="link" href="/staff/Staff.php">Staff<a></li>
        </ul>
    </nav>

    <h1>All Films</h1>

<!--Form for search-->
<form>
	<input type="radio" id = "actor_id" value="1" name="searchchoice" required>Actor
	<input type="radio" id = "category_id" value = "2" name="searchchoice">Category
	<input type="radio" id = "language_id" value="3" name="searchchoice">Language
    <input type = "radio" id = "title" value="4" name = "searchchoice">Title<br><br>
    Search: <input type = "text" id = "search" name = "search_box" placeholder="Search for film..." required>
	<input type="submit" name="search" value="Search"><br><br>
</form>

<!--Link to reset displayfilm.php-->
<button class="go" onclick="document.location = 'displayfilm.php'">Display All Films</button>
<!--Link to displayactors.php-->
<button class="go" onclick="document.location = 'displayactors.php'">Display Actors</button>

<!--Display table of films-->
<table>
    <tr>
        <th>Film id</th>
		<th>Title</th>
        <th>Category</th>
        <th>Language Name</th>
		<th>Description</th>
		<th>Rental Duration</th>
		<th>Rental Rate</th>
		<th>Length</th>
		<th>Replacement Cost</th>
		<th>Rating</th>
		<th>Special Features</th>
    </tr>


    
    <?php 
        //Check if a page is selected, if not, return default value 1
        if (isset($_GET['page'])) {

            $page = $_GET['page'];
        }
        else{

            $page = 1;
        }

        //Get list of films based on search and page
        $film = ListFilm($search_box, $searchchoice, $page, $conn);

        //Display films
        foreach($film as $row){ ?>
        <tr>
            <td><?php echo $row['film_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['language_name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['rental_duration']; ?></td>
            <td><?php echo $row['rental_rate']; ?></td>
            <td><?php echo $row['length']; ?></td>
            <td><?php echo $row['replacement_cost']; ?></td>
            <td><?php echo $row['rating']; ?></td>
            <td><?php echo $row['special_features']; ?></td>
        </tr>
    <?php } ?>
</table>

    <?php       

        //Check if a page is selected, if not, return default value 1
        if (isset($_GET['page'])) {

            $current = $_GET['page'];
        }
        else{

            $current = 1;
        }
        
        //Display available pages based on the current page and total number of pages
        $range = 5;       
        echo "<a id=\"page\" href=\"displayfilm.php?search=$search_box&page=1\">First</a>";
        for($num=($current-$range);$num<=($current+$range);$num++){
            if(($num>0)&&($num<=$totalpage)){
                if($num==$current){
                    echo "<b><a id=\"page\" class=\"current\" href=\"displayfilm.php?search=$search_box&page=$num\">$num</a></b>";
                }
                else{
                    echo "<a id=\"page\" href=\"displayfilm.php?search=$search_box&page=$num\">$num</a>"; 
                }
            }
        }
        echo "<a id=\"page\" href=\"displayfilm.php?search=$search_box&page=$totalpage\">Last</a>";
    ?>
    <!--Link back to Home.php-->
	<a id="home" href="/home/Home.php">Home</a>
</body>
</html>

<?php ob_end_flush(); ?>