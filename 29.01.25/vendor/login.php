<?php
session_start(); // Start the session

// Get form data
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$pinCode = isset($_POST['pinCode']) ? $_POST['pinCode'] : '';
$policyNumber = isset($_POST['policyNumber']) ? $_POST['policyNumber'] : '';
$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';

// Log form data for debugging
error_log("Form data received: Username=$username, Password=$password, PinCode=$pinCode, PolicyNumber=$policyNumber, PhoneNumber=$phoneNumber");

function login($username, $password, $pinCode, $policyNumber, $phoneNumber) {
    $soapUrl = "https://insure.a-group.az/insureazSvcTest/AQroupMobileIntegrationSvc.asmx"; // SOAP endpoint

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

    // Log the SOAP request for debugging
    error_log("SOAP request: $xml_post_string");

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
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Execute curl and get response
    $response = curl_exec($ch);
    if ($response === false) {
        error_log("Curl error: " . curl_error($ch)); // Log curl error
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

    // Log the raw SOAP response for debugging
    error_log("SOAP response: $response");

    return $response;
}

try {
    // Make the login request and get the response
    $response = login($username, $password, $pinCode, $policyNumber, $phoneNumber);

    // Check if the SOAP response contains valid data
    if (!$response) {
        error_log("Empty response from server");
        $_SESSION['login_error'] = 'Invalid response from server. Please try again.';
        header("Location: /cabinet/index.php");
        exit();
    }

    // Use regex to extract the LoginResult XML part manually
    if (preg_match('/<LoginResult>(.*?)<\/LoginResult>/s', $response, $matches)) {
        $loginResult = htmlspecialchars_decode($matches[1]);
        $cleanedLoginResult = trim($loginResult);

        // Log the cleaned LoginResult for debugging
        error_log("Cleaned LoginResult: $cleanedLoginResult");

        // Parse the cleaned result directly
        $loginXml = simplexml_load_string($cleanedLoginResult);
        if ($loginXml === false) {
            error_log("Failed to parse cleaned LoginResult: $cleanedLoginResult");
            echo "<h1>Failed to parse cleaned LoginResult</h1>";
            exit();
        }

        // Log successful parsing
        error_log("Successfully parsed LoginResult");

        // Access the IS_LOGGED, NAME, and SURNAME values
        $isLogged = (string)$loginXml->LOGIN->IS_LOGGED;
        $name = (string)$loginXml->LOGIN->NAME;
        $surname = (string)$loginXml->LOGIN->SURNAME;

        // Log the parsed values
        error_log("Parsed IS_LOGGED: $isLogged, Name: $name, Surname: $surname");

        // Check if the user is logged in based on IS_LOGGED value
        if ($isLogged === '1') {
            // Set session data
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $name;
            $_SESSION['surname'] = $surname;
            $_SESSION['otp_pending'] = true; // OTP is now pending
            $_SESSION['login_time'] = time(); // Store login time
            $_SESSION['phoneNumber'] = $phoneNumber; // Store phone number for OTP
            $_SESSION['pinCode'] = $pinCode;

            // Log session data for verification
            error_log("Session data after login: " . print_r($_SESSION, true));

            // Redirect to otp.php to generate OTP and send SMS
            header("Location: /cabinet/vendor/otp.php"); // This will generate OTP and redirect to verification.php
            exit();
        } else {
            // If IS_LOGGED is not 1, show an error message
            error_log("Invalid credentials. IS_LOGGED=$isLogged");
            $_SESSION['login_error'] = 'Invalid credentials. Please try again.';
            header("Location: /cabinet/index.php");
            exit();
        }
    } else {
        // If LoginResult is missing, show an error
        error_log("LoginResult not found in the SOAP response");
        $_SESSION['login_error'] = 'Invalid response from server. Please try again.';
        header("Location: /cabinet/index.php");
        exit();
    }
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage()); // Log exceptions
    echo json_encode(['error' => $e->getMessage()]);
}
