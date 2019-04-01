<?php 
    require 'header.php';
    require 'includes/executes.inc.php';


    $sql = "select Restaurant.RID, Restaurant.name, Restaurant.cuisine, ROUND(avg(Review.rating),1) as rating
    from Restaurant, Review where Review.RID = Restaurant.RID Group By Restaurant.RID, Restaurant.name, Restaurant.cuisine";

    echo $sql;

    $result = executePlainSQL($sql);


    // echo "<div class='container'>";
    // while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    //         // echo "  <form action='restaurant.php' method='POST'>";
    //         echo
    //         echo "	<div class='card foodCard'>";
    //         echo "  	<div class='card-body'>";
    //         // echo "      <button class='btn btn-outline-primary my-2 my-sm-0 mx-1' type='submit' name='restaurant-submit'>";
    //         echo "     		<h5 class='card-title'>" . $row['NAME'];
    //         echo "          	<small class='text-muted'>". $row['CUISINE'] . "</small>";
    //         echo "       	</h5>";
    //         echo "       	<h5 class='rating'>". $row['RATING'];
    //         echo "       	    <i class='fas fa-star'></i>";
    //         echo "          </h5>";
    //         echo "   	</div>";
    //         echo "	</div>";
    // }
    // echo "</div>";

    echo "<div class='container'>";
        echo "<table>";
        echo "  <tr>";
        echo "      <td>Name</td>";
        echo "      <td>Cuisine</td>";
        echo "      <td>Rating</td>";

        echo "  </tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr>";
            echo "  <td>" . $row['NAME'] . "</td>";
            echo "  <td>" . $row['CUISINE'] . "</td>";
            echo "  <td>" . $row['RATING'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";

?>
