<?php
    $connection = mysqli_connect('localhost', 'root', '', 'test');
    if(isset($_GET['clinic_id'])){

        $clinic_id = $_GET['clinic_id'];

        $query = "DELETE FROM clinics WHERE id = {$clinic_id}";

        $delete_clinic = mysqli_query($connection, $query);


        if(!$delete_clinic){
            die("QUERY FAILED ." . mysqli_error($connection));
        } else {
            echo "SUCCES";
        }

        header("Location: ./index.php");
    }
    header("Location: ./index.php");

?>