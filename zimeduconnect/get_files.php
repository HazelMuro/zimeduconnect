<?php

// Path to the uploads folder (replace with your actual path)
$uploads_dir = "uploads/";

// Get the exam board from the query parameter (if any)
$exam_board = isset($_GET["exam_board"]) ? $_GET["exam_board"] : null;

// Open the uploads directory
if ($dir = opendir($uploads_dir)) {
  echo "<h2>Exam Papers</h2>";
  echo "<ul>";

  // Loop through files in the directory
  while (false !== ($file = readdir($dir))) {
    if ($file != "." && $file != "..") {
      // Check if filename matches exam board
      if (is_null($exam_board) || $exam_board === "ZIMSEC" && strpos($file, "ZIMSEC") !== false) {
        // Display ZIMSEC files only
        echo "<li><a href='" . $uploads_dir . $file . "'>" . $file . "</a></li>";
      } else if (is_null($exam_board) || $exam_board === "CAMBRIDGE" && strpos($file, "CAMBRIDGE") !== false) {
        // Display Cambridge files only
        echo "<li><a href='" . $uploads_dir . $file . "'>" . $file . "</a></li>";
      }
    }
  }

  echo "</ul>";

  closedir($dir);
} else {
  echo "Failed to open uploads directory.";
}

?>
