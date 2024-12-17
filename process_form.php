<?php
// process_form.php

// Database credentials
$DB_HOST = 'localhost';
$DB_USER = 'root';  // Your DB username
$DB_PASS = '';      // Your DB password
$DB_NAME = 'lensandlightdb'; // Your database name

// Create connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $experience = $conn->real_escape_string($_POST['experience']);
    $services = isset($_POST['services']) ? implode(", ", $_POST['services']) : ''; // Combine services into a string
    $comments = $conn->real_escape_string($_POST['comments']);

    // Insert data into the database
    $sql = "INSERT INTO feedback (name, email, experience, services, comments) 
            VALUES ('$name', '$email', '$experience', '$services', '$comments')";

    if ($conn->query($sql) === TRUE) {
        header("Location: display_feedback.php"); // Redirect to display page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
