<?php
// Database connection details
$servername = "localhost";  // The hostname for the database server (localhost for local development)
$username = "root";         // The database username
$password = "";             // The password for the database user (empty for local development)
$dbname = "lensandlightdb"; // The name of the database to connect to

// Establish a connection to the MySQL database using the mysqli object
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed
if ($conn->connect_error) {
    // Display an error message and stop execution if the connection fails
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data from the POST request
    $customer_name = $_POST['Customer_name'];   // Customer name input
    $email = $_POST['Email'];                   // Email input
    $service = $_POST['Service'];               // Service input
    $preferred_date = $_POST['Preferred_date']; // Preferred date input
    $location = $_POST['Location'];             // Location input

    // SQL query to insert the form data into the 'bookings' table
    $sql_insert = "INSERT INTO bookings (Customer_name, Email, Service, Preferred_date, Location)
                   VALUES ('$customer_name', '$email', '$service', '$preferred_date', '$location')";

    // Execute the query and check if it was successful
    if ($conn->query($sql_insert) === TRUE) {
        // If the insertion was successful, redirect the user to the viewBookings.php page
        header('Location: viewBookings.php'); 
        exit(); // Stop further execution
    } else {
        // Display an error message if the query fails
        echo "<p>Error: " . $sql_insert . "<br>" . $conn->error . "</p>";
    }
}

// Close the database connection after execution
$conn->close();
?>
