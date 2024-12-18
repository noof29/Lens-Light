<?php
session_start(); // Start the session to access the cart

// Retrieve the cart from the session, or initialize as an empty array if not set
$cart = $_SESSION['cart'] ?? [];

// Check if the form is submitted via POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect customer information from the form
    $name = $_POST['name'] ?? ''; // Customer's name
    $email = $_POST['email'] ?? ''; // Customer's email
    $phone = $_POST['phone'] ?? ''; // Customer's phone number
    $address = $_POST['address'] ?? ''; // Shipping address

    // Validate that all required fields are filled
    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $error = "All fields are required."; // Error message if any field is missing
    } else {
        // Save the order details to the database
        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'store');

        // Check if the database connection is successful
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        // Get the current date and time for the order
        $order_date = date('Y-m-d H:i:s'); // Current date and time

        // Insert order details into the orders table
        $stmt = $conn->prepare(
            "INSERT INTO orders (customer_name, phone, email, shippingAddress, total, order_date) 
             VALUES (?, ?, ?, ?, ?, NOW())"
        );

        // Initialize the total to 0
        $total = 0;

        // Bind customer details and total for insertion
        $stmt->bind_param("ssssd", $name, $phone, $email, $address, $total);
        $stmt->execute(); // Execute the query to insert the order

        // Get the last inserted order ID (used for order items)
        $order_id = $conn->insert_id;

        // Now, insert each order item into the orderItems table
        $stmt = $conn->prepare("INSERT INTO orderItems (order_id, product_id, quantity, price) 
                                VALUES (?, ?, ?, ?)");

        foreach ($cart as $item) {
            $product_id = $item['product_id']; // Assuming 'product_id' key exists in the cart
            $quantity = $item['quantity']; // Quantity of the product
            $price = $item['price']; // Price of the product
            $totalItem = $price * $quantity; // Total cost for this item
            $total += $totalItem; // Add the item's total cost to the overall order total
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $stmt->execute(); // Insert each order item
        }

        // After inserting all items, update the total in the orders table
        $stmt = $conn->prepare("UPDATE orders SET total = ? WHERE order_id = ?");
        $stmt->bind_param("di", $total, $order_id); // Bind the updated total and order_id
        $stmt->execute(); // Update the order total

        // Clear the cart after the order is processed
        $_SESSION['cart'] = [];

        // Redirect to the thank-you page
        header('Location: thank_you.html');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        /* Styling for the body to ensure proper font and margins */
        body {
            font-family: Arial, sans-serif; /* Sets the font for the page */
            margin: 20px; /* Adds margin around the body */
        }

        /* Styling for the cart items table */
        .items {
            width: 100%; /* Ensures the table spans the full width of its container */
            border-collapse: collapse; /* Removes spaces between table cells */
            margin-bottom: 20px; /* Adds margin below the table */
        }

        /* Styling for table header and cells */
        .items th, .items td {
            padding: 10px; /* Adds padding inside each cell */
            border: 1px solid #ddd; /* Adds a light border around each cell */
            text-align: left; /* Aligns text to the left in each cell */
        }

        /* Styling for table header */
        .items th {
            background-color: #f4f4f4; /* Sets a light grey background color for the header */
        }

        /* Styling for the customer information section */
        .customer-info {
            margin: 0 auto; /* Centers the table horizontally */
            width: 500px; /* Sets the width of the table */
            height: 200px; /* Sets the height of the table */
            text-align: left; /* Aligns text to the left */
            font-size: 20px; /* Increases the font size for better readability */
        }

        /* Styling for input fields and buttons */
        input, button {
            width: 100%; /* Makes inputs and buttons take up the full width of their container */
            border-radius: 5px; /* Adds rounded corners to inputs and buttons */
            margin-bottom: 10px; /* Adds margin below each input and button */
            padding: 10px; /* Adds padding inside each input and button */
            font-size: 20px; /* Sets the font size for the inputs and buttons */
        }

        /* Styling for the submit button */
        button {
            background-color: #28a745; /* Sets a green background color */
            color: white; /* Sets the text color to white */
            border: none; /* Removes the border around the button */
            cursor: pointer; /* Changes the cursor to a pointer when hovered */
            width: fit-content; /* Makes the button width match its content */
            display: block; /* Makes the button a block element (takes up its own line) */
            margin: 0 auto; /* Centers the button horizontally */
        }

        /* Hover effect for the button */
        button:hover {
            background-color: #218838; /* Darkens the green background color when hovered */
        }

        /* Styling for the error message */
        .error {
            color: red; /* Sets the text color to red */
            margin-bottom: 10px; /* Adds margin below the error message */
        }
    </style>
</head>
<body>
<h1>Checkout</h1>

<?php if (!empty($error)): ?>
    <!-- Display error message if validation fails -->
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (empty($cart)): ?>
    <!-- Display a message if the cart is empty -->
    <p>Your cart is empty.</p>
<?php else: ?>
    <!-- Display the cart items in a table -->
    <table class="items">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php foreach ($cart as $item): ?>
            <tr>
                <!-- Display product details in each row -->
                <td><?= htmlspecialchars($item['description']) ?></td>
                <td><?= number_format($item['price'], 3) ?> OMR</td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td><?= number_format($item['price'] * $item['quantity'], 3) ?> OMR</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <!-- Display total cost of the items in the cart -->
    <p><strong>Total: <?= number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)), 3) ?>
    OMR</strong></p>

    <!-- Checkout form to collect customer information -->
    <form method="post">
        <table class="customer-info">
            <tr>
                <!-- Customer's Name -->
                <th><label for="name">Name:</label></th>
                <td><input type="text" id="name" name="name" required></td>
            </tr>
            <tr>
                <!-- Customer's Phone -->
                <th><label for="phone">Phone:</label></th>
                <td><input type="text" id="phone" name="phone" required></td>
            </tr>
            <tr>
                <!-- Customer's Email -->
                <th><label for="email">Email:</label></th>
                <td><input type="email" id="email" name="email" required></td>
            </tr>
            <tr>
                <!-- Customer's Shipping Address -->
                <th><label for="address">Address:</label></th>
                <td><input type="text" id="address" name="address" required></td>
            </tr>
            <!-- Submit Button -->
            <tr><td colspan="2"><button type="submit">Place Order</button></td></tr>
        </table>
    </form>
<?php endif; ?>
</body>
</html>