<?php
// -------------------------------
// DATABASE CONNECTION SECTION
// -------------------------------

// Database connection details
$servername = "localhost";       // Hostname for the database server
$username = "root";              // Username for database access
$password = "";                  // Password for database access (empty for local setup)
$dbname = "lensandLightdb";      // The name of the database

// Create a new database connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed
if ($conn->connect_error) {
    // Stop script execution and display an error message
    die("Connection failed: " . $conn->connect_error);
}

// -------------------------------
// RETRIEVE EXISTING DATA SECTION
// -------------------------------

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $booking_id = $_GET['id']; // Retrieve the booking ID from the URL parameter

    // SQL query to retrieve the booking record based on Booking_ID
    $sql = "SELECT * FROM bookings WHERE Booking_ID = $booking_id";

    // Execute the query and fetch the result
    $result = $conn->query($sql);

    // Fetch the current booking details as an associative array
    $booking = $result->fetch_assoc();
}

// -------------------------------
// PROCESS FORM SUBMISSION
// -------------------------------

// Check if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve updated form values from the POST request
    $customer_name = $_POST['Customer_name'];      // Customer Name input
    $email = $_POST['Email'];                      // Email input
    $service = $_POST['Service'];                  // Service selection input
    $preferred_date = $_POST['Preferred_date'];    // Preferred date input
    $location = $_POST['Location'];                // Preferred location input

    // SQL query to update the booking record with new values
    $sql_update = "UPDATE bookings 
                   SET Customer_name='$customer_name', 
                       Email='$email', 
                       Service='$service', 
                       Preferred_date='$preferred_date', 
                       Location='$location' 
                   WHERE Booking_ID = $booking_id";

    // Execute the update query and check if successful
    if ($conn->query($sql_update) === TRUE) {
        // Redirect the user back to the bookings page if update is successful
        header('Location: viewBookings.php');
        exit(); // Stop script execution after redirection
    } else {
        // Display an error message if the query fails
        echo "<p>Error: " . $sql_update . "<br>" . $conn->error . "</p>";
    }
}

// -------------------------------
// CLOSE DATABASE CONNECTION
// -------------------------------

// Close the database connection
$conn->close();
?>

<!-- ----------------------------- -->
<!-- HTML FORM SECTION -->
<!-- ----------------------------- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Booking</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Page Title -->
        <h2>Update Booking</h2>

        <!-- Update Booking Form -->
        <form action="updateBooking.php?id=<?php echo $booking_id; ?>" method="POST">
            <!-- Service Selection -->
            <div class="mb-3">
                <label for="service-session" class="form-label">Choose a Service</label>
                <select class="form-select" name="Service" required>
                    <!-- Dynamically mark an option as 'selected' if it matches the existing value -->
                    <option value="portrait" <?php echo ($booking['Service'] == 'portrait') ? 'selected' : ''; ?>>Portrait Photography</option>
                    <option value="event" <?php echo ($booking['Service'] == 'event') ? 'selected' : ''; ?>>Event Photography</option>
                    <option value="commercial" <?php echo ($booking['Service'] == 'commercial') ? 'selected' : ''; ?>>Commercial Photography</option>
                </select>
            </div>

            <!-- Customer Name Input -->
            <div class="mb-3">
                <label for="name-session" class="form-label">Name</label>
                <input type="text" class="form-control" name="Customer_name" value="<?php echo $booking['Customer_name']; ?>" required>
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email-session" class="form-label">Email</label>
                <input type="email" class="form-control" name="Email" value="<?php echo $booking['Email']; ?>" required>
            </div>

            <!-- Preferred Date Input -->
            <div class="mb-3">
                <label for="date-session" class="form-label">Preferred Date</label>
                <input type="date" class="form-control" name="Preferred_date" value="<?php echo $booking['Preferred_date']; ?>" required>
            </div>

            <!-- Preferred Location Input -->
            <div class="mb-3">
                <label for="location-session" class="form-label">Preferred Location</label>
                <input type="text" class="form-control" name="Location" value="<?php echo $booking['Location']; ?>" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
