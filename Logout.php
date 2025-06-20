<?php
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    session_unset(); 
    session_destroy();

    http_response_code(200); 
    echo json_encode(['success' => true, 'message' => 'Logged out successfully']);

    }else {
        
        http_response_code(400); 
        echo json_encode(['success' => false, 'error' => 'No user is logged in']);
    }
?>