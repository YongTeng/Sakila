<?php
    
    //Function to enable header redirect
    ob_start();

    //Connect to database
    include_once('../Connect.php');

    //include functions to be used
    include_once('displayactorsfunction.php');

    //Check if a search is entered, if not use a default value
    if(isset($_GET["search"])){

        $search = $_GET["search"];

    }else{

        $search= "";

    }

    //Determine the number of pages based on search
    $totalpage = PageCount($search, $conn);

?>

<!DOCTYPE html>
<html>

    <head>

        <title>Actors</title>
        <link rel = "stylesheet" type = "text/css" href = "../style.css" />
		<link rel="shortcut icon" type ="image/png" href="../icon.png">
        
    </head>

    <body>

        <h2>Actors</h2>

        <!--Form for search-->
        <form action="displayactors.php" method="get">

            <input id = "searchentry" type="text" name="search" placeholder="Search for actors..." />
            <input type="submit" value="Search"/>
        
        </form>
        <!--Link to go back to displayfilm.php-->
        <button class="go" onclick="document.location = 'displayfilm.php'">Back</button>
        <br><br>

        <!--Display table of actors-->
        <table>

            <th>Actor ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            
                <?php

                    //Check if a page is selected, if not, return default value 1
                    if (isset($_GET['page'])) {

                        $page = $_GET['page'];
        
                    }
                    else{
        
                        $page = 1;
        
                    }
                    
                    //Get list of actors based on search and page
                    $datas = ListActors($search, $page, $conn);

                    //Display actors
                    if(!empty($datas)){

                        foreach($datas as $data){
                            
                            echo "<tr>";
                            echo "<td>".$data["actor_id"]."</td><td>".$data["first_name"] . "</td><td>".$data["last_name"]."</td>";
                            echo "</tr>";
                            echo "\n\t\t\t\t";

                        }
                        
                    }

                

                ?>  

            </table>

            <?php
            
                    if(empty($datas)){

                        echo "<p>No results found!</p>";

                    }
            
            ?>
        
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
            echo "<a id=\"page\" href=\"displayactors.php?search=$search&page=1\">First</a>";
            for($num=($current-$range);$num<=($current+$range);$num++){
                if(($num>0)&&($num<=$totalpage)){
                    if($num==$current){
                        echo "<b><a id=\"page\" class=\"current\" href=\"displayactors.php?search=$search&page=$num\">$num</a></b>";
                    }
                    else{
                        echo "<a id=\"page\" href=\"displayactors.php?search=$search&page=$num\">$num</a>"; 
                    }
                }
            }
            echo "<a id=\"page\" href=\"displayactors.php?search=$search&page=$totalpage\">Last</a>";

        
        ?>
    </body>

</html>

<?php ob_end_flush(); ?>