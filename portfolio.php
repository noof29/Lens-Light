<?php
// Database Connection Setup
// The following variables store the credentials required to connect to the database
$host = 'localhost'; // Hostname of the database server
$db = 'portfolio_db'; // Name of the database
$user = 'root'; // Database username
$pass = ''; // Database password (leave blank for default setups)

// Data Source Name (DSN) is used to define the database type and its location
$dsn = "mysql:host=$host;dbname=$db";

try {
    // PDO instance creation with error mode set to exceptions for better error handling
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    // If connection fails, the script terminates, and the error message is displayed
    die("Connection failed: " . $e->getMessage());
}

// PHP Class to Manage Table Rows
// This class defines the structure of a photographer record and provides a method to render it as a table row
class Photographer {
    // Properties to store photographer details
    public $id;
    public $name;
    public $category;
    public $description;
    public $imgSrc;

    // Constructor to initialize the Photographer object with details
    public function __construct($id, $name, $category, $description, $imgSrc) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->description = $description;
        $this->imgSrc = $imgSrc;
    }

    // Method to render the photographer's details as a table row in HTML
    public function renderRow() {
        return "
        <tr>
            <td><img src='{$this->imgSrc}' alt='{$this->category}' class='table-img'></td>
            <td>{$this->category}</td>
            <td>{$this->name}</td>
            <td>{$this->description}</td>
            <td>
                <a href='?delete={$this->id}' class='btn btn-danger'>Delete</a>
                <a href='?edit={$this->id}' class='btn btn-warning'>Edit</a>
            </td>
        </tr>
        ";
    }
}

// Array to Store Table Rows
// The $photographers array will store Photographer objects to be displayed in the table
$photographers = [];

// Fetch Data from Database to Display in Table
// This query retrieves all records from the "portfolio" table
$stmt = $pdo->query("SELECT * FROM portfolio");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Each row is converted into a Photographer object and added to the $photographers array
    $photographers[] = new Photographer(
        $row['id'],
        $row['name'],
        $row['category'],
        $row['description'],
        $row['imgSrc']
    );
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Search
    if (isset($_POST['search'])) {
        $category = $_POST['category']; // Category selected in the search form
        if ($category) {
            // Prepare and execute a SQL query to search for photographers matching the selected category
            $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE category LIKE ?");
            $stmt->execute(['%' . $category . '%']);
            $photographers = []; // Clear the current array to store search results
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $photographers[] = new Photographer(
                    $row['id'],
                    $row['name'],
                    $row['category'],
                    $row['description'],
                    $row['imgSrc']
                );
            }
        }
    }

    // Handle Insert
    if (isset($_POST['insert'])) {
        // Collect form data for the new photographer
        $name = $_POST['name'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $imgSrc = $_POST['imgSrc'];

        // Insert the new photographer's details into the database
        $stmt = $pdo->prepare("INSERT INTO portfolio (name, category, description, imgSrc) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $category, $description, $imgSrc]);
        header("Location: portfolio.php"); // Redirect to refresh the page
        exit; // Stop script execution after redirection
    }

    // Handle Update
    if (isset($_POST['update'])) {
        // Collect form data for the photographer to be updated
        $id = $_POST['id'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $imgSrc = $_POST['imgSrc'];

        // Update the photographer's details in the database
        $stmt = $pdo->prepare("UPDATE portfolio SET name = ?, category = ?, description = ?, imgSrc = ? WHERE id = ?");
        $stmt->execute([$name, $category, $description, $imgSrc, $id]);
        header("Location: portfolio.php"); // Redirect to refresh the page
        exit;
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; // ID of the photographer to be deleted
    // Delete the photographer's record from the database
    $stmt = $pdo->prepare("DELETE FROM portfolio WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: portfolio.php"); // Redirect to refresh the page
    exit;
}

// Handle Edit
$editingPhotographer = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit']; // ID of the photographer to be edited
    // Fetch the photographer's details from the database
    $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE id = ?");
    $stmt->execute([$id]);
    $editingPhotographer = $stmt->fetch(PDO::FETCH_ASSOC); // Store the data for pre-filling the form
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--External css-->
    <link href="styles.css" rel="stylesheet">
    <style>
         /* Styling for the introduction section */
         .intro-section {
            background-image: url(Sunset-header.jpg); 
            background-size: cover;
            background-position: center;
            color: rgb(11, 11, 11);
            padding: 100px 20px;
            text-align: center;
        }

        /* Styling for the photography category table */
        .category-table {
            margin-top: 50px;
            width: 100%;
            background-color: rgba(193, 135, 73, 0.753);
        }

        /* Styling for table cells */
        .category-table th, .category-table td {
            padding: 20px;
            vertical-align: top;
        }

        /* Styling for table images */
        .table-img {
            width: 300px;
            height: auto;
            border-radius: 8px;
        }

        /* Styling for category names */
        .category-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        /* Styling for photographer names */
        .photographer-name {
            font-size: 20px;
            color: #555;
            font-style: italic;
            margin-bottom: 10px;
        }

        /* Styling for the search form */
        .search-form {
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body style="background-color: #726e6e;">
    <!-- Header Section -->
    <header>
        <div class="container-fluid d-flex justify-content-between align-items-center p-3">
            <!-- Logo and title -->
            <div class="d-flex align-items-center">
                <img src="logo.png" alt="Logo" width="100" height="120" class="me-2">
                <h1>LENS AND LIGHT</h1>
            </div>
            <!-- Navigation bar -->
            <nav class="navbar navbar-expand-sm">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="portfolio.php">Portfolio</a></li>
                    <li class="nav-item"><a class="nav-link" href="booking.html">Booking</a></li>
                    <li class="nav-item"><a class="nav-link" href="store.html">Store</a></li>
                    <li class="nav-item"><a class="nav-link" href="calculation.html">Calculation</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact us.html">Contact us</a></li>
                    <li class="nav-item"><a class="nav-link" href="questionnaire.html">Questionnaire</a></li>
                    <li class="nav-item"><a class="nav-link" href="fun.html">Fun</a></li>
                    <li class="nav-item"><a class="nav-link" href="about us.html">About us</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- Introduction Section -->
    <div class="intro-section">
        <h1 class="intro-title">Welcome to Our Portfolio</h1>
        <p style="font-size: 18pt; background-color: rgba(114, 110, 110, 0.4);">
            Welcome to our portfolio, where our talented photographers' work brings the art of photography to life. 
            The best work from a variety of categories, such as commercial, events, landscape, and portrait photography, 
            is displayed here. Every picture conveys a distinct tale, demonstrating our commitment to preserving the 
            spontaneity, beauty, and emotion of every second. Our portfolio provides an insight into the variety of 
            styles and abilities that set our team apart, whether you're looking for inspiration, want to hire a photographer, 
            or are just interested in the art. Investigate, learn, and allow the pictures to do the talking.
        </p>
    </div>

    <div class="container">
        <!-- Search Form -->
        <form method="POST" class="mb-3">
            <label>Select Category:</label>
            <select name="category" class="form-select">
            <option value="">-- Select an Option --</option>
                <option value="portrait">Portrait</option>
                <option value="landscape">Landscape</option>
                <option value="Architecture">Architecture</option>
                <option value="candid">Candid</option>
                <option value="commercial">Commercial</option>
            </select>
            <button class="btn btn-success mt-2" name="search" type="submit">Search</button>
        </form>

        <!-- Table of Photographers -->
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($photographers as $photographer) {
                    // Render each photographer's data as a table row
                    echo $photographer->renderRow();
                } ?>
            </tbody>
        </table>

        <!-- Insert Photographer -->
        <h2>Insert New Photographer</h2>
        <form method="POST">
            <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
            <input type="text" name="category" class="form-control mb-2" placeholder="Category" required>
            <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
            <input type="text" name="imgSrc" class="form-control mb-2" placeholder="Image URL" required>
            <button class="btn btn-success" name="insert" type="submit">Insert</button>
        </form>

        <!-- Edit Photographer -->
        <?php if ($editingPhotographer): ?>
            <!-- Edit Photographer Section -->
            <!-- This section displays a form to edit an existing photographer's details -->
            <h2>Edit Photographer</h2>
            <form method="POST">
                <!-- Hidden field to store the photographer's ID -->
                <input type="hidden" name="id" value="<?= $editingPhotographer['id'] ?>">
                <!-- Input field for photographer's name -->
                <input type="text" name="name" class="form-control mb-2" value="<?= $editingPhotographer['name'] ?>" required>
                <!-- Input field for photographer's category -->
                <input type="text" name="category" class="form-control mb-2" value="<?= $editingPhotographer['category'] ?>" required>
                <!-- Textarea for photographer's description -->
                <textarea name="description" class="form-control mb-2" required><?= $editingPhotographer['description'] ?></textarea>
                <!-- Input field for photographer's image source -->
                <input type="text" name="imgSrc" class="form-control mb-2" value="<?= $editingPhotographer['imgSrc'] ?>" required>
                <!-- Button to submit the updated details -->
                <button class="btn btn-warning" name="update" type="submit">Update</button>
            </form>
        <?php endif; ?>
    </div>
     <!-- Footer -->
     <footer>
        <p>&copy; 2024 Lens and Light. All Rights Reserved.</p>
        <p>Contact us : <a href="mailto:info@lensandlight.com">info@lensandlight.com</a> | Phone: +1-800-123-4567</p>
        <p>Follow us on:
            <span class="social-icons">
                <a href="https://www.instagram.com/photonewspn/?hl=en"><i class="fab fa-instagram"></i></a>
                <a href="https://twitter.com/photonewspn"><i class="fab fa-twitter"></i></a>
            </span>
        </p>
    </footer>
</body>
</html>
