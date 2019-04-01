<?php
	require 'header.php';
	echo "<div class=container>";

	if ($_SESSION['type'] == 'Restaurant Manager') {
		// Restaurant Manager unique content
		echo "<a href='restaurantPage.php'>";
		echo "	<button class='btn btn-primary my-2 mx-3'>View My Restaurant</button>";
		echo "</a>";
		require 'foodList.php';
	} else if ($_SESSION['type'] == 'Customer') {
		// Restaurant Manager unique content
		echo "<a href='orders.php'>";
		echo "	<button class='btn btn-primary my-2 mx-3'>Orders</button>";
		echo "</a>";
		echo "<a href='customerPage.php'>";
		echo "	<button class='btn btn-primary my-2 mx-3'>Account</button>";
		echo "</a>";
		require 'restaurantList.php';
	} else if ($_SESSION['type'] == 'Delivery Driver') {
		echo "<a href='driverPage.php'><button class='btn btn-default'>Pending Orders</button></a>";
		require 'foodList.php';
	}
	else {
		echo "<h1>Temp Home Page</h1>";
		require 'foodList.php';
	}

	echo "</div>";


	




?>
