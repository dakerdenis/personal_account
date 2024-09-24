<?php
session_start(); // Start the session

// SOAP request to get refund payment information
function getRefundPayment($userName, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvc/AQroupMobileIntegrationSvc.asmx"; // API endpoint
    $pinCode = "6WP9W1L";
    // SOAP request
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<GetRefundPayment xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($userName) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '</GetRefundPayment>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    // SOAP headers
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetRefundPayment\"",
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

    // Parse the response and return the relevant data
    return $response;
}

// Call the function to get refund payment
try {
    // Example: Replace with actual credentials
    $userName = 'AQWeb';
    $password = '@QWeb';
    $pinCode = $_SESSION['pinCode']; // Ensure you store pinCode during login

    // Get the response from the SOAP API
    $response = getRefundPayment($userName, $password, $pinCode);

    // Extract the relevant part from the SOAP response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML response.']);
        exit();
    }

    // Extract the data inside the <string> tag
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $refundPaymentResponse = $soapBody->children('http://tempuri.org/')->GetRefundPaymentResponse;
    $refundPaymentResult = (string) $refundPaymentResponse->GetRefundPaymentResult;

    // Parse the inner XML (inside the <string>)
    $innerXml = simplexml_load_string(html_entity_decode($refundPaymentResult));
    if (!$innerXml) {
        echo json_encode(['error' => 'Failed to parse inner XML.']);
        exit();
    }

    // Convert the parsed XML to JSON and send it back
    echo json_encode($innerXml);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
