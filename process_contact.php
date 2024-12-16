<?php
// Database connection parameters
$host = 'localhost'; // The host for the database (localhost means the database is on the same server)
$dbname = 'lensandlight'; // The name of the database
$user = 'root'; // The database username (root is a common default username for MySQL)
$password = ''; // The database password (empty by default for local MySQL installations)

// Connect to the database using MySQLi (improved MySQL functions for better security)
$conn = new mysqli($host, $user, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // If the connection failed, display an error message and stop the script
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted via the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data submitted by the user
    $name = $_POST['name']; // User's name
    $email = $_POST['email']; // User's email
    $inquiry = $_POST['inquiry']; // User's inquiry message

    // Prepare the SQL query to insert the form data into the 'contacts' table
    $sql = "INSERT INTO contacts (name, email, inquiry) VALUES (?, ?, ?)";

    // Prepare the SQL statement for execution
    $stmt = $conn->prepare($sql);

    // Bind the form data to the SQL query. 'sss' means all three parameters are strings
    $stmt->bind_param("sss", $name, $email, $inquiry);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // If the statement is executed successfully, show a success message
        echo "Your inquiry has been submitted successfully!<br><br>";
    } else {
        // If there's an error in execution, show an error message
        echo "Error: " . $stmt->error . "<br><br>";
    }

    // Close the prepared statement to free up resources
    $stmt->close();
}

// Retrieve all submitted inquiries from the 'contacts' table
$sql = "SELECT name, email, inquiry, submission_date FROM contacts";

// Execute the SQL query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Lens and Light</title>
    <style>
        /* Basic CSS styles for page layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Table styles for displaying inquiries */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Form container styles */
        .form-container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Styles for input fields */
        .form-container input, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Styles for submit button */
        .form-container button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<!-- Section to display inquiries that were submitted -->
<h2 style="text-align:center;">Submitted Inquiries</h2>

<?php
// Check if there are any inquiries in the database
if ($result->num_rows > 0) {
    // Start a table to display the inquiries
    echo "<table>";
    // Define table headers
    echo "<tr><th>Name</th><th>Email</th><th>Inquiry</th><th>Submitted On</th></tr>";

    // Loop through all the inquiries and display them in the table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>"; // Display the inquiry name
        echo "<td>" . htmlspecialchars($row['email']) . "</td>"; // Display the inquiry email
        echo "<td>" . htmlspecialchars($row['inquiry']) . "</td>"; // Display the inquiry text
        echo "<td>" . htmlspecialchars($row['submission_date']) . "</td>"; // Display the submission date
        echo "</tr>";
    }

    // End the table after all rows are displayed
    echo "</table>";
} else {
    // If no inquiries are found, display a message
    echo "<p>No inquiries have been submitted yet.</p>";
}

?>

</body>
</html>

<?php
// Close the database connection to free up resources
$conn->close();
?>
