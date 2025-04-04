<?php
session_start();
header("Content-Type: application/json");

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['medicalPolicies']) && is_array($data['medicalPolicies'])) {
    $_SESSION['medicalPolicies'] = $data['medicalPolicies'];
    echo json_encode(["success" => true, "message" => "Policies stored in session"]);
} else {
    echo json_encode(["success" => false, "message" => "No valid policies received"]);
}
exit;
