<?php
require_once 'database/config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'All fields are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email address';
    } else {
        try {
            save_message($name, $email, $message);
            $response['success'] = true;
            $response['message'] = 'Message sent successfully!';
        } catch (Exception $e) {
            $response['message'] = 'An error occurred. Please try again later.';
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);