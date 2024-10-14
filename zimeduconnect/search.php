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

// Get search keywords from the form
$keywords = mysqli_real_escape_string($conn, $_POST['keywords']);

// Search for PDF files based on keywords
$sql = "SELECT * FROM textbooks WHERE title LIKE '%$keywords%' OR description LIKE '%$keywords%'";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Error in SQL query: " . mysqli_error($conn));
}

$searchResults = []; // Ensure $searchResults is always initialized as an array

if (mysqli_num_rows($result) > 0) {
  // Add search results to an array
  while ($row = mysqli_fetch_assoc($result)) {
    $searchResults[] = [
      'file' => $row["file"],
      'title' => $row["title"],
      'description' => $row["description"]
    ];
  }
} else {
  $searchResults[] = ['message' => 'No results found for your search criteria.']; // Initialize $searchResults with a message
}

// Display search results
foreach ($searchResults as $result) {
  if (isset($result['message'])) {
    echo "<p>{$result['message']}</p>"; // Display the message if no results found
  } else {
    echo "<h3>{$result['title']}</h3>";
    //echo "<p>{$result['description']}</p>";
    echo "<a href='{$result['file']}'>Download PDF</a><br><br>";
  }
}

// Close database connection
mysqli_close($conn);
?>