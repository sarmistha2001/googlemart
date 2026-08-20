<?php
/**
 * Contact form handler (SMTP version via PHPMailer)
 * Sends message to satrusallyasarmistha@gmail.com
 *
 * SETUP REQUIRED:
 * 1. This file expects PHPMailer at: PHPMailer/src/PHPMailer.php, SMTP.php, Exception.php
 *    (upload the PHPMailer folder into your site root, next to this file)
 * 2. Fill in SMTP_USER and SMTP_PASS below (see instructions sent alongside this file).
 */

header('Content-Type: application/json');

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}
foreach ([$name, $email, $phone, $subject] as $field) {
    if (preg_match('/[\r\n]/', $field)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input detected.']);
        exit;
    }
}

// ==================== SMTP SETTINGS — FILL THESE IN ====================
// Recommended: a Gmail account with a 16-char "App Password" (needs 2FA enabled).
// Create one at: https://myaccount.google.com/apppasswords
const SMTP_HOST = 'smtp.gmail.com';
const SMTP_PORT = 587;
const SMTP_USER = 'your-sending-account@gmail.com'; // <-- the Gmail account that will SEND the email
const SMTP_PASS = 'xxxx xxxx xxxx xxxx';             // <-- 16-character App Password (not your normal Gmail password)
const SMTP_FROM_NAME = 'Google Mart Website';
// =========================================================================

$to = 'satrusallyasarmistha@gmail.com';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;

    $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);
    $mail->addAddress($to);
    $mail->addReplyTo($email, $name);

    $mail->isHTML(false);
    $mail->Subject = $subject !== '' ? ('Contact Form: ' . $subject) : 'New Contact Form Message - Google Mart';
    $mail->Body    = "You have received a new message from the website contact form:\n\n"
                    . "Name: $name\n"
                    . "Email: $email\n"
                    . "Phone: " . ($phone !== '' ? $phone : '-') . "\n"
                    . "Subject: " . ($subject !== '' ? $subject : '-') . "\n\n"
                    . "Message:\n$message\n";

    $mail->send();

    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been sent. We will get back to you shortly.'
    ]);
} catch (Exception $e) {
    // Log the real reason for debugging (check your PHP error log)
    error_log('Contact form mail error: ' . $mail->ErrorInfo);
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, something went wrong while sending your message. Please try again or WhatsApp us.'
    ]);
}