<?php
// Database connection details (replace with your actual credentials)
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if class name is provided
  if (isset($_POST["className"]) && !empty($_POST["className"])) {
    $className = mysqli_real_escape_string($conn, $_POST["className"]); // Sanitize input

    // Insert class name into database
    $sql = "INSERT INTO classes (name) VALUES ('$className')";

    if (mysqli_query($conn, $sql)) {
      // Class saved successfully, display the class page
      echo "<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Class: $className</title>
  <style> body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url(4.png);
    background-size: cover;
    background-position: center;
}
body{
    
  font:white;
font-family: 'Sofia';font-size: 24px;
font-size: 24px; /* Increase title size */
          font-weight: bold; /* Make title bolder */
         
          color: white;
}
</style>
</head>
<body>
  <h1>Class: $className</h1>
  <h2>Assignments</h2>
  <p>No assignments posted yet.</p>
  <h2>Tests</h2>
  <p>No tests posted yet.</p>
  <h2>Answers</h2>
  <p>No answers posted yet.</p>
  <h2>Announcements</h2>
  <p>No announcements posted yet.</p>
  <h2>Post</h2>
  <form action='$_SERVER[PHP_SELF]' method='post'>
    <input type='hidden' name='className' value='$className'>
    <label for='postType'>Type:</label>
    <select name='postType' id='postType'>
      <option value='assignment'>Assignment</option>
      <option value='test'>Test</option>
      <option value='answer'>Answer</option>
      <option value='announcement'>Announcement</option>
    </select><br>
    <label for='postContent'>Content:</label><br>
    <textarea id='postContent' name='postContent' rows='4' cols='50'></textarea><br>
    <button type='submit'>Post</button>
  </form>
</body>
</html>";
      exit;
    } else {
      echo "Error: Could not save class name."; // Handle insertion error
    }
  } else {
    // If class name is not provided, show an error message
    echo "Error: Class name is required.";
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  // Check if class name is provided in the URL
  if (isset($_GET["name"]) && !empty($_GET["name"])) {
    $className = mysqli_real_escape_string($conn, $_GET["name"]); // Sanitize input

    // Retrieve class information from database (optional)
    $sql = "SELECT * FROM classes WHERE name = '$className'";
    $result = mysqli_query($conn, $sql);

    // Check if class exists (optional, for displaying existing class details)
    if (mysqli_num_rows($result) > 0) {
      // Class found, display details (implementation needed here)
      // You can use the retrieved data from $result to display class information
    } else {
      // Class not found, potentially redirect to create class page
      header("Location: create_class.php"); // Replace with your create class page
      exit;
    }

    // Display the class page (modify based on retrieved information)
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Class: $className</title>
  <style> body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url(4.png);
    background-size: cover;
    background-position: center;
}
body{
    
    font:white;
  font-family: 'Sofia';font-size: 24px;
  font-size: 24px; /* Increase title size */
            font-weight: bold; /* Make title bolder */
           
            color: white;
}
</style>
</head>
<body>
  <h1>Class: $className</h1>
  <h2>Assignments</h2>
  <p>No assignments posted yet.</p>
  <h2>Tests</h2>
  <p>No tests posted yet.</p>
  <h2>Answers</h2>
  <p>No answers posted yet.</p>
  <h2>Announcements</h2>
  <p>No announcements posted yet.</p>
  <h2>Post</h2>
    <form action='$_SERVER[PHP_SELF]' method='post'>
        <input type='hidden' name='className' value='$className'>
        <label for='postType'>Type:</label>
        <select name='postType' id='postType'>
            <option value='assignment'>Assignment</option>
            <option value='test'>Test</option>
            <option value='answer'>Answer</option>
            <option value='announcement'>Announcement</option>
        </select><br>
        <label for='postContent'>Content:</label><br>
        <textarea id='postContent' name='postContent' rows='4' cols='50'></textarea><br>
        <button type='submit'>Post</button>
    </form>
</body>
</html>";

        // Exit after displaying class page
        exit;
    } else {
        // If class name is not provided in the URL, redirect to the index page
        header("Location: teacherportal.html");
        exit;
    }
}

// If the script reaches here, it means it's not a POST or GET request, so redirect to the index page
header("Location: teacherportal.html");
exit;
?>