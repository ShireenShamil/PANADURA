<?php
// Start output buffering and session
ob_start();
session_start();

// Database connection settings
$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'puadb'; 

// Create a connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO contact_requests (name, email, message) VALUES (?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $name, $email, $message);

// Sanitize and set parameters
$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$message = htmlspecialchars(trim($_POST['message']));

if ($stmt->execute()) {
    // Set success message in session
    $_SESSION['success_message'] = "Message sent successfully!";
} else {
    // Set error message in session
    $_SESSION['error_message'] = "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();

// Redirect to the home page
header("Location: index.html");
exit();
?>
