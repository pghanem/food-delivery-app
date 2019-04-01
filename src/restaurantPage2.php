<?php
    require 'header.php';
    require 'includes/executes.inc.php';

    if (isset($_SESSION['type']) && $_SESSION['type'] == 'Restaurant Manager') {
        $mgrSql = "select * from RestaurantManager where MID='". $_SESSION['ID'] ."'";

        echo "<div class='container'>";

		$result = executePlainSQL($mgrSql);
		printFoodCards($result);

        

        echo "</div>";   // container
    }


    function printFoodCards($result) {
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                $rid = $row['RID'];
                printFoodCards($rid);
            }
            $sql = "select * from FoodItem where RID='". $rid . "'";
            $result = executePlainSQL($sql);
            printCards($result);
        }
        
        function printCards($result) {
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "	<div class='card foodCard'>";
                echo "  	<div class='card-body'>";
                echo "     		<h5 class='card-title'>" . $row['NAME'];
                echo "          	<small class='text-muted'>". $row['RNAME'] . "</small>";
                echo "       	</h5>";
                echo "       	<h5 class='price'>$". $row['PRICE'] ."</h5>";
                echo "       	<h5 class='rating'>". $row['RATING'];
                echo "       	    <i class='fas fa-star'></i>";
                echo "          </h5>";
                echo "       	<p class='card-text'>". $row['DESCRIPTION'] .".</p>";
                echo "   	</div>";
                echo "	</div>";
            }
        }
?>

