<?php

    session_start();
    UNSET( $_SESSION['login']);
    UNSET( $_SESSION['username']);
    header("Location: ../admin.php");
    session_write_close();
    exit();

?>