<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Enable or disable logging
$enableLogging = true;

function logMessage($filename, $message)
{
    global $enableLogging;
    if ($enableLogging) {
        @file_put_contents($filename, $message . PHP_EOL, FILE_APPEND);
    }
}

function getCustomerPolicies($userName, $password, $pinCode)
{
    $soapUrl = "https://insure.a-group.az/insureazSvcTest/AQroupMobileIntegrationSvc.asmx";

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

    $headers = [
        "Content-Type: text/xml; charset=utf-8",
        "SOAPAction: \"http://tempuri.org/GetCustomerPolicies\"",
        "Content-Length: " . strlen($xml_post_string),
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    if ($response === false) {
        logMessage('curl_error.log', "CURL Error: " . curl_error($ch));
        curl_close($ch);
        throw new Exception("CURL Error: " . curl_error($ch));
    }

    logMessage('soap_response.log', $response);

    curl_close($ch);

    return $response;
}

try {
    $userName = 'AQWeb';
    $password = '@QWeb';
    $pinCode = $_SESSION['pinCode'] ?? 'A222222';

    logMessage('request_params.log', "userName: $userName, password: $password, pinCode: $pinCode");

    $response = getCustomerPolicies($userName, $password, $pinCode);

    $xml = simplexml_load_string($response);
    if ($xml === false) {
        logMessage('error_log.log', "Failed to parse XML: $response");
        throw new Exception('Failed to parse XML response.');
    }

    $namespaces = $xml->getNamespaces(true);
    $soapBody = $xml->children($namespaces['soap'])->Body;
    $policiesResponse = $soapBody->children('http://tempuri.org/')->GetCustomerPoliciesResponse;
    $policiesResult = (string)$policiesResponse->GetCustomerPoliciesResult;

    $resultXml = simplexml_load_string(html_entity_decode($policiesResult));
    if (!$resultXml || !$resultXml->POLICIES) {
        logMessage('error_log.log', "Invalid policies result: $policiesResult");
        throw new Exception('Invalid policies result.');
    }

    $policies = json_decode(json_encode($resultXml), true);
    logMessage('decoded_policies.log', json_encode($policies, JSON_PRETTY_PRINT));

    // Ensure no PHP warnings interfere with the JSON response
    header('Content-Type: application/json');
    echo json_encode(['POLICIES' => $policies['POLICIES']]);
} catch (Exception $e) {
    logMessage('error_log.log', $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
