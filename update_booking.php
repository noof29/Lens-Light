<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "lensandlightdb";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!<br>";
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM bookings WHERE Booking_ID = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br>";
        header("Location: update_booking.php"); // Refresh page after deletion
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

// Handle search functionality
$search_query = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $search_query = "WHERE Customer_name LIKE '%$search%' OR Email LIKE '%$search%' OR Service LIKE '%$search%'";
}

// Fetch bookings
$sql = "SELECT * FROM bookings $search_query";
echo "Query: $sql<br>"; // Debugging query output
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        button, input[type="submit"] { margin: 5px; padding: 5px 10px; cursor: pointer; }
        form { display: inline-block; margin: 0; }
    </style>
</head>
<body>
    <h2>Manage Bookings</h2>

    <!-- Search Form -->
    <form method="POST" action="update_booking.php">
        <input type="text" name="search" placeholder="Search by name, email, or service" required>
        <input type="submit" value="Search">
    </form>

    <!-- Bookings Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Service</th>
            <th>Preferred Date</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['Booking_ID']; ?></td>
                    <td><?php echo $row['Customer_name']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['Service']; ?></td>
                    <td><?php echo $row['Preferred_date']; ?></td>
                    <td><?php echo $row['Location']; ?></td>
                    <td>
                        <!-- Delete Button -->
                        <a href="update_booking.php?delete=<?php echo $row['Booking_ID']; ?>">
                            <button style="background-color: red; color: white;">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No records found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
