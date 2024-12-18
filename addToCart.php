<?php
session_start(); // Start the session to manage the cart and other session-related data

// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'store';      // Database name (store)

// Create a new connection to the MySQL database
$conn = new mysqli($host, $username, $password, $database);

// Check for a connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Exit if connection fails and show error message
}

// Check if the form is submitted via POST request (for adding an item to the cart)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product ID and quantity from the POST data
    $productId = $_POST['product_id']; // Product ID from the form
    $quantity = $_POST['quantity'] ?? 1; // Product quantity, default to 1 if not provided

    // Fetch the product details from the database using the provided product ID
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?"); // Prepare the SQL query
    $stmt->bind_param("i", $productId); // Bind the product ID to the query
    $stmt->execute(); // Execute the query to get the product details
    $result = $stmt->get_result(); // Get the result from the query
    $product = $result->fetch_assoc(); // Fetch the product details as an associative array

    // Check if the product exists in the database
    if (!$product) {
        die("Product not found."); // Exit if the product is not found in the database
    }

    // Check if the cart session is already initialized, if not, initialize it as an empty array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Initialize the cart as an empty array
    }

    // If the product is already in the cart, increase the quantity by the specified amount
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity; // Add to existing quantity
    } else {
        // If the product is not in the cart, add it to the cart
        $_SESSION['cart'][$productId] = [
            "product_id" => $product['product_id'], // Product ID
            "description" => $product['description'], // Product description
            "price" => $product['price'], // Product price
            "quantity" => $quantity // Product quantity to be added
        ];
    }

    // Redirect the user to the cart page after adding the product to the cart
    header('Location: cart.php');
    exit; // Exit to ensure no further code is executed after the redirect
}

// Fetch all products from the database to display in the store
$result = $conn->query("SELECT * FROM products"); // Run a query to select all products
$products = $result->fetch_all(MYSQLI_ASSOC); // Fetch all products as an associative array
?>