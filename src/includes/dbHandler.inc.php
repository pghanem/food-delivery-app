<?php
$dbUsername="ora_q0t0b";
$dbPassword="a51836147";
$serverName="dbhost.ugrad.cs.ubc.ca:1522/ug";

$db_conn = OCILogon($dbUsername, $dbPassword, $serverName);
// $db_conn = mysqli_connect("ora_q0t0b", "a51836147", "dbhost.ugrad.cs.ubc.ca:1522/ug");

?>