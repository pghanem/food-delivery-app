<?php
// require "executes.inc.php";

function getSQL() {
    if (isset($_POST['sort-submit'])) {
        echo "true";
        $sql = 'select f.name, f.price, f.description, r.name as rname, r.avg_rating as rating from FoodItem f inner join restaurant r on f.RID=r.RID order by price asc';

    } else {
        $sql = "select f.name, f.price, f.description, r.name as rname, r.avg_rating as rating from FoodItem f inner join restaurant r on f.RID=r.RID";
    }
    return $sql;
}

function printFoodCards() {
    $sql = getSQL();
	$result = executePlainSQL($sql);
    printCards($result);
}

function printCards($result) {
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<div class='container'>";
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
   		echo "</div>";
	}
}
?>