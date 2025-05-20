<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/config.php';

header('Content-Type: application/json');

// Debug - Log incoming data
error_log("POST data: " . print_r($_POST, true));
error_log("REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);

// Validate CSRF token if implemented
session_start();

$response = ['success' => false, 'message' => ''];

// Validate inputs
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
    $response['message'] = 'Please fill in all required fields. Received: ' . 
                          'name=' . (isset($_POST['name']) ? 'set' : 'not set') . ', ' .
                          'email=' . (isset($_POST['email']) ? 'set' : 'not set') . ', ' .
                          'message=' . (isset($_POST['message']) ? 'set' : 'not set');
    echo json_encode($response);
    exit;
}

// Replace deprecated FILTER_SANITIZE_STRING with htmlspecialchars
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Please enter a valid email address.';
    echo json_encode($response);
    exit;
}

// Save to database using the existing function
$saved = save_message($name, $email, $message);
if (!$saved) {
    error_log("Failed to save contact form data to database: " . $db->lastErrorMsg());
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
    
    // Redirect to thank you page if desired
    if (isset($_POST['redirect']) && $_POST['redirect'] == 'true') {
        header('Location: ../views/thank-you.php');
        exit;
    }
} else {
    $response['message'] = 'Sorry, there was an error sending your message. Please try again later.';
}

echo json_encode($response);
?>