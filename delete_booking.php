<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lensandLightdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    $sql = "DELETE FROM Bookings WHERE Booking_ID = $booking_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Booking deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
header("Location: insertBooking.php"); // Redirect back to the booking page
?>
