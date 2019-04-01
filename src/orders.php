
<?php
    require 'header.php';
    require 'includes/executes.inc.php';


    if (isset($_SESSION['ID'])) {
        $cid = $_SESSION['ID'];
        $sql = "select sum(FoodItem.price) as total, Restaurant.name as rname, FoodOrder.od_date, FoodOrder.od_time
        from FoodOrder
        inner join OrderedFood on FoodOrder.orderID = OrderedFood.orderID
        inner join FoodItem on FoodItem.FID = OrderedFood.FID
        inner join Restaurant on Restaurant.RID = OrderedFood.RID
        where FoodOrder.CID='".$cid."'
        group by FoodOrder.orderID, Restaurant.name, FoodOrder.od_date, FoodOrder.od_time";

        $result = executePlainSQL($sql);

        echo "<div class='container'>";
        echo "<table>";
        echo "  <tr>";
        echo "      <td>Item Name</td>";
        echo "      <td>Total</td>";
        echo "      <td>Date</td>";
        echo "      <td>Time</td>";
        echo "  </tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "test";
            echo "<tr>";
            echo "  <td>" . $row['TOTAL'] . "</td>";
            echo "  <td>" . $row['RNAME'] . "</td>";
            echo "  <td>" . $row['OD_DATE'] . "</td>";
            echo "  <td>" . $row['OD_TIME'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    }
?>

