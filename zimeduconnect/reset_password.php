<?php
// Connection details (replace with your actual credentials)
$host = "localhost";
$username = "root";
$password = ""; // If a password is set
$dbname = "zimeduconnect";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve token from URL
$token = $_GET['token'];

// Check if token is valid (expiry check can be added here)
$stmt = $conn->prepare("SELECT email FROM signup_deatils WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Invalid token
    echo "Invalid password reset token.";
    die();
}

$user = $result->fetch_assoc(); // Get user ID if token is valid

// Form to enter new password (optional)
if (isset($_POST['password'])) { // Check if form is submitted
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        echo "Passwords do not match. Please try again.";
        die();
    }

    // Hash the new password
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I, ['cost' => 12]);

    // Update user with new password and remove reset token
    $stmt = $conn->prepare("UPDATE signup_deatils SET password = ?, reset_token = NULL WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $user['email']);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        echo "Password reset successful! You can now log in with your new password.";
        // Optional: Redirect to login form
    } else {
        echo "Error updating password. Please try again.";
    }
} else {
    // Display form to enter new password
?>
    <form action="" method="post">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="confirmPassword">Confirm New Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <br>
        <button type="submit">Reset Password</button>
    </form>
<?php
}

$stmt->close();
$conn->close();
?>
