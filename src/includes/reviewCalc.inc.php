<?php
require "executes.inc.php";

function updateRating() {
    $sql = "select Restaurant.RID, Restaurant.name, ROUND(avg(Review.rating),1) as rrating
    from Restaurant, Review
    where Review.RID = Restaurant.RID
    Group By Restaurant.RID, Restaurant.name";

    echo $sql;

    $result = executePlainSQL($sql);
    echo "got restaurants";
    
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {

        $rid = $row['RID'];
        $rating = $row['RRATING'];
        $updateSQL = "update restaurant set avg_rating=" . $rating . " where RID='" .$rid.  "'";
        executePlainSQL($updateSQL);
    }
}

?>