<?php

session_start();  // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.html");  // Redirect if not logged in
    exit;
}

$email = $_SESSION['email'];  // Get email from session

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "zimeduconnect";

// Create connection
$conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
} else {
    // Prepare the SQL query to fetch user details
    $SELECT_USER = "SELECT * FROM registration WHERE email=?";
    $stmt = $conn->prepare($SELECT_USER);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userData = json_encode($row); // Encode user data as JSON
        echo $userData;
    } else {
        echo "Error fetching account details.";
    }

    $stmt->close();
}

$conn->close();

?>