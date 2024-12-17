<?php
// Database connection
$host = 'localhost'; // Database host
$dbname = 'lensandlight'; // Database name
$username = ''; // Database username
$password = ''; // Database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form was submitted via POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate form data
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $experience = trim($_POST['experience']);
        $comments = trim($_POST['comments']);

        // Handle the services checkbox values
        $services = isset($_POST['services']) ? implode(", ", $_POST['services']) : null;

        // Prepare the SQL query to insert the data into the feedback table
        $sql = "INSERT INTO feedback (name, email, experience, services, comments) 
                VALUES (:name, :email, :experience, :services, :comments)";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':experience', $experience);
        $stmt->bindParam(':services', $services);
        $stmt->bindParam(':comments', $comments);

        // Execute the query
        $stmt->execute();

        // Redirect to a thank you page or display a success message
        echo "Thank you for your feedback!";
        exit();
    }
} catch (PDOException $e) {
    // Handle error
    echo "Error: " . $e->getMessage();
    exit();
}
?>
