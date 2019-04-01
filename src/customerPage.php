<!--This is the Customer page.-->
<?php
  require 'header.php';
?>
  <div class="container">

  <h2 class=my-3>Welcome to the Customer Homebase for Fuudie: Delivery Reinvented</h2>
    <link rel="stylesheet" type = "text/css" href="style.css">
<form method="POST" action="customerPage.php">

<!-- THIS IS THE UPDATE PAYMENT METHOD HTML CODE -->
<table>
  <tr><th colspan='3' align='left'>Update your payment information below:</th></tr>
  <tr>
    <td>Card Number:</td>
    <td>New Card Type</td>
    <td>New Expiry Date</td>
  </tr>
  <tr>
    <form method="POST" action="customerPage.php">
    <td><input type="text" name="updateNum" size="20"></td>
    <td><input type="text" name="updateType" size="20"></td>
    <td><input type="text" name="updateDate" size="20"></td>
    <td><input type="submit" value="update" name="updateCardSubmit"></td>
    </form>
  </tr>
</table>

<!-- create a form to pass the values. See below for how to 
get the values--> 

<!-- THIS IS THE SHOW BEST RESTAURANTS OF TYPE X HTML CODE -->
<p>View best restaurants of this Cuisine:</p>
<p><font size="2">Restaurant Cuisine:</font></p>
<form method="POST" action="customerPage.php">
<!--refresh page when submit-->

   <p>
    <input type="text" name="selectCuisine" size="20">
<!--define two variables to pass the value-->
      
<input type="submit" value="view" name="selectBestSubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to 
get the values--> 

<!-- THIS IS THE SHOW PREVIOUS ORDERS FOR CUSTOMER X HTML CODE -->
<p>Enter your Customer ID to see your previous orders:</p>
<p><font size="2">Customer ID:</font></p>
<form method="POST" action="customerPage.php">
<!--refresh page when submit-->

   <p>
    <input type="text" name="selectCID" size="20">
<!--define two variables to pass the value-->
      
<input type="submit" value="view" name="selectPreviousOrders"></p>
</form>
<!-- create a form to pass the values. See below for how to 
get the values--> 

<!-- THIS IS THE SHOW REVIEWS FOR RESTAURANT X HTML CODE -->
<p>See reviews for a restaurant of your choice:</p>
<p><font size="2">Restaurant ID:</font></p>
<form method="POST" action="customerPage.php">
<!--refresh page when submit-->

   <p>
    <input type="text" name="selectRID" size="20">
<!--define two variables to pass the value-->
      
<input type="submit" value="view" name="selectReviews"></p>
</form>
<!-- create a form to pass the values. See below for how to 
get the values--> 

<?php

require 'includes/dbHandler.inc.php';
//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
  //echo "<br>running ".$cmdstr."<br>";
  global $db_conn, $success;
  $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

  if (!$statement) {
    echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
    $e = OCI_Error($db_conn); // For OCIParse errors pass the       
    // connection handle
    echo htmlentities($e['message']);
    $success = False;
  }

  $r = OCIExecute($statement, OCI_DEFAULT);
  if (!$r) {
    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
    $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
    echo htmlentities($e['message']);
    $success = False;
  } else {

  }
  return $statement;

}

function executeBoundSQL($cmdstr, $list) {
  /* Sometimes the same statement will be executed for several times ... only
   the value of variables need to be changed.
   In this case, you don't need to create the statement several times; 
   using bind variables can make the statement be shared and just parsed once.
   This is also very useful in protecting against SQL injection.  
      See the sample code below for how this functions is used */

  global $db_conn, $success;
  $statement = OCIParse($db_conn, $cmdstr);

  if (!$statement) {
    echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
    $e = OCI_Error($db_conn);
    echo htmlentities($e['message']);
    $success = False;
  }

  foreach ($list as $tuple) {
    foreach ($tuple as $bind => $val) {
      //echo $val;
      //echo "<br>".$bind."<br>";
      OCIBindByName($statement, $bind, $val);
      unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

    }
    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
      echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
      $e = OCI_Error($statement); // For OCIExecute errors pass the statement handle
      echo htmlentities($e['message']);
      echo "<br>";
      $success = False;
    }
  }

}

function printPaymentMethod($method) { //prints results from a select statement
  echo "<table>";
  echo "<tr><th>Card Number</th><th>Card Type</th><th>Expiry</th></tr>";

  while ($row = OCI_Fetch_Array($method, OCI_BOTH)) {
    echo "<td>" . $row["CC_NUM"] . "</td>";
    echo "<td>" . $row["CARD_TYPE"] . "</td>";
    echo "<td>" . $row["EXPIRY"] . "</td>";
    echo "</tr>"; 
  }
  echo "</table>";
}

function printBest($best) { //prints results from a select statement
  echo "<br>Best restaurants:<br>";
  echo "<table>";
  echo "<tr><th>Restaurant Name</th><th>Average Rating</th></tr>";

  while ($row = OCI_Fetch_Array($best, OCI_BOTH)) {
    echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["AVG_RATING"] . "</td></tr>"; //or just use "echo $row[0]" 
  }
  echo "</table>";
}

function printPreviousOrders($previous) { //prints results from a select statement
  echo "<br>Previous orders:<br>";
  echo "<table>";
  echo "<tr><th>Order</th><th>Order Date</th><th>Order Time</th><th>Total Cost</th><th>Driver ID</th><th>Customer ID</th><th>Food ID</th><th>Restaurant ID</th></tr>";

  while ($row = OCI_Fetch_Array($previous, OCI_BOTH)) {
    echo "<tr><td>" . $row["ORDERID"] . "</td><td>" . $row["OD_DATE"] . "</td><td>" . $row["OD_TIME"] . "</td><td>" . $row["TOTAL"] . "</td><td>" . $row["DID"] . "</td><td>" . $row["CID"] . "</td><td>" . $row["FID"] . "</td><td>" . $row["RID"] . "</td></tr>"; //or just use "echo $row[0]" 
  }
  echo "</table>";
}

function printReviews($reviews) { //prints results from a select statement
  echo "<br>Reviews:<br>";
  echo "<table>";
  echo "<tr><th>Restaurant Name</th><th>Comments</th><th>Ratings</th></tr>";

  while ($row = OCI_Fetch_Array($reviews, OCI_BOTH)) {
    echo "<tr><td>" . $row["NAME"] . "</td><td>" . $row["COMMENTS"] . "</td><td>" . $row["RATING"] . "</td></tr>"; //or just use "echo $row[0]" 
  }
  echo "</table>";
}

function printSum($sum) { //prints results from a select statement
  echo "<br>Total spent by customers:<br>";
  echo "<table>";
  echo "<tr><th>Customer ID</th><th>Total Spent</th></tr>";

  while ($row = OCI_Fetch_Array($sum, OCI_BOTH)) {
    echo "<tr><td>" . $row["CID"] . "</td><td>" . $row["SUM(PRICE)"] . "</td></tr>"; //or just use "echo $row[0]" 
  }
  echo "</table>";
}

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('selectReviews', $_POST)) {
        $rid = $_POST['selectRID'];
        $reviews = executePlainSQL("select name, rating, comments from Restaurant inner join Review on Restaurant.RID = Review.RID where Restaurant.RID='".$rid."'");
        printReviews($reviews);
        OCICommit($db_conn);

    } else if (array_key_exists('selectPreviousOrders', $_POST)) {
      $cid = $_POST['selectCID'];
      $sum = executePlainSQL("select FoodOrder.CID, sum(price) as total from FoodOrder inner join OrderedFood on FoodOrder.orderID = OrderedFood.orderID inner join FoodItem on FoodItem.FID = OrderedFood.FID where FoodOrder.CID='".$cid."' group by OrderedFood.RID, FoodOrder.CID");
      printSum($sum);
      OCICommit($db_conn);
      
    } else if (array_key_exists('selectBestSubmit', $_POST)) {
      $cuisine = $_POST['selectCuisine'];
      $best = executePlainSQL("select name, avg_rating from restaurant where cuisine='".$cuisine."'");
      printBest($best);
      OCICommit($db_conn);

    } else if (array_key_exists('updateCardSubmit', $_POST)) {
      //Getting the values from user and insert data into the table
      $tuple = array (
        ":bind1" => $_POST['updateNum'],
        ":bind2" => $_POST['updateType'],
        ":bind3" => $_POST['updateDate']
      );
      $alltuples = array (
        $tuple
      );
      executeBoundSQL("update paymentmethod set card_type=:bind2, expiry=:bind3 where cc_num=:bind1", $alltuples);
      OCICommit($db_conn);
    } 

    if (isset($_SESSION['type']) && $_SESSION['type'] == 'Customer' && isset($_SESSION['ID'])) {
      $cid = $_SESSION['ID'];
      echo "<h2>Card on File</h2>";
      $method = executePlainSQL("select * from PaymentMethod pm inner join Customer c on c.cc_num=pm.cc_num where c.cid='".$cid."'");
      printPaymentMethod($method);
      
      // echo "<h2>Previously Ordered Food Items</h2>";
      // $previous = executePlainSQL("select * from FoodOrder, OrderedFood where FoodOrder.orderID = OrderedFood.orderID and CID='".$cid."'");
      // printPreviousOrders($previous);
    }
  //Commit to save changes...
  echo "</div>";
  OCILogoff($db_conn);
} else {
  echo "cannot connect";
  $e = OCI_Error(); // For OCILogon errors pass no handle
  echo htmlentities($e['message']);
}
?>
