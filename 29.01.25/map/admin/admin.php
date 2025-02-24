
<?php session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./admin.css">
    <style>
        .login__form_desc {
            width: 100%;
            text-align: center;
            font-size: 17px;
            margin-top: 15px;

        }

        .login__input_data {
            margin-top: 15px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-evenly;
        }

        .login__input_data p {
            font-size: 16px;
            font-weight: 500;
            width: 30%;
        }

        .login__input_data input {
            display: block;
            width: 60%;
            border: 1.4px solid rgba(215, 31, 36, 0.2);
            border-radius: 5px;
            padding: 5px;
            margin-top: 5px;
            font-size: 15px;
            font-weight: 500;
        }

        .login__input_data input:focus {
            border: 1.4px solid rgba(215, 31, 36, 0.9);
        }

        .login_button {
            margin-top: 20px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .login_button input {
            font-size: 19px;
            color: #fff;
            background-color: #d71f24;
            padding: 10px 55px 10px 55px;
            border-radius: 10px;
            border: 2px solid #d71f24;
            transition: ease-in-out 0.2s;
            font-weight: 500;
            cursor: pointer;
        }

        .login_button input:hover {
            background-color: #fff;
            color: #d71f24;
        }
        .msg{
            width: 100%;
            display: block;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 8px;
            font-size: 18px;
            color: #d71f24;
        }
    </style>
</head>

<body>
    <div class="main__wrapper">
        <div class="login__container">
            <form class="login__form" action="./vendor/login.php">
                <div class="login__form__image">
                    <img src="./imgs/Logo.svg" alt="">
                </div>
                <div class="login__form_desc">Вход в админ панель</div>
                <div class="login__input_data">
                    <p>Username</p>
                    <input type="text" name="username" id="username">
                </div>

                <div class="login__input_data">
                    <p>Password</p>
                    <input type="password" name="password" id="password">
                </div>

                <div class="login_button">
                    <input type="submit" value="Войти">
                </div>

                <?php
                            if (isset($_SESSION['message_pass'])) {
                                echo '<p class="msg"> ' . $_SESSION['message_pass'] . ' </p>';
                            } echo "";
                            unset($_SESSION['message_pass']);
                            ?>
            </form>
        </div>
    </div>
</body>

</html>