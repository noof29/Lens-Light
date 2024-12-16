<?php
// Database connection parameters
$host = 'localhost';  // Hostname of the MySQL server, usually 'localhost' for local development
$dbname = 'lensandlight';  // The name of the database you are connecting to
$user = 'root';  // Database username, 'root' is commonly used for local development
$password = '';  // Database password, left empty for local development (default for XAMPP)

// Connect to the database using MySQLi
$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection to the database
if ($conn->connect_error) {  // If the connection fails, the script will terminate
    die("Connection failed: " . $conn->connect_error);  // Display the error message and stop the execution
}

// Check if the form is submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    // Retrieve the form data from the POST request
    $name = $_POST['name'];  // The name input field from the form
    $email = $_POST['email'];  // The email input field from the form
    $inquiry = $_POST['inquiry'];  // The inquiry/message input field from the form

    // SQL query to insert the data into the 'contacts' table in the database
    $sql = "INSERT INTO contacts (name, email, inquiry) VALUES (?, ?, ?)";

    // Prepare the SQL query statement to prevent SQL injection (using placeholders)
    $stmt = $conn->prepare($sql);
    
    // Bind the input parameters to the prepared statement
    // 'sss' indicates the data type of each parameter (all are strings in this case)
    $stmt->bind_param("sss", $name, $email, $inquiry);

    // Execute the prepared statement
    if ($stmt->execute()) {  // If the query is executed successfully
        echo "Your inquiry has been submitted successfully!<br><br>";  // Inform the user about the successful submission
    } else {  // If there was an error executing the query
        echo "Error: " . $stmt->error . "<br><br>";  // Display the error message
    }

    // Close the prepared statement to free up resources
    $stmt->close();
}

// Close the connection to the database to avoid leaving open connections
$conn->close();
?>
