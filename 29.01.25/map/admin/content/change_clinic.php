<?php
            $connection = mysqli_connect('localhost', 'root', '', 'test');
            if(isset($_POST['change_clinic'])){

                $city   = $_POST['city'];
                $clinic_name   = $_POST['clinic_name'];
                $phone  = $_POST['phone'];
                $adress = $_POST['adress'];
                $adress2   = $_POST['adress2'];
                $email  = $_POST['email'];
                $id = $_POST['clinic_id'];


                $query = "UPDATE clinics SET clinic_name = '{$clinic_name}', numbers = '{$phone}',
                 adress = '{$adress}', adress2 = '{$adress2}',
                   email = '{$email}', city = '{$city}'  
                   WHERE id = '{$id}' ";

                $update_clinic = mysqli_query($connection, $query);

                echo $query;


                if(!$update_clinic){
                    die("QUERY FAILED ." . mysqli_error($connection));
                } else {
                    echo "SUCCES";
                }
                header("Location: ./index.php");

             }
?>