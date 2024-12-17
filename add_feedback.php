<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "lensandlightdb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = '';
$errorMessage = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $experience = $conn->real_escape_string($_POST['experience']);
    $services = $conn->real_escape_string($_POST['services']);
    $comments = $conn->real_escape_string($_POST['comments']);

    if ($name && $email && $experience) {
        $sql = "INSERT INTO feedback (name, email, experience, services, comments) 
                VALUES ('$name', '$email', '$experience', '$services', '$comments')";
        
        if ($conn->query($sql) === TRUE) {
            $successMessage = "Feedback added successfully!";
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    } else {
        $errorMessage = "Please fill in all required fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add New Feedback</h2>

    <!-- Success or Error Messages -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php elseif ($errorMessage): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- Feedback Form -->
    <form method="POST" action="add_feedback.php">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="experience" class="form-label">Experience</label>
            <input type="text" class="form-control" name="experience" id="experience" placeholder="Enter your experience" required>
        </div>
        <div class="mb-3">
            <label for="services" class="form-label">Services</label>
            <input type="text" class="form-control" name="services" id="services" placeholder="Which service did you use?">
        </div>
        <div class="mb-3">
            <label for="comments" class="form-label">Comments</label>
            <textarea class="form-control" name="comments" id="comments" rows="3" placeholder="Additional comments..."></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg">Submit</button>
            <a href="search_feedback.php" class="btn btn-secondary btn-lg">Back to Search</a>
        </div>
    </form>
</div>
</body>
</html>
<?php
$conn->close();
?>
