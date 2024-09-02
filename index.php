<?php
    $company__logo = './style/assets/company_logo.svg';
     function company_logo(){
        echo './style/assets/company_logo.svg';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login  A-Group</title>

    <link rel="stylesheet" href="./style/style.css">

    <link rel="shortcut icon" href="<?php company_logo() ?>" type="image/x-icon">
</head>
<body>
    <div class="login__container">
        <form action="./vendor/login.php" class="form__container">
                <div class="form__image">
                    <img src="<?php company_logo() ?>" alt="">
                </div>

                <div class="form__input__container">
                    <p class="form__input__desc">
                    userName:
                    </p>
                    <input type="text" name="username" id="username">
                </div>

                <div class="form__input__container">
                    <p class="form__input__desc">
                        password:
                    </p>
                    <input type="password" name="password" id="password">
                </div>

                <div class="form__input__container">
                    <p class="form__input__desc">
                        pinCode:
                    </p>
                    <input type="text" name="pinCode" id="pinCode">
                </div>

                <div class="form__input__container">
                    <p class="form__input__desc">
                        policyNumber:
                    </p>
                    <input type="text" name="policyNumber" id="phoneNumber">
                </div>
                <div class="form__input__container">
                    <p class="form__input__desc">
                    phoneNumber:
                    </p>
                    <input type="text" name="phoneNumber" id="phoneNumber">
                </div>

                <div class="form__input__button">
                    <button type="submit">Daxil olmaq</button>
                </div>
        </form>
    </div>
</body>
</html>