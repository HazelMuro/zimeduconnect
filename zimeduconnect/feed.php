<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST["email"];
    $feedback = $_POST["feedback"];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format.";
        exit();
    }

    // Set recipient email address
    $to = "support@zimeduconnect.com";

    // Subject and message body
    $subject = "Feedback from ZimEduConnect";
    $message = "Email: $email\n\nFeedback:\n$feedback";

    // Headers
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Feedback sent successfully!";
    } else {
        http_response_code(500);
        echo "Failed to send feedback. Please try again later.";
    }
} else {
    // Not a POST request
    http_response_code(405);
    echo "Method Not Allowed";
}
?>