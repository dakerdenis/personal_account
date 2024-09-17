<?php
session_start(); // Start the session

// Check if the user is already logged in and if OTP is verified
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$otpVerified = isset($_SESSION['otp_pending']) && $_SESSION['otp_pending'] === false; // OTP should be verified

// Check if session has expired (10 minutes limit)
$loginExpired = isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 600); // 600 seconds = 10 minutes

if ($isLoggedIn && $otpVerified && !$loginExpired) {
    // If session is active and OTP is verified, redirect to personal.php
    header("Location: /cabinet/personal.php");
    exit();
} elseif ($loginExpired) {
    // If session has expired, destroy session and redirect to login
    $_SESSION = [];
    session_destroy();
    header("Location: /cabinet/index.php");
    exit();
}

// If the user is not logged in, show the login form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login A-Group</title>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <div class="login__container">
        <form action="./vendor/login.php" method="POST" class="form__container">
            <div class="form__image">
                <img src="<?php echo './style/assets/company_logo.svg'; ?>" alt="">
            </div>
            <div class="form__input__container">
                <p class="form__input__desc">userName:</p>
                <input value="AQWeb" type="text" name="username" id="username">
            </div>
            <div class="form__input__container">
                <p class="form__input__desc">password:</p>
                <input value="@QWeb" type="password" name="password" id="password">
            </div>
            <div class="form__input__container">
                <p class="form__input__desc">pinCode:</p>
                <input value="A111111" type="text" name="pinCode" id="pinCode">
            </div>
            <div class="form__input__container">
                <p class="form__input__desc">policyNumber:</p>
                <input value="MDC2400047-100887/01" type="text" name="policyNumber" id="policyNumber">
            </div>
            <div class="form__input__container">
                <p class="form__input__desc">phoneNumber:</p>
                <input value="994507506901" type="text" name="phoneNumber" id="phoneNumber">
            </div>
            <div class="form__input__button">
                <button type="submit">Daxil olmaq</button>
            </div>
        </form>
    </div>
</body>
</html>
