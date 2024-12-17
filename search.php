<?php
// -------------------------------
// DATABASE CONNECTION SECTION
// -------------------------------

// Database connection details
$host = "localhost";        // The database server hostname (localhost for local development)
$user = "root";             // Database username
$pass = "";                 // Database password (empty for local development)
$dbname = "lensandlightdb"; // The name of the database to connect to

// Create a new MySQLi connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection failed
if ($conn->connect_error) {
    // Stop execution and display an error message if the connection fails
    die("Connection failed: " . $conn->connect_error);
}

// -------------------------------
// FORM DATA PROCESSING SECTION
// -------------------------------

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data from the POST request
    $name = $_POST['name'];           // Customer name input from form
    $email = $_POST['email'];         // Email input from form
    $service = $_POST['service'];     // Service input from form
    $date = $_POST['date'];           // Preferred date input from form
    $location = $_POST['location'];   // Location input from form

    // Prepare the SQL statement using placeholders to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO bookings (Customer_name, Email, Service, Preferred_date, Location) VALUES (?, ?, ?, ?, ?)");

    // Bind the parameters to the SQL statement
    // "sssss" indicates 5 string parameters (s = string)
    $stmt->bind_param("sssss", $name, $email, $service, $date, $location);

    // Execute the prepared statement and check if it was successful
    if ($stmt->execute()) {
        // If the data is successfully inserted, redirect the user to update_booking.php
        header("Location: update_booking.php");
        exit(); // Ensure the script stops executing after redirection
    } else {
        // Display an error message if the statement execution fails
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// -------------------------------
// CLOSE DATABASE CONNECTION
// -------------------------------

// Close the database connection to release resources
$conn->close();
?>
