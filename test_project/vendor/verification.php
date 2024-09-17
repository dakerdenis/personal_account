<?php
session_start(); // Start the session

// Ensure the user is logged in and OTP is pending
if (!isset($_SESSION['otp_pending']) || $_SESSION['otp_pending'] !== true) {
    // Redirect to login if OTP is not pending
    header("Location: /cabinet/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = isset($_POST['otp']) ? $_POST['otp'] : '';

    // Check if the entered OTP matches the expected one (hardcoded as 1234 for testing)
    if ($enteredOtp == '1234') {
        // OTP is correct, mark as logged in
        $_SESSION['otp_pending'] = false; // OTP validated
        $_SESSION['loggedin'] = true;

        // Redirect to personal.php
        header("Location: /cabinet/personal.php");
        exit();
    } else {
        // If OTP is incorrect, destroy session and redirect to login
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
    <p>Enter OTP (1234 for testing):</p>
    <form action="" method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
