<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lensandLightdb";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the booking ID is provided
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Delete the booking from the table
    $sql_delete = "DELETE FROM bookings WHERE Booking_ID = $booking_id";

    if ($conn->query($sql_delete) === TRUE) {
        header('Location: viewBookings.php');  // Redirect to the bookings page
        exit();
    } else {
        echo "<p>Error: " . $sql_delete . "<br>" . $conn->error . "</p>";
    }
}

// Close the database connection
$conn->close();
?>
