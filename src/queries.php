<?php 
    require 'includes/executes.inc.php';


function getFoodItemsBy($rid) {
    $sql = "select fi.name as fname, r.rid, dietary_type, price, description, fi.fid, fi.category from FoodItem fi inner join Restaurant r on fi.rid=r.rid where fi.rid='".$rid."'";

    return executePlainSQL($sql);
}

function getReviewsFor($rid) {
    $sql = "select re.rating, r.name, c.fname, c.lname, re.comments from Review re inner join Restaurant r on re.rid=r.rid inner join Customer c on re.cid=c.cid where r.rid='".$rid."'";

    return executePlainSQL($sql);
}

function getAllRestaurants() {
    $sql = "select * from Restaurant r inner join Address a on r.addressID=a.addressID";

    return executePlainSQL($sql);
}

function getNumOfPreviousOrders() {
    $sql = "select COUNT(orderID) as ordercount from FoodOrder";

    return executePlainSQL($sql);
}

function totalOrderPrice($oid) {
    $sql = "select sum(fi.price) as total from OrderedFood ordered inner join FoodItem fi on ordered.fid=fi.fid where ordered.orderID='".$oid."'";

    return executePlainSQL($sql);
}

function updateOrderWithTotal($oid, $total) {
    $sql = "update FoodOrder fo set total='".$total."' where orderID='".$oid."'";

    executePlainSQL($sql);
}

function createNewOrder($cid, $orderID) {
    $DID = "d0001";
    $od_date = "20181115";
    $od_time = "0242";

    $sql = "insert into FoodOrder values ('".$orderID."', '".$od_date."', '".$od_time."', '0', '".$DID."', '".$cid."'";

    executePlainSQL($sql);
}

function allFoodBelongingToManagersRestaurant($mid) {
    $sql = "select * from FoodItem f inner join RestaurantManager m where m.MID='". $_SESSION['ID'] ."' and m.RID=f.RID";

    return executePlainSQL($sql);
}   

function findPaymentMethod($cid) {
    $sql = "select * from PaymentMethod pm inner join Customer c on c.cc_num=pm.cc_num where c.cid='".$cid."'";
    executePlainSQL($sql);
}
