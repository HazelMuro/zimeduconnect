<?php
// Connection details
$host = "localhost";
$username = "root";
$password = ""; // If a password is set
$dbname = "zimeduconnect";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve email
$email = $_POST['email'];

// Check if email exists
$stmt = $conn->prepare("SELECT email FROM signup_deatils WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Email not found
    echo "Email address not found.";
    die();
}

$user = $result->fetch_assoc(); // Get user ID if email exists

// Generate random reset token
$token = bin2hex(random_bytes(16));

// Update user with reset token (store expiry time if needed)
$stmt = $conn->prepare("UPDATE signup_deatils SET reset_token = ? WHERE email = ?");
$stmt->bind_param("ss", $token, $user['email']);
$stmt->execute();

// Create password reset email content
$to = $email;
$subject = "ZimEduConnect Password Reset";
$message = "Hi there,\n\nYou recently requested a password reset for your ZimEduConnect account.\n\nClick the link below to set a new password:\n\n[link to reset_password.php?token=$token]\n\nIf you did not request a password reset, you can safely ignore this email.\n\nThanks,\nThe ZimEduConnect Team";
$headers = "From: noreply@zimeduconnect.com";

// Send email using your preferred method (e.g., mail(), PHPMailer library)
if (mail($to, $subject, $message, $headers)) {
    echo "Password reset link sent to your email address.";
} else {
    echo "Error sending email. Please try again later.";
}

$stmt->close();
$conn->close();
?>
