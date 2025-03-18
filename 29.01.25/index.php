<?php
session_start(); // Start the session

// Check if the user is already logged in and if OTP is verified
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$otpVerified = isset($_SESSION['otp_pending']) && $_SESSION['otp_pending'] === false; // OTP should be verified

// Check if session has expired (10 minutes limit)
$loginExpired = isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 600); // 600 seconds = 10 minutes

if ($isLoggedIn && $otpVerified && !$loginExpired) {
    // If session is active and OTP is verified, redirect to personal.php
    header("Location: /cabinet/$2OpzQ3jR0%5E=/personal.php");
    exit();
} elseif ($loginExpired) {
    // If session has expired, destroy session and redirect to login
    $_SESSION = [];
    session_destroy();
    header("Location: /cabinet/$2OpzQ3jR0%5E=/index.php");
    exit();
}

// Check if there's a login error in the session
$loginError = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']); // Clear the error after displaying it
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
        <div class="login__container-form">
            <form action="./vendor/login.php" method="POST" class="form__container">
                <!-- Form fields -->
                <div class="form__input__container form__input__container-hidden">
                    <p class="form__input__desc">userName:</p>
                    <input value="AQWeb" type="text" name="username" id="username">
                </div>
                <div class="form__input__container form__input__container-hidden">
                    <p class="form__input__desc">password:</p>
                    <input value="@QWeb" type="password" name="password" id="password">
                </div>

                <div class="form__desc">
                    <p>Xoş gəldiniz!</p>
                    <span>A-Group şəxsi kabineti</span>
                </div>

                <div class="form__input__container">
                    <p class="form__input__desc">Fin kodu:</p>
                    <input placeholder="0000000" type="text" name="pinCode" id="pinCode">
                </div>
                <div class="form__input__container">    
                    <p class="form__input__desc">Şəhədətnamə nömrəsi:</p>
                    <input placeholder="Şəhədətnamə nömrəsi" type="text" name="policyNumber" id="policyNumber">
                </div>
                <div class="form__input__container">
                    <p class="form__input__desc">Mobil nömrə:</p>
                    <input placeholder="994XXXXXXXXX"  type="text" name="phoneNumber" id="phoneNumber">
                </div>

                <div class="form__input__button">
                    <button type="submit">Daxil olmaq</button>
                </div>

                <?php if ($loginError): ?>
                    <!-- Display the error message if there's an error -->
                    <div class="error__container">
                        <?php echo htmlspecialchars($loginError); ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="login__logo">
            <img src="./style/assets/company_logo.svg" alt="" srcset="">
        </div>

        <div class="login__container-image">
            <img src="https://a-group.az/storage/uploaded_files/WZ0D/login.jpg" alt="">
        </div>
    </div>
</body>

</html>
