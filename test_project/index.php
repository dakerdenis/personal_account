<?php
$company__logo = './style/assets/company_logo.svg';
function company_logo()
{
    echo './style/assets/company_logo.svg';
}

session_start(); // Start the session



// Check if the user is already logged in using session
$isLoggedInSession = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$isOtpPending = isset($_SESSION['otp_pending']) && $_SESSION['otp_pending'] === true; // OTP pending flag

// Check session expiration (1 hour from login time)
$loginExpired = isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 3600);

if ($isLoggedInSession && !$loginExpired && $isOtpPending) {
    // If the user is logged in but hasn't completed OTP verification, redirect to verification
    header("Location: /cabinet/vendor/verification.php");
    exit();
} elseif ($isLoggedInSession && !$loginExpired && !$isOtpPending) {
    // If session exists, OTP is verified and not expired, redirect to personal.php
    header("Location: /cabinet/personal.php");
    exit();
} elseif ($loginExpired) {
    // If the session has expired, destroy it and redirect to login
    $_SESSION = [];
    session_destroy();
    header("Location: /cabinet/index.php");
    exit();
}

// If the user is not logged in, continue to show the login form
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login A-Group</title>

    <link rel="stylesheet" href="./style/style.css">

    <link rel="shortcut icon" href="<?php company_logo() ?>" type="image/x-icon">
</head>

<body>
    <div class="login__container">
        <form action="./vendor/login.php" method="POST" class="form__container">
            <div class="form__image">
                <img src="<?php company_logo() ?>" alt="">
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
