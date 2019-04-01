<?php
    require 'header.php';
	require 'includes/executes.inc.php';
	
	if (isset($_SESSION['ID']) && isset($_SESSION['type']) && $_SESSION['type'] == 'Restaurant Manager') {
		echo 'live session';
	}

	echo "<div class='container'>";
?>
<!--This is the Restaurant page.
	Used for:
	- inserting food items to menu
	- changing prices
	- etc. -->

<h1>Welcome to the Restaurant Homebase for Fuudie: Delivery Reinvented</h1>

<!-- THIS IS THE INSERT ADDRESS HTML CODE -->
<table>
    <tr>
        <th colspan='3' align='left'>Add the address to your new Restaurant below:</th>
    </tr>
    <tr>
        <td>AddressID</td>
        <td>Street</td>
        <td>City</td>
        <td>Province</td>
        <td>Postal Code</td>
    </tr>
    <tr>
        <form action="restaurantPage.php" method="POST">
            <td><input type="text" name="insAID" size="20"></td>
            <td><input type="text" name="insStreet" size="20"></td>
            <td><input type="text" name="insCity" size="20"></td>
            <td><input type="text" name="insProvince" size="20"></td>
            <td><input type="text" name="insPostal" size="12"></td>
            <td><input type="submit" value="insert" name="insertAddressSubmit"></td>
        </form>
    </tr>
</table>

<!-- THIS IS THE INSERT FOODITEM HTML CODE -->
<table>
    <tr>
        <th colspan='3' align='left'>Add a new food item to your menu below:</th>
    </tr>
    <tr>
        <font size='2'>
            <td>Restaurant ID</td>
            <td>Food ID (5)</td>
            <td>Name</td>
            <td>Description</td>
            <td>Price</td>
            <td>Category</td>
            <td>Dietary Type</td>
        </font>
    </tr>
    <tr>
        <form method="POST" action="restaurantPage.php">
        <td><input type="text" name="insRID" size="20"></td>
        <td><input type="text" name="insFID" size="20"></td>
        <td><input type="text" name="insFoodName" size="12"></td>
        <td><input type="text" name="insFoodDescription" size="20"></td>
        <td><input type="text" name="insFoodPrice" size="20"></td>
        <td><input type="text" name="insFoodCategory" size="20"></td>
        <td><input type="text" name="insFoodType" size="20"></td>
        <td><input type="submit" value="insert" name="insertFoodSubmit"></p></td>
    </form>
    </tr>
</table>

<!-- THIS IS THE DELETE FOODITEM HTML CODE -->
<table>
    <tr>
        <th colspan='2'>Delete a food item from your menu below:</th>
    </tr>
    <tr>
        <font size="2">
            <td>Food Item ID</td>
        </font>
    </tr>
    <tr>
        <form method="POST" action="restaurantPage.php">
            <td><input type="text" name="delFID" size="10"></td>
            <td><input type="submit" value="delete" name="deleteFoodSubmit"></td>
        </form>
    </tr>
</table>


<!-- THIS IS THE UPDATE FOODITEM PRICE HTML CODE -->
<table>
<tr><th colspan=3>Update food item price by inserting the food item ID and new price below:</th></tr>

<tr>
	<font size="2">
	<td>Food Item ID</td>
	<td>New Price</td>
	</font>
</tr>
<tr>
	<form method="POST" action="restaurantPage.php">
<!--refresh page when submit-->
	<td><input type="text" name="updateID" size="20"></td>
	<td><input type="text" name="updatePrice" size="10"></td>
<!--define two variables to pass the value-->
	<td><input type="submit" value="update" name="updatePriceSubmit"></td>
	</form>
</tr>
</table>

<!-- THIS IS THE SELECT PREVIOUS ORDERS HTML CODE -->
<!-- <table>
	<tr>
		<th colspan=2>Check any past orders placed at your establishment:</th>
	</tr>
	<tr>
		<td><font size="2">Restaurant ID</font></td>
	</tr>
	<tr>
		<form method="POST" action="restaurantPage.php">
			<td><input type="text" name="selectRID" size="10"></td>
			<td><input type="submit" value="view" name="selectOrdersSubmit"></td>
		</form>
	</tr>
</table> -->
      
<!-- create a form to pass the values. See below for how to 
get the values--> 


<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

function printAddress($address) { //prints results from a select statement
	echo "<br>Current Addresses:<br>";
	echo "<table>";
	echo "<tr><th>Address ID</th><th>Street</th><th>Postal</th><th>City</th><th>Province</th></tr>";

	while ($row = OCI_Fetch_Array($address, OCI_BOTH)) {
		echo "<tr><td>" . $row["ADDRESSID"] . "</td><td>" . $row["STREETNO"] . "</td><td>" . $row["POSTAL"] . "</td><td>" . $row["CITY"] . "</td><td>" . $row["PROVINCE"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
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
            echo "          	<small class='text-muted'>". $row['FID'] . "</small>";
            echo "       	</h5>";
            echo "       	<h5 class='price'>$". $row['PRICE'] ."</h5>";
            echo "       	<p class='card-text'>". $row['DESCRIPTION'] .".</p>";
            echo "   	</div>";
            echo "	</div>";
        }
    }


// Connect Oracle...
if ($db_conn) {

		if (array_key_exists('selectOrdersSubmit', $_POST)) {
			$tuple = array (
				":bind1" => $_POST['selectRID']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("select OrderedFood.RID, FoodOrder.orderID, CID, od_time, od_date total from FoodOrder inner join OrderedFood on FoodOrder.orderID = OrderedFood.orderID inner join FoodItem on FoodItem.FID = OrderedFood.FID where OrderedFood.RID=:bind1", $alltuples);
			OCICommit($db_conn);

		} else if (array_key_exists('deleteFoodSubmit', $_POST)) {
			$tuple = array (
				":bind1" => $_POST['delFID']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("delete from FoodItem where FID = :bind1", $alltuples);
			OCICommit($db_conn);
		} else if (array_key_exists('insertFoodSubmit', $_POST)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['insRID'],
				":bind2" => $_POST['insFID'],
				":bind3" => $_POST['insFoodName'],
				":bind4" => $_POST['insFoodDescription'],
				":bind5" => $_POST['insFoodPrice'],
				":bind6" => $_POST['insFoodCategory'],
				":bind7" => $_POST['insFoodType']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into fooditem values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7)", $alltuples);
			OCICommit($db_conn);
		
		} else if (array_key_exists('insertAddressSubmit', $_POST)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['insAID'],
				":bind2" => $_POST['insStreet'],
				":bind3" => $_POST['insCity'],
				":bind4" => $_POST['insProvince'],
				":bind5" => $_POST['insPostal']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into address values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
			OCICommit($db_conn);
		
		} else if (array_key_exists('updatePriceSubmit', $_POST)) {
				// Update tuple using data from user
				$tuple = array (
					":bind1" => $_POST['updateID'],
					":bind2" => $_POST['updatePrice']
				);
				$alltuples = array (
					$tuple
				);
				executeBoundSQL("update fooditem set price=:bind2 where FID=:bind1", $alltuples);
				OCICommit($db_conn);

		}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: restaurantPage.php");
	} else {
		// Select data...
		$address = executePlainSQL("select * from address");
		printAddress($address);
		
		// menu for this restaurant
		if (isset($_SESSION['type']) && $_SESSION['type'] == 'Restaurant Manager') {
			echo "<div class='container'>";
	
			$result = allFoodBelongingToManagersRestaurant($mid);
			printFoodCards($result);
	
			echo "</div>";   // container close
		}
	}

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

?>

<!-- if (isset($_SESSION['type']) && $_SESSION['type'] == 'Restaurant Manager') {
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
    } -->