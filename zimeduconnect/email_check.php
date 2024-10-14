<?php
// Connection details (replace with your actual credentials)
$host = "localhost";
$username = "root";
$password = ""; // If a password is set (replace with your actual password)
$dbname = "zimeduconnect";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve user input (sanitized for security)
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Prepare SQL statement (using prepared statements to prevent SQL injection)
$stmt = $conn->prepare("SELECT email FROM signup_deatils WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute query and handle errors
$stmt->execute();
$stmt->store_result();
$count = $stmt->num_rows;

if ($count > 0) {
  // Email address already exists in the database
  $response = array(
    'status' => 'error',
    'message' => 'The email address you entered is already registered. Please try a different email.'
  );
} else {
  // Email address is available
  $response = array(
    'status' => 'success',
    'message' => ''
  );
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close statement and connection
$stmt->close();
$conn->close();
?>