<?php
session_start(); // Start the session

// Check if the request is a POST request (i.e., form submission)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // If it's not a POST request, redirect to the login page
    header("Location: /cabinet/index.php");
    exit();
}

// Log the session path and session ID for debugging
error_log("Session ID: " . session_id());
error_log("Session save path: " . ini_get('session.save_path'));

// Get form data
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$pinCode = isset($_POST['pinCode']) ? $_POST['pinCode'] : '';
$policyNumber = isset($_POST['policyNumber']) ? $_POST['policyNumber'] : '';
$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';

// Log form data to ensure the correct values are being received
error_log("Form data: Username: $username, Password: $password, PinCode: $pinCode, Policy: $policyNumber, Phone: $phoneNumber");

function login($username, $password, $pinCode, $policyNumber, $phoneNumber)
{
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx"; // API endpoint

    // SOAP Request matching Postman structure
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

    // SOAP Headers (matching Postman request)
    $headers = array(
        "Content-type: text/xml; charset=utf-8",  // Match Postman header
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
        error_log("Curl error: " . curl_error($ch)); // Log curl error
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

    // Return the SOAP response
    return $response;
}

try {
    // Make the login request and get the response
    $response = login($username, $password, $pinCode, $policyNumber, $phoneNumber);

    // Parse the XML response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo "Failed to parse XML. Response: <br><pre>$response</pre><br>"; // Echo failed XML parsing
        exit;
    }

    // Extract the SOAP body and response
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $loginResponse = $soapBody->children('http://tempuri.org/')->LoginResponse;
    $loginResult = (string) $loginResponse->LoginResult;

    // Parse the login result to extract user data
    $resultXml = simplexml_load_string(html_entity_decode($loginResult));
    $isLogged = (string)$resultXml->LOGIN->IS_LOGGED;

    if ($isLogged == '1') {
    // Get the user's name, surname, and pinCode
    $name = (string)$resultXml->LOGIN->NAME;
    $surname = (string)$resultXml->LOGIN->SURNAME;
    $pinCode = htmlspecialchars($pinCode); // Make sure it's sanitized

        // Set session data
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['phoneNumber'] = $phoneNumber; // Store the user's phone number for OTP generation
        $_SESSION['pinCode'] = $pinCode; 
        $_SESSION['otp_pending'] = true; // OTP pending
        $_SESSION['login_time'] = time(); // Set login time

        // Redirect to otp.php to generate and send the OTP
        header("Location: /cabinet/vendor/otp.php");
        exit();
    } else {
        echo "Invalid credentials";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "<br>"; // Echo exceptions
    exit();
}
