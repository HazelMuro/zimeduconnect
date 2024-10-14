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

// Prepare SQL statement to retrieve user (using prepared statements to prevent SQL injection)
$stmt = $conn->prepare("SELECT email, password FROM signup_deatils WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute query and handle errors
if ($stmt->execute()) {
  $result = $stmt->get_result();
  
  // Check if a user with the email is found
  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    
    // Compare passwords directly
    if ($_POST['password'] === $row['password']) {
        // Login successful
        session_start();
        $_SESSION['firstname'] = $row['firstname'];
        echo "Login successful! Welcome back.";
        header("Location: dashboard.html");
        exit;
      } else {
        print "Incorrect password. Please try again.";
      }
  } else {
    echo "No account found with the provided email address.";
  }
} else {
  echo "An error occurred during login: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>