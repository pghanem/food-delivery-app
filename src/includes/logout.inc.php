<?php
    ini_set('session.save_path', '../' . '/');
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php?logout=successful");
?>
