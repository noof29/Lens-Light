<?php
//Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'LensAndLight'; //Database name

try {
    //Create a new PDO instance for connecting to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    //Set the error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //If the connection fails, display an error message
    die("Connection failed: " . $e->getMessage());
}

//Initialize brand as an empty string if not selected
$brand = isset($_POST['brand']) ? $_POST['brand'] : '';

//Construct the SQL query. We are selecting specific columns from the 'products' table
$query = "SELECT product_id, description, brand, price, image FROM products";

//Check if a brand is selected, and if so, append a WHERE clause to filter by the brand
if ($brand) {
    $query .= " WHERE brand = :brand"; 
}

//Prepare the query using the database connection
//This helps prevent SQL injection by safely preparing the statement
$stmt = $pdo->prepare($query);

//If the $brand is set, bind the brand value to the SQL query's placeholder
if ($brand) {
    $stmt->bindParam(':brand', $brand); //Bind the selected brand to the :brand placeholder
}

//Execute the query to fetch the data from the database
$stmt->execute();
//Fetch all results
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Title of the Web Page -->
        <title>Store</title>

        <!-- Bootstrap CSS for responsive design and components -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Bundle JS (includes Popper.js for tooltips and popups) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Font Awesome for social media icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- External CSS Styling -->
        <link href="styles.css" rel="stylesheet"/>
        
        <!-- Document CSS Styling -->
        <style>
            /* Styling for the intro section with background image */
            .intro-section {
                background-image: url("intro_section.jpg"); /* Background image */
                background-position: center; /* Center the image */
                background-repeat: no-repeat; /* Prevent image repetition */
                background-size: cover; /* Cover the entire section */
                height: 60vh; /* Set height to 60% of the viewport height */
                align-content: center; /* Vertically center the content */
                font-style: Helvetica; /* Set font style */
                font-weight: bold; /* Make the text bold */
                color: white; /* Set text color to white */
                text-align: center; /* Center the text horizontally */
            }

            /* Styling for rows to ensure consistent height */
            .row {
                height: 580px;
            }
            
            /* Card component styling with hover effect */
            .card {
                transition: transform 0.3s; /* Smooth hover transition */
                height: 550px; /* Set fixed height */
                text-align: center; /* Center-align text */
                padding: 10px; /* Add padding */
            }

            /* Card body styling to ensure fixed height and flexibility */
            .card-body {
                height: 100px; /* Set fixed height for card body */
            }

            /* Footer section of the card with a white background */
            .card-footer {
                background-color: white;
            }
            
            /* Hover effect for card, slightly lift the card */
            .card:hover {
                transform: translateY(-10px); /* Move the card up */
            }
        </style>
        <!-- Header with Logo and Navigation -->
        <header>
            <div class="container-fluid d-flex justify-content-between align-items-center p-3">
                <!-- Logo and Website name on the Left -->
                <div class="d-flex align-items-center">
                    <img src="logo.png" alt="Logo" width="100" height="120" class="me-2">
                    <h1>LENS AND LIGHT</h1>
                </div>
                
                <!-- Navigation Links on the Right -->
                 <nav class="navbar navbar-expand-sm">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="portfolio.html">Portfolio</a></li>
                        <li class="nav-item"><a class="nav-link" href="booking.html">Booking</a></li>
                        <li class="nav-item"><a class="nav-link active">Store</a></li>
                        <li class="nav-item"><a class="nav-link" href="calculation.html">Calculation</a></li>
                        <li class="nav-item"><a class="nav-link" href="contactus.html">Contact us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Questionnaire</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Fun</a></li>
                        <li class="nav-item"><a class="nav-link" href="about us.html">About us</a></li>
                    </ul>
                </nav>
            </div>
        </header>
    </head>
    <body>
        <!-- Intro Section with background image and welcome text -->
        <header class="intro-section">
            <div><h1>Enhance every shot with our premium products</h1></div>
        </header>

        <!-- Products Section -->
        <section class="products">
            <div class="container">
                <!-- Heading for the Products Section -->
                <br/><h2 style="text-align: center;">All Products</h2><br/>
                <!-- Search Form to filter products by brand -->
                <div class="search-form">
                    <form method="POST" action="">
                        <h4 style="text-align: center;">Select Brand:</h4>
                        <select name="brand" id="searchDropdown" class="form-select w-50 mx-auto">
                            <!-- Dynamically selected options based on POST data -->
                            <option value="">-- Select an Option --</option>
                            <option value="CANON" <?php echo ($brand == 'CANON') ? 'selected' : ''; ?>>CANON</option>
                            <option value="NIKON" <?php echo ($brand == 'NIKON') ? 'selected' : ''; ?>>NIKON</option>
                            <option value="HAMA" <?php echo ($brand == 'HAMA') ? 'selected' : ''; ?>>HAMA</option>
                            <option value="LEXAR" <?php echo ($brand == 'LEXAR') ? 'selected' : ''; ?>>LEXAR</option>
                        </select>
                        <button type="submit" class="btn btn-warning mt-3" style="display: block; margin: 10px auto;">Search</button>
                    </form>
                </div>

                <!-- Loop through products and display 3 per row -->
                <div class="row justify-content-center">
                    <?php
                    $count = 0; //Initialize count to track the number of products displayed
                    foreach ($products as $product):
                        //After every 3 products, start a new row
                        if ($count % 3 == 0 && $count > 0): ?>
                            </div><div class="row justify-content-center">
                        <?php endif;
                        $count++;
                    ?>
                        <!-- Display individual product card -->
                        <div class="col-md-3">
                            <div class="card">
                                <!-- Product image -->
                                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="product">
                                <div class="card-body d-flex flex-column">
                                    <!-- Product Brand and Description -->
                                    <h5 class="card-title product-title"><?php echo $product['brand']; ?></h5>
                                    <p class="card-text"><?php echo $product['description']; ?></p>
                                    <!-- Product Price -->
                                    <p class="card-text mt-auto" style="font-weight: bold;"><?php echo number_format($product['price'], 3); ?> OMR</p>
                                </div>

                                <!-- Card footer with buttons -->
                                <div class="card-footer">
                                    <!-- View Details button -->
                                    <button type="button" class="btn btn-warning mt-3">View Details</button>
                                    <!-- Add to Cart button -->
                                    <button type="submit" class="btn btn-warning mt-3">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Footer Section with Contact and Social Media Links -->
        <footer>
            <p>&copy; 2024 LENS AND LIGHT. All Rights Reserved.</p>
            <p>Contact us: <a href="mailto:info@lensandlight.com">info@lensandlight.com</a> | Phone: +1-800-123-4567</p>
            <p>Follow us on:
                <span class="social-icons">
                    <a href="https://www.instagram.com/photonewspn/?hl=en"><i class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com/photonewspn"><i class="fab fa-twitter"></i></a>
                </span>
            </p>
        </footer>
    </body>
</html>