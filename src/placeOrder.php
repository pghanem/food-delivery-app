<?php
    require 'header.php';

    if (isset($_SESSION['ID']) && isset($_SESSION['type']) && $_SESSION['type'] == 'Customer') {

        if (isset($_POST)) {
            $items = $POST['foodID'];
            echo $items;
    
            $nextOrderID = nextID();
            echo $nextOrderID;

            // createNewOrder($cid, $nextOrderID);
            // setSum($nextOrderID);
        }
    }

    function nextID() {
        $current = getNumOfPreviousOrders();
        $next = "o" . (string)($current + 500);
        return $next;
    }

    // once the ordered food items have been inserted, this will total the sum under the same oid.
    function sumOrder($order) {
        totalOrderPrice($order);
    }

    // update an order with a total cost of all items 
    function setSum($oid) {
        $total = totalOrderPrice($oid);
        updateOrderWithTotal($oid, $total);
    }

?>