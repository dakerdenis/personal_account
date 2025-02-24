<?php
    ob_start();
    session_start();

    $connection = mysqli_connect('localhost', 'root', '', 'test');

if($_POST['submit']=true){
    $username = $_GET['username'];
    $password = $_GET['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);


    $query_users = "SELECT * FROM `users` WHERE `username` LIKE '$username'";
    $users = mysqli_query($connection, $query_users);

    if(!$users){
        die("QUERY FAILED" . mysqli_error($connection));
    }

     $row = mysqli_fetch_assoc($users);

     $db_username = $row['username'];
     $db_password = $row['password'];

     if($username == $db_username && $password == $db_password){
        session_start();
        $_SESSION['username'] = 'admin';
        $_SESSION['login'] = 'admin';
        
        header("Location: ../content/index.php");
        session_write_close(); 
        ob_end_flush();
         exit();
     } else {
        $_SESSION['message_pass'] = 'Неправильный логин или пароль !';
        header("Location: ../admin.php");
        session_write_close(); 
        ob_end_flush();
 exit();
     }
     


} else {
    echo 'error';
}
