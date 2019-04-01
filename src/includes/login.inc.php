<?php
if (isset($_POST['login-submit'])) {
    require 'dbHandler.inc.php';
    require 'executes.inc.php';

    $email = $_POST['uid'];
    $pwd = $_POST['pwd'];
    $type = $_POST['user-type'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=invalidemail");
        exit();
    }

    $sql= "";
    // echo $type;
    echo $sql;

    if ($type == 'Customer') {
        echo $type;
        $sql= $sql . "select * from customer where email='".$email."'";
    } else if ($type == 'Delivery Driver') {
        echo $type;
        $sql= $sql . "select * from DeliveryDriver where email='".$email."'";
    } else if ($type == 'Restaurant Manager') {
        echo $type;
        $sql= $sql . "select * from RestaurantManager where email='".$email."'";
    } else {
        header("Location: ../index.php?no-user");
        exit();
    }
    

    echo $sql;
    $result = executePlainSQL($sql);

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        // echo $row['FNAME']. " " .$row['EMAIL']. " " .$row['PASSWORD'] . "<br>";

        if ($row['PASSWORD'] == $pwd) {
            // echo "login";
            ini_set('session.save_path', '../' . '/');
            session_start();
            $_SESSION['EMAIL'] = $row['EMAIL'];
            $_SESSION['PWD'] = $row['PASSWORD'];
            $_SESSION['type'] = $type;
            
            if ($type == 'Customer') {
                $_SESSION['ID'] = $row['CID'];
            } else if ($type == 'Delivery Driver'){
                $_SESSION['ID'] = $row['DID'];
            } else if ($type == 'Restaurant Manager'){
                $_SESSION['ID'] = $row['MID'];
            }
            // echo $_SESSION['ID'];

            header("Location: ../index.php?login=success");
            exit();
        } else {
            header("Location: ../index.php?wrong-password");
            exit();
        }
    }
    // header("Location: ../index.php?no-user");
    // exit();
    echo "no result: " . $sql;

}
    

?>