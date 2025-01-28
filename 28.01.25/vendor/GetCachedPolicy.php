<?php
session_start();
if (isset($_SESSION['medicalPolicyNumber'])) {
    echo json_encode(['medicalPolicyNumber' => $_SESSION['medicalPolicyNumber']]);
} else {
    echo json_encode(['medicalPolicyNumber' => null]);
}
