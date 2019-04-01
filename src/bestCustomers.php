<?php
    require 'includes/executes.inc.php';
    require 'includes/dbHandler.inc.php';
    require 'header.php';

    printTheBest();

    function printTheBest() {
        $sql = "select Customer.cid, Customer.fname, Customer.lname
        from Customer
        where not exists
        ((select Restaurant.RID from Restaurant)
        minus
        (select OrderedFood.RID 
        from OrderedFood, FoodOrder
        where FoodOrder.CID = Customer.CID))";
    
        $result = executePlainSQL($sql);
    
        echo "<div class='container'>";
        echo "  <h2>VIP Customers that have shopped at all Restaurants:</h2>";
        echo "  <table>";
        echo "      <tr>";
        echo "          <td>First Name</td>";
        echo "          <td>Last Name</td>";
        echo "      </tr>";
        
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr>";
            echo "<td>".$row['FNAME']."</td>";
            echo "<td>".$row['LNAME']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
?>