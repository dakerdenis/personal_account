<?php
session_start();

function getNonMedicalClaimInformations($userName, $password, $pinCode) {
    $soapUrl = "https://insure.a-group.az/insureazSvcTest/AQroupMobileIntegrationSvc.asmx";

    // Build the SOAP request XML
    $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>' .
        '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
        'xmlns:xsd="http://www.w3.org/2001/XMLSchema" ' .
        'xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' .
        '<soap:Body>' .
        '<GetNonMedicalClaimInformations xmlns="http://tempuri.org/">' .
        '<userName>' . htmlspecialchars($userName) . '</userName>' .
        '<password>' . htmlspecialchars($password) . '</password>' .
        '<pinCode>' . htmlspecialchars($pinCode) . '</pinCode>' .
        '</GetNonMedicalClaimInformations>' .
        '</soap:Body>' .
        '</soap:Envelope>';

    // SOAP headers
    $headers = [
        "Content-type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetNonMedicalClaimInformations\"",
        "Content-length: " . strlen($xml_post_string),
    ];

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

    // Return raw SOAP response for debugging
    return $response;
}

try {
    $userName = 'AQWeb';
    $password = '@QWeb';
    $pinCode = $_SESSION['pinCode'];

    $response = getNonMedicalClaimInformations($userName, $password, $pinCode);

    // Return raw SOAP response for debugging in the frontend
    echo json_encode([
        'rawResponse' => $response,
    ]);

    // Parse the SOAP response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        echo json_encode([
            'error' => 'Failed to parse XML response',
            'rawResponse' => $response,
        ]);
        exit();
    }

    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $claimResponse = $soapBody->children('http://tempuri.org/')->GetNonMedicalClaimInformationsResponse;
    $claimResult = (string) $claimResponse->GetNonMedicalClaimInformationsResult;

    // Parse the nested XML inside <string>
    $resultXml = simplexml_load_string(html_entity_decode($claimResult));
    if (!$resultXml || !$resultXml->DocumentElement->CLM_NOTICES) {
        echo json_encode([
            'CLM_NOTICE_DISPETCHER' => [],
            'rawNestedResponse' => $claimResult, // Add raw nested response for debugging
        ]);
        exit();
    }

    // Convert XML to array
    $notices = $resultXml->DocumentElement->CLM_NOTICES;

    $complaints = [];
    foreach ($notices as $notice) {
        $complaints[] = [
            'PIN_CODE' => (string) $notice->PIN_CODE ?? 'N/A',
            'POLICY_NUMBER' => (string) $notice->POLICY_NUMBER ?? 'N/A',
            'INSURANCE_CODE' => (string) $notice->INSURANCE_CODE ?? 'N/A',
            'EVENT_OCCURRENCE_DATE' => (string) $notice->EVENT_OCCURRENCE_DATE ?? 'N/A',
            'STATUS_NAME' => (string) $notice->STATUS_NAME ?? 'N/A',
        ];
    }

    echo json_encode(['CLM_NOTICE_DISPETCHER' => $complaints]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
