<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "lensandlightdb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$searchQuery = '';
$results = [];

// Check if search form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $searchQuery = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';

    // Search query: match name, email, or experience
    $sql = "SELECT * FROM feedback 
            WHERE name LIKE '%$searchQuery%' 
               OR email LIKE '%$searchQuery%' 
               OR experience LIKE '%$searchQuery%'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $results = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error = "No results found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
        .btn-primary, .btn-success {
            width: 150px;
        }
        .alert {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Search Feedback</h2>

    <!-- Search Form -->
    <form method="POST" action="search_feedback.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control form-control-lg" placeholder="Search by name, email, or experience..." 
                   value="<?php echo htmlspecialchars($searchQuery); ?>" required>
            <button class="btn btn-primary btn-lg" type="submit">Search</button>
        </div>
    </form>

    <!-- Display Search Results -->
    <?php if (!empty($results)): ?>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Experience</th>
                    <th>Services</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['experience']); ?></td>
                        <td><?php echo htmlspecialchars($row['services']); ?></td>
                        <td><?php echo htmlspecialchars($row['comments']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-warning"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Button to Add New Feedback -->
    <div class="text-center mt-4">
    <a href="add_feedback.php" class="btn btn-success btn-lg">Add New Feedback</a>
    </div>
</div>
</body>
</html>
<?php
$conn->close();
?>
