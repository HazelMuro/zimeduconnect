<?php
// Connection details (replace with your actual credentials)
$host = "localhost";
$username = "root";
$password = ""; // If a password is set (replace with your actual password)
$dbname = "zimeduconnect";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the class name is provided in the URL
if (isset($_GET["name"]) && !empty($_GET["name"])) {
    // Get the class name from the URL
    $className = $_GET["name"];

    // Query the database to check if the class exists
    $sql = "SELECT * FROM classes WHERE class_name = '$className'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // If the class exists, redirect to the class page
        header("Location: class_page.php?name=$className");
        exit;
    } else {
        // If the class doesn't exist, display an error message
        echo "Error: The class '$className' doesn't exist or is invalid.";
        exit;
    }
} else {
    // If class name is not provided in the URL, redirect to the join class page
    header("Location: join_class.html");
    exit;
}

// Close the database connection
$conn->close();
?>