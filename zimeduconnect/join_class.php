<?php
// Check if the class name is provided in the URL
if (isset($_GET["name"]) && !empty($_GET["name"])) {
    // Get the class name from the URL
    $className = $_GET["name"];

    // Check if the class exists (you may need to implement this logic)
    $classExists = true; // Placeholder for checking if the class exists

    if ($classExists) {
        // Redirect to the class page with the provided class name
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
?>