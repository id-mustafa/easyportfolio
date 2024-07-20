<?php
require __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Debugging: Echo environment variables (remove this in production)
echo "Env via getenv: " . getenv('GMAIL_PASSWORD') . "\n";
echo "Env via \$_ENV: " . $_ENV['GMAIL_PASSWORD'] . "\n";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(strip_tags(trim($_POST["name"])));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags(trim($_POST["message"])));

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
        echo "Please complete the form and try again.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'idmustafase@gmail.com';
        $mail->Password = "fili onih gvug telg"; // Use an environment variable for security
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('idmustafase@gmail.com', 'Mustafa Aljumayli'); // Use a valid email address
        $mail->addAddress('idmustafase@gmail.com', 'Mustafa Aljumayli'); // You can send to yourself or any other recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New contact from ' . $name;
        $mail->Body    = 'This is the HTML message body with details: <b>Name:</b> ' . $name . '<br><b>Email:</b> ' . $email . '<br><b>Message:</b> ' . $message;
        $mail->AltBody = 'Name: ' . $name . '\nEmail: ' . $email . '\nMessage: ' . $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        echo getenv('GMAIL_PASSWORD');  // Remove this line after debugging
    }

} else {
    echo "There was a problem with your submission, please try again.";
}
?>
