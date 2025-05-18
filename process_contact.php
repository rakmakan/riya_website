<?php
require_once 'database/config.php';

header('Content-Type: application/json');

// Validate CSRF token if implemented
session_start();

$response = ['success' => false, 'message' => ''];

// Validate inputs
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
    $response['message'] = 'Please fill in all required fields.';
    echo json_encode($response);
    exit;
}

$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Please enter a valid email address.';
    echo json_encode($response);
    exit;
}

// Configure email settings
$to = "your-email@example.com"; // Replace with your email
$subject = "New Contact Form Submission from Portfolio";
$headers = "From: " . $email . "\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Create email body
$email_body = "
<html>
<head>
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {$name}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Message:</strong></p>
    <p>" . nl2br($message) . "</p>
</body>
</html>
";

// Send email
if (mail($to, $subject, $email_body, $headers)) {
    $response['success'] = true;
    $response['message'] = 'Thank you for your message. I will get back to you soon!';
} else {
    $response['message'] = 'Sorry, there was an error sending your message. Please try again later.';
}

echo json_encode($response);