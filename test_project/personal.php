<?php
session_start(); // Start the session

// Check if the user is logged in and OTP has been verified
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['otp_pending'] === true) {
    // If not, redirect to login page
    header("Location: /cabinet/index.php");
    exit();
}

// Get user details from session
$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest';
$surname = isset($_SESSION['surname']) ? htmlspecialchars($_SESSION['surname']) : '';
$pinCode = isset($_SESSION['pinCode']) ? htmlspecialchars($_SESSION['pinCode']) : 'N/A'; // Ensure pinCode is displayed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $name . ' ' . $surname; ?>!</h1>
    <p>Your PinCode: <?php echo $pinCode; ?></p> <!-- Display the pinCode -->

    <form action="./vendor/logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
