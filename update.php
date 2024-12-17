<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lensandLightdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID is set in the URL (for editing feedback)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current record to update
    $sql = "SELECT * FROM feedback WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Feedback not found.</p>";
        exit;
    }

    // Update logic when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $experience = $_POST['experience'];
        $services = $_POST['services'];
        $comments = $_POST['comments'];

        $updateSql = "UPDATE feedback SET name = '$name', email = '$email', experience = '$experience', services = '$services', comments = '$comments' WHERE id = $id";

        if ($conn->query($updateSql) === TRUE) {
            echo "<p style='color: green;'>Feedback updated successfully.</p>";
            header("Location: manageFeedback.php"); // Redirect to the feedback management page after update
        } else {
            echo "<p style='color: red;'>Error updating feedback: " . $conn->error . "</p>";
        }
    }
} else {
    echo "<p>No ID specified.</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Update Feedback</h1>

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="<?= htmlspecialchars($row['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($row['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="experience" class="form-label">Experience</label>
            <input type="text" name="experience" class="form-control" id="experience" value="<?= htmlspecialchars($row['experience']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="services" class="form-label">Services</label>
            <input type="text" name="services" class="form-control" id="services" value="<?= htmlspecialchars($row['services']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="comments" class="form-label">Comments</label>
            <textarea name="comments" class="form-control" id="comments" required><?= htmlspecialchars($row['comments']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Feedback</button>
    </form>
</div>
</body>
</html>

<?php $conn->close(); ?>
