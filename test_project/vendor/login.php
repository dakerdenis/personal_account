<?php
session_start(); // Start the session

header('Content-Type: application/json');

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
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<Login xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($username) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '<policyNumber>' . htmlspecialchars($policyNumber) . '</policyNumber>' .
        '<phoneNumber>' . htmlspecialchars($phoneNumber) . '</phoneNumber>' .
        '</Login>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    // SOAP Headers
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
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
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

    return $response;
}

try {
    $response = login($username, $password, $pinCode, $policyNumber, $phoneNumber);

    // Parse the XML response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML', 'response' => $response]);
        exit;
    }

    // Extract data from the response
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $loginResult = $soapBody->children('http://tempuri.org/')->LoginResponse->LoginResult;

    // Parse the result to extract user data
    $resultXml = simplexml_load_string(html_entity_decode($loginResult));
    $isLogged = (string)$resultXml->LOGIN->IS_LOGGED;

    if ($isLogged == '1') {
        // Get the user's name, surname, and pinCode
        $name = (string)$resultXml->LOGIN->NAME;
        $surname = (string)$resultXml->LOGIN->SURNAME;

        // Store user data in session
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['pinCode'] = $pinCode;
        $_SESSION['login_time'] = time(); // Set session login time

        // Redirect to personal.php
        header("Location: /cabinet/personal.php");
        exit();
    } else {
        // Handle failed login
        echo json_encode(['error' => 'Invalid credentials']);
    }

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
