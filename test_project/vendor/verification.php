<?php
session_start(); // Start the session

// Ensure the user has logged in, OTP is pending, and this is the first time accessing the page
if (!isset($_SESSION['otp_pending']) || $_SESSION['otp_pending'] !== true || isset($_SESSION['otp_attempted'])) {
    // If OTP is not pending or the user has already accessed this page, redirect to the login page
    header("Location: /cabinet/index.php");
    exit();
}



// Mark that the user has accessed the OTP verification page
$_SESSION['otp_attempted'] = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = isset($_POST['otp']) ? $_POST['otp'] : '';


    // Check if the entered OTP matches the generated one (in this case, 1234 for testing)
    if ($enteredOtp == $_SESSION['otp']) {
        // OTP is correct, mark OTP as verified
        $_SESSION['otp_pending'] = false; // OTP is now verified
        $_SESSION['loggedin'] = true;
        $_SESSION['login_time'] = time(); // Set session login time

        // Store in cookies (expire in 1 hour)
        setcookie('loggedin', true, time() + 3600, "/"); // 1 hour expiration
        setcookie('name', $_SESSION['name'], time() + 3600, "/");
        setcookie('surname', $_SESSION['surname'], time() + 3600, "/");
        setcookie('pinCode', $_SESSION['pinCode'], time() + 3600, "/");

        // Clear the otp_attempted flag since verification is complete
        unset($_SESSION['otp_attempted']);

        // Redirect to personal.php
        header("Location: /cabinet/personal.php");
    // Debugging session values (remove this after checking)
    var_dump($_SESSION); // Check session values after login and OTP check

    } else {
        var_dump($_SESSION); 
        // OTP is incorrect, destroy session and redirect to login
        $_SESSION = [];
        session_destroy();
        header("Location: /cabinet/index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <h1>OTP Verification</h1>
    <p>An OTP has been sent to your registered contact. Please enter it below to verify.</p>

    <form action="./verification.php" method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
