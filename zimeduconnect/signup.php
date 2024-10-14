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
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Check if passwords match
if ($password !== $confirmPassword) {
  echo "Passwords do not match. Please try again.";
  die();
}

// Prepare SQL statement to check if email exists
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM signup_deatils WHERE email = ?");
$checkStmt->bind_param("s", $email);

// Execute the query
$checkStmt->execute();

// Fetch the result
$checkStmt->bind_result($count);
$checkStmt->fetch();

// Check if the email already exists
if ($count > 0) {
  echo "The email address you entered is already registered. Please try a different email.";
  die();
}

// Close the statement
$checkStmt->close();

// Prepare SQL statement to insert the new record
$stmt = $conn->prepare("INSERT INTO signup_deatils (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $password);

// Execute the INSERT query
try {
  if ($stmt->execute()) {
    echo "Signup successful! You can now register.";
    header("Location: registration.html"); // Optional redirect
    exit;
  } else {
    throw new Exception($stmt->error);
  }
} catch (Exception $e) {
  echo "An error occurred during registration: " . $e->getMessage();
}

// Close the statement
$stmt->close();