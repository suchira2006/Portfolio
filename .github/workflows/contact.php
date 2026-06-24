<?php
/**
 * Contact Form Handler - Suchi Sudda Portfolio
 * Validates and processes contact form submissions
 */

header('Content-Type: application/json');

// Initialize response
$response = [
    'success' => false,
    'message' => ''
];

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// Get and sanitize form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate Name
if (empty($name)) {
    $response['message'] = 'Please enter your name.';
    echo json_encode($response);
    exit;
}

if (strlen($name) < 2 || strlen($name) > 100) {
    $response['message'] = 'Name must be between 2 and 100 characters.';
    echo json_encode($response);
    exit;
}

// Validate Email
if (empty($email)) {
    $response['message'] = 'Please enter your email address.';
    echo json_encode($response);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Please enter a valid email address.';
    echo json_encode($response);
    exit;
}

// Validate Subject
if (empty($subject)) {
    $response['message'] = 'Please enter a subject.';
    echo json_encode($response);
    exit;
}

if (strlen($subject) < 3 || strlen($subject) > 200) {
    $response['message'] = 'Subject must be between 3 and 200 characters.';
    echo json_encode($response);
    exit;
}

// Validate Message
if (empty($message)) {
    $response['message'] = 'Please enter your message.';
    echo json_encode($response);
    exit;
}

if (strlen($message) < 10 || strlen($message) > 2000) {
    $response['message'] = 'Message must be between 10 and 2000 characters.';
    echo json_encode($response);
    exit;
}

// Sanitize inputs for email
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

// Email configuration
$to = 'suchi.sudda@email.com'; // Replace with your actual email
$emailSubject = 'Portfolio Contact: ' . $subject;
$emailBody = "Name: $name\n";
$emailBody .= "Email: $email\n";
$emailBody .= "Subject: $subject\n";
$emailBody .= "Message:\n$message\n";
$emailBody .= "\n---\nSent from: " . $_SERVER['HTTP_HOST'];

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email (uncomment in production)
// $mailSent = mail($to, $emailSubject, $emailBody, $headers);

// For demo purposes, simulate success
$mailSent = true;

if ($mailSent) {
    $response['success'] = true;
    $response['message'] = 'Thank you! Your message has been sent successfully. I will get back to you soon.';
} else {
    $response['message'] = 'Sorry, there was an error sending your message. Please try again later.';
}

echo json_encode($response);
exit;
?>
