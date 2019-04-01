<?php
    require 'queries.php';


    $restaurants = getAllRestaurants();
    echo" <div class=container>";
    printRestaurantTableHeader();
    printRestaurantTableData($restaurants);
    echo "</div>";


    function printRestaurantTableHeader() {
        echo "<table>";
        echo "  <tr>";
        echo "      <td>Name</td>";
        echo "      <td>Address</td>";
        echo "      <td>Cuisine</td>";
        echo "      <td>Rating</td>";
        echo "      <td></td>";
        echo "  </tr>";
    }

    function printRestaurantTableData($data) {
        while ($row = OCI_Fetch_Array($data, OCI_BOTH)) {
            echo "  <tr>";
            echo "      <td>".$row['NAME']."</td>";
            echo "      <td>".$row['STREETNO'].", ".$row['CITY'].", ".$row['PROVINCE']."</td>";
            echo "      <td>".$row['CUISINE']."</td>";
            echo "      <td>".$row['AVG_RATING']."</td>";
            echo "      <form method='POST' action='restaurantHome.php'>";
            echo "      <td><button class='btn btn-success' type='submit' name='rest-submit"; echo "        value='".$row['RID']."'>Browse Menu</butto></td>";
            echo "      </form>";
            echo "  </tr>";
        }
    }

?>