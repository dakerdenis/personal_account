<?php
header('Content-Type: application/json');

// Get the input JSON
$input = file_get_contents('php://input');
$formData = json_decode($input, true);

// Log the received form data for debugging
error_log("Received form data: " . print_r($formData, true));

// Log individual fields
error_log("Username: " . $username);
error_log("Password: " . $password);
error_log("PinCode: " . $pinCode);
error_log("PolicyNumber: " . $policyNumber);
error_log("PhoneNumber: " . $phoneNumber);

// Extract form data
$username = $formData['username'];
$password = $formData['password'];
$pinCode = $formData['pinCode'];
$policyNumber = isset($formData['policyNumber']) ? $formData['policyNumber'] : null;
$phoneNumber = isset($formData['phoneNumber']) ? $formData['phoneNumber'] : null;

// SOAP login method
function login($username, $password, $pinCode, $policyNumber, $phoneNumber) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx";
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

    // Log the exact XML request being sent
    error_log("SOAP Request: " . $xml_post_string);

    return sendSoapRequest($soapUrl, $xml_post_string, 'Login');
}

// Helper function to send the SOAP request
function sendSoapRequest($soapUrl, $xml_post_string, $soapAction) {
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/$soapAction\"",
        "Content-length: " . strlen($xml_post_string),
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification

    $response = curl_exec($ch);
    if ($response === false) {
        error_log("CURL error: " . curl_error($ch)); // Log curl errors
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    // Log the exact SOAP response from the server
    error_log("SOAP Response: " . $response);

    curl_close($ch);
    return $response;
}

try {
    $response = login($username, $password, $pinCode, $policyNumber, $phoneNumber);
    error_log("SOAP Response: " . print_r($response, true)); // Log the full SOAP response
    
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        error_log("Failed to parse XML. Response: " . $response); // Log XML parsing failure
        echo json_encode(['error' => 'Failed to parse XML']);
        exit;
    }
    

    // Extract login result
    $loginResult = $xml->xpath('//LOGIN')[0];
    $isLogged = (string) $loginResult->IS_LOGGED;
    $name = (string) $loginResult->NAME;
    $surname = (string) $loginResult->SURNAME;

    // Log the login result for debugging
    error_log("Login Result: " . print_r($loginResult, true));

    // Return the result
    if ($isLogged === '1') {
        echo json_encode(['name' => $name, 'surname' => $surname, 'result' => $response]);
    } else {
        echo json_encode(['error' => 'Invalid login credentials']);
    }
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}
