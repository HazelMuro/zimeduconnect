<?php
// Retrieve the message and username from the AJAX request
$message = $_POST['message'];
$username = getUsernameFromSession(); // Replace this function with your logic to retrieve the username associated with the email

// Broadcast the message to other users (you can customize this logic as per your requirements)
broadcastMessage($username, $message);

// Return a response (optional)
$response = ['status' => 'success'];
echo json_encode($response);

// Function to broadcast the message
function broadcastMessage($username, $message) {
  // Implement the logic to broadcast the message to other users (e.g., store it in a database, send it via WebSocket, etc.)
  // You can customize this function as per your requirements
}

// Function to retrieve the username associated with the email
// Function to retrieve the username from the session variable
function getUsernameFromSession() {
  // Implement the logic to retrieve the username from the session variable
  // You can customize this function as per your requirements
  // Here's an example assuming the session variable is named `username`
  return isset($_SESSION['username']) ? $_SESSION['username'] : '';
}

// Retrieve the message and username from the AJAX request
$message = $_POST['message'];
$username = getUsernameFromSession();

// Broadcast the message to other users (you can customize this logic as per your requirements)
broadcastMessage($username, $message);

// Return a response (optional)
$response = ['status' => 'success'];
echo json_encode($response);
?>