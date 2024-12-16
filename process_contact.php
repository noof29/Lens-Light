<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'lensandlight';
$user = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password

// Connect to the database
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data and insert it into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $inquiry = $_POST['inquiry'];

    // SQL query to insert data
    $sql = "INSERT INTO contacts (name, email, inquiry) VALUES (?, ?, ?)";

    // Prepare and bind statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $inquiry);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Your inquiry has been submitted successfully!<br><br>";
    } else {
        echo "Error: " . $stmt->error . "<br><br>";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
