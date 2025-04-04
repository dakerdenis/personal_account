<?php
session_start();
header("Content-Type: application/json");

// Debugging log
error_log("Session medical policies: " . print_r($_SESSION['medicalPolicies'], true));

if (isset($_SESSION['medicalPolicies']) && is_array($_SESSION['medicalPolicies'])) {
    echo json_encode($_SESSION['medicalPolicies']);
} else {
    echo json_encode([]);
}
exit;
?>
