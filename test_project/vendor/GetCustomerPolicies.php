<?php
session_start(); // Start the session

// SOAP request to fetch customer policies
function getCustomerPolicies($userName, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx"; // API endpoint

    // Build the SOAP request XML
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<GetCustomerPolicies xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($userName) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '</GetCustomerPolicies>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    // SOAP headers
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetCustomerPolicies\"",
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
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit();
    }
    curl_close($ch);

    // Return the SOAP response
    return $response;
}

try {
    // Example: Replace with actual credentials
    $userName = 'AQWeb'; // Replace with your actual API username
    $password = '@QWeb'; // Replace with your actual API password
    $pinCode = $_SESSION['pinCode']; // Get the user's pinCode from the session

    // Call the SOAP function to get policies
    $response = getCustomerPolicies($userName, $password, $pinCode);

    // Parse the response XML
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML response']);
        exit();
    }

    // Extract the relevant data from the SOAP response
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $policiesResponse = $soapBody->children('http://tempuri.org/')->GetCustomerPoliciesResponse;
    $policiesResult = (string)$policiesResponse->GetCustomerPoliciesResult;

    // Decode the result into an XML structure
    $resultXml = simplexml_load_string(html_entity_decode($policiesResult));
    if (!$resultXml) {
        echo json_encode(['error' => 'Failed to parse policies result']);
        exit();
    }

    // Convert the result to a JSON-friendly structure
    $policies = json_decode(json_encode($resultXml), true);

    // Return the policies as a JSON response
    echo json_encode($policies);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
