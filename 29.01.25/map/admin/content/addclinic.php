<?php
        $connection = mysqli_connect('localhost', 'root', '', 'test');
        if(isset($_POST['add_clinic'])){
            $id = $_POST['id'];
            $city   = $_POST['city'];
            $clinic_name   = $_POST['clinic_name'];
            $phone  = $_POST['phone'];
            $adress = $_POST['adress'];
            $adress2   = $_POST['adress2'];
            $email  = $_POST['email'];
    
            $query3 = "INSERT INTO clinics (id, clinic_name, numbers, adress, adress2, email, city) ";
            $query3 .= " VALUES ('{$id}', '{$clinic_name}', '{$phone}', '{$adress}', '{$adress2}', '{$email}', '{$city}'); ";
            
            $cities = mysqli_query($connection, $query3);
    
            
            if(!$cities){
                die("QUERY FAILED ." . mysqli_error($connection));
            } else {
                echo "SUCCES";
            }
    
            header("Location: ./index.php");
            
        }

?>