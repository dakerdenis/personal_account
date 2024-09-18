<?php
session_start(); // Start the session

// Get form data
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$pinCode = isset($_POST['pinCode']) ? $_POST['pinCode'] : '';
$policyNumber = isset($_POST['policyNumber']) ? $_POST['policyNumber'] : '';
$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';

function login($username, $password, $pinCode, $policyNumber, $phoneNumber) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx"; // API endpoint

    // SOAP Request
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">' .
        '<soap12:Body>' .
        '<Login xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($username) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '<policyNumber>' . htmlspecialchars($policyNumber) . '</policyNumber>' .
        '<phoneNumber>' . htmlspecialchars($phoneNumber) . '</phoneNumber>' .
        '</Login>' .
        '</soap12:Body>' .
        '</soap12:Envelope>';

    // SOAP Headers
    $headers = array(
        "Content-type: application/soap+xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/Login\"",
        "Content-length: " . strlen($xml_post_string),
    );

    // Initialize curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification if necessary
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Disable SSL verification if necessary

    // Execute curl and get response
    $response = curl_exec($ch);
    if ($response === false) {
        curl_close($ch);
        return false;
    }
    curl_close($ch);

    return $response;
}

try {
    // Make the login request and get the response
    $response = login($username, $password, $pinCode, $policyNumber, $phoneNumber);

    if ($response === false) {
        // Curl failed
        $_SESSION['login_error'] = 'Unable to connect to the server. Please try again.';
        header("Location: /cabinet/index.php");
        exit();
    }

    // Parse the XML response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        // Failed to parse the XML response
        $_SESSION['login_error'] = 'Server error: Invalid response format.';
        header("Location: /cabinet/index.php");
        exit();
    }

    // Extract the result
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap12'])->Body;
    $loginResult = $soapBody->children('http://tempuri.org/')->LoginResponse->LoginResult;

    // Parse the result to extract user data
    $resultXml = simplexml_load_string(html_entity_decode($loginResult));
    $isLogged = (string)$resultXml->LOGIN->IS_LOGGED;

    // Check if login was successful
    if ($isLogged == '1') {
        // Get the user's name and surname from the response
        $name = (string)$resultXml->LOGIN->NAME;
        $surname = (string)$resultXml->LOGIN->SURNAME;

        // If name or surname is missing, treat it as an invalid response
        if (empty($name) || empty($surname)) {
            $_SESSION['login_error'] = 'Invalid credentials. Please try again.';
            header("Location: /cabinet/index.php");
            exit();
        }

        // Set session data
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['otp_pending'] = true; // OTP pending
        $_SESSION['login_time'] = time(); // Set login time

        // Redirect to OTP verification page
        header("Location: /cabinet/vendor/verification.php");
        exit();
    } else {
        // Invalid credentials, set the session error flag and redirect to index.php
        $_SESSION['login_error'] = 'Invalid credentials. Please try again.';
        header("Location: /cabinet/index.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['login_error'] = 'An error occurred. Please try again.';
    header("Location: /cabinet/index.php");
    exit();
}
