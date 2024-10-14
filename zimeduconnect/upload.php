<?php

// Connect to the database
$host = "localhost";
$username = "root";
$password = ""; // If a password is set (replace with your actual password)
$dbname = "zimeduconnect";

$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$title = mysqli_real_escape_string($conn, $_POST['title']);
$author = mysqli_real_escape_string($conn, $_POST['author']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

// File upload handling
$target_dir = "uploads/"; // Change this to your desired upload directory
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$message = "";

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
  $message = "A file with the same name already exists.";
}

// Check file size
if ($_FILES["file"]["size"] > 5000000) { // Adjust limit as needed (5MB in this case)
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
  $message = "The uploaded file exceeds the maximum size limit.";
}

// Allow certain file formats
$allowed_extensions = array("pdf", "docx", "epub");
$file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
if (!in_array($file_extension, $allowed_extensions)) {
  $message = "The uploaded file format is not supported. Please use PDF, DOCX, or EPUB.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  // Optionally display the specific error message: echo $message;
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "The file " . basename( $_FILES["file"]["name"]) . " has been uploaded.";

    // Prepare and execute SQL statement to insert data into database
    $sql = "INSERT INTO textbooks (title, author, description, file) VALUES ('$title', '$author', '$description', '$target_file')";

    if (mysqli_query($conn, $sql)) {
      $message = "Textbook uploaded successfully!";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      $message = "There was an error saving the textbook information to the database.";
    }
  } else {
    echo "Sorry, there was an error uploading your file.";
    $message = "An error occurred while uploading the file.";
  }
}

// Close database connection
mysqli_close($conn);

// Display a message to the user
echo "<script>alert('$message'); window.location.href='txt.html';</script>"; // Redirect back to form after processing
