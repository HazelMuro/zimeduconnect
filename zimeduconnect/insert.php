<?php

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$idnumber = $_POST['idnumber'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$highschoolname = $_POST['highschoolname'];
$permanentaddress = $_POST['permanentaddress'];
$usertype = $_POST['usertype']; // New user type field

/* All fields are required check */
if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($idnumber) && !empty($dob) && !empty($phone) && !empty($highschoolname) && !empty($permanentaddress) && !empty($usertype)) {
  $host = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbName = "zimeduconnect";

  // Create connection
  $conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
  } else {
    // Check for existing email or ID number (optional, can be done)
    // ... existing email/ID number checks (same logic as before)
    // Check for existing email first
    $SELECT_EMAIL = "SELECT email FROM registration WHERE email=? LIMIT 1";
    $stmt_email = $conn->prepare($SELECT_EMAIL);
    $stmt_email->bind_param("s", $email);
    $stmt_email->execute();
    $stmt_email->store_result();
    $rnum_email = $stmt_email->num_rows;

    // Check for existing ID number
    $SELECT_ID = "SELECT idnumber FROM registration WHERE idnumber=? LIMIT 1";
    $stmt_id = $conn->prepare($SELECT_ID);
    $stmt_id->bind_param("s", $idnumber);
    $stmt_id->execute();
    $stmt_id->store_result();
    $rnum_id = $stmt_id->num_rows;

    // Display error message based on check results
    if ($rnum_email > 0) {
      echo "Email already registered. Please try a different email address.";
    } elseif ($rnum_id > 0) {
      echo "ID number already in use. Please contact administration if this is a mistake.";
    } else {
      // No existing email or ID number, proceed with registration

      $INSERT = "";
      $stmt = null;

      if ($usertype == "student") {
        $INSERT = "INSERT INTO student_details (firstname, lastname, email, idnumber, dob, phone, highschoolname, permanentaddress, usertype) VALUES (?,?,?,?,?,?,?,?,?)";
        $redirect_page = "login.html"; // Redirect to login page for students
      } else if ($usertype == "teacher") {
        $INSERT = "INSERT INTO teachers_details (firstname, lastname, email, idnumber, dob, phone, highschoolname, permanentaddress, usertype) VALUES (?,?,?,?,?,?,?,?,?)";
        $redirect_page = "login1.html"; // Redirect to login1 page for teachers
      } else {
        echo "Invalid user type";
        die();
      }

      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssssiisss", $firstname, $lastname, $email, $idnumber, $dob, $phone, $highschoolname, $permanentaddress, $usertype);

      if (!empty($INSERT)) {
        $stmt->execute();
        session_start();

        $_SESSION['username'] = $firstname; // Assuming `$firstname` contains the user's first name
        header("Location: $redirect_page");
        exit;
      } else {
        echo "Registration failed.";
      }
      $stmt->close(); // Close the prepared statement after use
    }

    $stmt_email->close(); // Close the prepared statements for email and ID checks
    $stmt_id->close();
  }
  $conn->close();
} else {
  echo "All fields are required";
  die();
}
?>
