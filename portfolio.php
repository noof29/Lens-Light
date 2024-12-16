<?php
// Database Connection Setup
// Define database connection parameters
$host = 'localhost';
$db = 'portfolio_db';
$user = 'root'; // Update this if your database username is different
$pass = ''; // Update this if your database requires a password
$dsn = "mysql:host=$host;dbname=$db"; // Data Source Name for the PDO connection

try {
    // Create a new PDO instance with error handling enabled
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    // Handle connection errors by displaying a user-friendly message and exiting
    die("Connection failed: " . $e->getMessage());
}

// Handle Search Functionality
$searchResults = []; // Initialize an empty array to store search results
if (isset($_POST['search'])) { // Check if the search form was submitted
    $category = $_POST['category']; // Retrieve the selected category from the form

    if ($category) { // Proceed only if a category was selected
        // Prepare an SQL statement to search for photographers in the selected category
        $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE category LIKE ?");
        $stmt->execute(['%' . $category . '%']); // Execute the query with the category parameter
        $searchResults = $stmt->fetchAll(); // Fetch all matching records
    }
}

// Handle Insert Functionality
if (isset($_POST['insert'])) { // Check if the insert form was submitted
    // Retrieve form data
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $imgSrc = $_POST['imgSrc']; // File uploads should be handled securely in a real application

    // Prepare an SQL statement to insert a new photographer into the database
    $stmt = $pdo->prepare("INSERT INTO portfolio (name, category, description, imgSrc) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $category, $description, $imgSrc]); // Execute the query with form data
}

// Handle Delete Functionality
if (isset($_GET['delete'])) { // Check if the delete action was triggered
    $id = $_GET['delete']; // Retrieve the ID of the photographer to delete

    // Prepare an SQL statement to delete the record with the specified ID
    $stmt = $pdo->prepare("DELETE FROM portfolio WHERE id = ?");
    $stmt->execute([$id]); // Execute the query with the ID parameter

    // Redirect to the portfolio page to refresh the content
    header("Location: portfolio.php");
    exit; // Exit to ensure no further code is executed
}

// Handle Update Functionality
if (isset($_POST['update'])) { // Check if the update form was submitted
    // Retrieve form data
    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $imgSrc = $_POST['imgSrc'];

    // Prepare an SQL statement to update the photographer's details
    $stmt = $pdo->prepare("UPDATE portfolio SET name = ?, category = ?, description = ?, imgSrc = ? WHERE id = ?");
    $stmt->execute([$name, $category, $description, $imgSrc, $id]); // Execute the query with form data

    // Redirect to the portfolio page to refresh the content
    header("Location: portfolio.php");
    exit; // Exit to ensure no further code is executed
}

// Handle Edit Functionality (Fetch Photographer by ID)
$photographer = null; // Initialize a variable to store photographer details
if (isset($_GET['edit'])) { // Check if the edit action was triggered
    $id = (int)$_GET['edit']; // Retrieve the ID of the photographer to edit

    // Prepare an SQL statement to fetch the photographer's details by ID
    $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE id = ?");
    $stmt->execute([$id]); // Execute the query with the ID parameter
    $photographer = $stmt->fetch(); // Fetch the photographer's details
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
                    <li class="nav-item"><a class="nav-link active" href="portfolio.html">Portfolio</a></li>
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

    <!-- Search Section -->
    <div class="search-form">
        <form method="POST" action="portfolio.php">
            <label for="searchDropdown" class="form-label">Select Category:</label>
            <select name="category" id="searchDropdown" class="form-select w-50 mx-auto">
                <option value="">-- Select an Option --</option>
                <option value="portrait">Portrait</option>
                <option value="landscape">Landscape</option>
                <option value="Architecture">Architecture</option>
                <option value="candid">Candid</option>
                <option value="commercial">Commercial</option>

                <!-- Add other categories here -->
            </select>
            <button class="btn btn-warning mt-3" name="search" type="submit">Search</button>
        </form>
    </div>

    <!-- Photography Category Table -->
    <div class="container category-section">
        <table class="category-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Photographer</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($searchResults): ?>
                    <?php foreach ($searchResults as $photographer): ?>
                        <tr>
                            <td><img src="<?= $photographer['imgSrc']; ?>" alt="<?= $photographer['category']; ?>" class="table-img"></td>
                            <td><?= $photographer['category']; ?></td>
                            <td><?= $photographer['name']; ?></td>
                            <td><?= $photographer['description']; ?></td>
                            <td>
                                <a href="?delete=<?= $photographer['id']; ?>" class="btn btn-danger">Delete</a>
                                <a href="update.php?id=<?= $photographer['id']; ?>" class="btn btn-warning">Update</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center;">No results found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Insert Photographer Form -->
    <div class="container">
        <h3>Insert New Photographer</h3>
        <form method="POST" action="portfolio.php">
            <label for="name">Photographer Name:</label>
            <input type="text" name="name" class="form-control" required>
            <label for="category">Category:</label>
            <input type="text" name="category" class="form-control" required>
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required></textarea>
            <label for="imgSrc">Image Source:</label>
            <input type="text" name="imgSrc" class="form-control" required>
            <button type="submit" name="insert" class="btn btn-success mt-3">Insert Photographer</button>
        </form>
    </div>
    <script>
    /**
     * Filters the photographer data based on selected category from dropdown.
     */
    function search() {
        const searchTerm = document.getElementById('searchDropdown').value.toLowerCase(); // Get the selected category from the dropdown

        // If no category is selected or "Select an Option" is chosen, reset the table
        if (!searchTerm || searchTerm === "") {
            displayTable(photographers);  // Reset to show all photographers
        } else {
            // Filter photographers array based on the selected category
            const results = photographers.filter(p => p.category.toLowerCase() === searchTerm);
            displayTable(results);  // Display the filtered photographers in the table
        }
    }

    /**
     * Populates the dropdown menu with photography categories from the photographers array.
     */
    function populateDropdown() {
        const dropdown = document.getElementById('searchDropdown'); // Get the dropdown element by its ID
        const categories = []; // Initialize an empty array to store unique categories

        // Loop through the photographers array to extract categories
        for (const photographer of photographers) {
            // Check if the category is not already in the categories array
            if (!categories.includes(photographer.category)) {
                categories.push(photographer.category); // Add unique category to the categories array

                // Create a new <option> element for the dropdown menu
                const option = document.createElement('option');
                option.value = photographer.category.toLowerCase(); // Set the option's value (lowercase for comparison)
                option.textContent = photographer.category; // Set the display text for the option
                dropdown.appendChild(option); // Add the option to the dropdown
            }
        }
    }

    /**
     * Displays photographer data in a table format.
     * Clears the existing table content and populates it with the provided data.
     * @param {Array} data - An array of photographer objects to be displayed in the table.
     */
    function displayTable(data) {
        const tableBody = document.getElementById('photographyTable').getElementsByTagName('tbody')[0]; // Get the table's <tbody> element
        tableBody.innerHTML = ''; // Clear any existing rows in the table body

        // Loop through the data array to create table rows for each photographer
        for (const photographer of data) {
            const row = document.createElement('tr'); // Create a new row

            // Create a table cell for the image
            const imgCell = document.createElement('td');
            const img = document.createElement('img'); // Create an <img> element
            img.src = photographer.imgSrc; // Set the image source (file path)
            img.alt = `${photographer.category} photography`; // Set alternative text for the image
            img.className = 'table-img'; // Assign a CSS class for styling
            imgCell.appendChild(img); // Add the image to the cell
            row.appendChild(imgCell); // Add the image cell to the row

            // Create a table cell for the photographer's information
            const infoCell = document.createElement('td');
            infoCell.innerHTML = `
                <div class="category-name">${photographer.category}</div> <!-- Display category name -->
                <div class="photographer-name">${photographer.name}</div> <!-- Display photographer name -->
                <p>${photographer.description}</p> <!-- Display photographer description -->
            `;
            row.appendChild(infoCell); // Add the information cell to the row

            tableBody.appendChild(row); // Append the row to the table body
        }
    }

    /**
     * Initializes the page by populating the dropdown menu and displaying all photographers.
     * This function is called when the script is loaded to ensure the page is set up correctly.
     */
    function initializePage() {
        populateDropdown(); // Populate the dropdown menu with photography categories
        displayTable(photographers); // Display all photographers in the table by default
    }

    // Call the initializePage function to set up the page on load
    initializePage();
</script>


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
