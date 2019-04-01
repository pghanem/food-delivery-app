<?php
    require 'header.php';
    require 'queries.php';

    if (isset($_SESSION['ID']) && isset($_SESSION['type']) && $_SESSION['type'] == 'Customer') {


    $rid ='r0001';
    // if (isset($_POST['rest-submit'])) {
    //     $rid = $_POST['rest-submit'];
    // }

    echo "<div class='container'>";
    $menuResult = getFoodItemsBy($rid);
    // printFoodTableHeader();

    printMenu($menuResult);

    echo "</div>"; //menu group

    echo "<div class='my-3 rating'>";
    echo "<h2>Reviews:</h2>";
    
    $reviewResult = getReviewsFor($rid);
    // printReviewTableHeader();

    while ($row = OCI_Fetch_Array($reviewResult, OCI_BOTH)) {
        printReviewCard($row);
    }
    echo "</div>"; //review group

    echo "</div>"; //container

} else {
    header("Location index.php");
    exit();
}

    function printMenu($menu) {
        echo "<div class='my-5 menu'>";
        echo "   <h2>Menu:</h2>";
        echo    "<form method='POST' action='includes/restaurantHome.php'>";

        while ($row = OCI_Fetch_Array($menu, OCI_BOTH)) {
            printFoodCard($row);
        }

        echo "<button class='btn btn-success btn-order'>Place Order</button>";
        echo "</form>";
    }
    

    function printFoodCard($row) {
        echo "<div class='card foodCard'>";
        echo "  <div class='card-body'>";
        echo "      <h5 class='card-title'>";
        echo            $row['FNAME'];
        echo "          <small class='text-muted'>".$row['DIETARY_TYPE']." — ";
        echo            $row['CATEGORY']."</small>";
        echo "      </h5>";
        echo "      <h5 class='price'>$".$row['PRICE']."</h5>";
        echo "      <p class='card-text'>".$row['DESCRIPTION']."</p>";
        echo "      <input class='foodID' type='checkbox' name='selected-items' value='".$row['FID']."'>";
        echo "  </div>";
        echo "</div>";
    }

    function printReviewCard($row) {
        echo "<div class='card reviewCard my-2'>";
        echo "    <div class='card-body'>";
        echo "      <h5 class='card-title'>";
        echo          $row['RATING'] . "<i class='fas fa-star'></i>";
        echo "        <small class='text-muted'> —".$row['FNAME']. " ". $row['LNAME']."</small>";
        echo "      </h5>";
        echo "      <p class='card-text'>".$row['COMMENTS']."</p>";
        echo "    </div>";
        echo "  </div>";
    }

    function printFoodTableHeader() {
        echo "<table>";
        echo "  <tr>";
        echo "      <td>ID</td>";
        echo "      <td>Name</td>";
        echo "      <td>Description</td>";
        echo "      <td>Price</td>";
        echo "      <td>Restrictions</td>";
        echo "      <td>Type</td>";
        echo "  </tr>";
    }

    function printFoodRowData($row) {
        echo "  <tr>";
        echo "      <td>".$row['FID']."</td>";
        echo "      <td>".$row['FoodItem.NAME']."</td>";
        echo "      <td>".$row['DESCRIPTION']."</td>";
        echo "      <td>".$row['PRICE']."</td>";
        echo "      <td>".$row['DIETARY_TYPE']."</td>";
        echo "      <td>".$row['CATEGORY']."</td>";
        echo "  </tr>";
    }

    

?>