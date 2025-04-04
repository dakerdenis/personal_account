<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login A-Group</title>

    <link rel="stylesheet" href="./style/style.css">

    <link rel="shortcut icon" href="<?php echo './style/assets/company_logo.svg'; ?>" type="image/x-icon">
</head>

<body>
    <div class="login__container">
        <form action="./vendor/login.php" method="POST" class="form__container">
            <div class="form__image">
                <img src="<?php echo './style/assets/company_logo.svg'; ?>" alt="">
            </div>

            <div class="form__input__container">
                <p class="form__input__desc">
                    userName:
                </p>
                <input value="AQWeb" type="text" name="username" id="username">
            </div>

            <div class="form__input__container">
                <p class="form__input__desc">
                    password:
                </p>
                <input value="@QWeb" type="password" name="password" id="password">
            </div>

            <div class="form__input__container">
                <p class="form__input__desc">
                    pinCode:
                </p>
                <input value="A111111" type="text" name="pinCode" id="pinCode">
            </div>

            <div class="form__input__container">
                <p class="form__input__desc">
                    policyNumber:
                </p>
                <input value="MDC2400047-100887/01" type="text" name="policyNumber" id="policyNumber">
            </div>

            <div class="form__input__container">
                <p class="form__input__desc">
                    phoneNumber:
                </p>
                <input value="994516704118" type="text" name="phoneNumber" id="phoneNumber">
            </div>

            <div class="form__input__button">
                <button type="submit">Daxil olmaq</button>
            </div>
        </form>
    </div>
</body>

</html>
