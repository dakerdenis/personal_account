<?php
ini_set('session.save_path', '/tmp'); // Set session save path
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
// Include the HTML part of the form
include 'login_form.php';
