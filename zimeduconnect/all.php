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

// Function to sanitize user input
function sanitizeInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// User Signup
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["signup"])) {
    // Retrieve and sanitize user input
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match. Please try again.";
        die();
    }

    // Hash password for security (using PASSWORD_ARGON2I for better security)
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I, ['cost' => 12]); // Adjust cost as needed

    // Prepare SQL statement (using prepared statements to prevent SQL injection)
    $stmt = $conn->prepare("INSERT INTO signup_deatils (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    // Execute query and handle errors
    if ($stmt->execute()) {
        echo "Signup successful! Proceed to registration.";
        // Redirect to registration page (optional)
        header("Location: registration.html");
        exit;
    } else {
        echo "Error: " . $stmt->error . "<br>";
        // Check for duplicate email (optional)
        if (strpos($stmt->error, "Duplicate entry") !== false) {
            echo "Email address already exists. Please choose a different email.";
        }
    }

    // Close statement
    $stmt->close();
}

// User Registration
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registration"])) {
    // Retrieve and sanitize user input
    $fullname = sanitizeInput($_POST['fullname']);
    $username = $_POST['username'];

    // Prepare SQL statement (using prepared statements to prevent SQL injection)
    $stmt = $conn->prepare("INSERT INTO registration (fullname, username) VALUES (?, ?)");
    $stmt->bind_param("ss", $fullname, $username);

    // Execute query and handle errors
    if ($stmt->execute()) {
        echo "Registration successful! Proceed to login.";
        // Redirect to login page (optional)
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// User Login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    // Retrieve and sanitize user input
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT password FROM login_details WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        if (password_verify($password, $hashedPassword)) {
            echo "Login successful";
        } else {
            echo "Login failed. Incorrect email or password.";
        }
    } else {
        echo "Login failed. Incorrect email or password.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>