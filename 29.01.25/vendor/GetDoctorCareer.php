<?php
session_start(); // Start the session

// SOAP request to get doctor's career
function getDoctorCareer($userName, $password, $doctorId) {
    $soapUrl = "https://insure.a-group.az/insureazSvcTest/AQroupMobileIntegrationSvc.asmx"; // API endpoint

    // SOAP request
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<GetDoctorCareer xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($userName) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<doctorId>' . htmlspecialchars($doctorId) . '</doctorId>' .
        '</GetDoctorCareer>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    // SOAP headers
    $headers = array(
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetDoctorCareer\"",
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

// Call the function to get doctor's career
try {
    // Example: Replace with actual credentials
    $userName = 'AQWeb';
    $password = '@QWeb';
    $doctorId = $_POST['doctorId']; // Get doctor ID from POST request

    // Get the response from the SOAP API
    $response = getDoctorCareer($userName, $password, $doctorId);

    // Extract the relevant part from the SOAP response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode(['error' => 'Failed to parse XML response.']);
        exit();
    }

    // Extract the data inside the <string> tag
    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $careerResponse = $soapBody->children('http://tempuri.org/')->GetDoctorCareerResponse;
    $careerResult = (string) $careerResponse->GetDoctorCareerResult;

    // Parse the inner XML (inside the <string>)
    $innerXml = simplexml_load_string(html_entity_decode($careerResult));
    if (!$innerXml) {
        echo json_encode(['error' => 'Failed to parse inner XML.']);
        exit();
    }

    // Convert the parsed XML to JSON and send it back
    echo json_encode($innerXml);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
