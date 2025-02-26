<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['medicalPolicies']) && is_array($data['medicalPolicies'])) {
    $_SESSION['medical_policies'] = $data['medicalPolicies'];
    echo json_encode(["success" => true, "stored_policies" => $_SESSION['medical_policies']]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
}
?>
