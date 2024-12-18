<?php
session_start(); // Start the session to manage the cart

// Ensure the cart session is initialized if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Initialize the cart as an empty array
}

// Check if the form is submitted via POST request (for removing an item)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the product ID from the POST request and sanitize it to ensure it's an integer
    $productId = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);

    // Remove the item with the corresponding product ID from the cart
    unset($_SESSION['cart'][$productId]);
}

// Retrieve the current cart data from the session
$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <!-- Including Bootstrap for styling and layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="my-4">Your Cart</h1>

    <?php if (empty($cart)): ?>
        <!-- Display a warning message if the cart is empty -->
        <div class="alert alert-warning">Your cart is empty.</div>
    <?php else: ?>
        <!-- Display the cart items in a table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $id => $item): ?>
                    <!-- Loop through each item in the cart and display its details -->
                    <tr>
                        <td><?= htmlspecialchars($item['description']) ?></td> <!-- Product description -->
                        <td><?= number_format($item['price'], 3) ?> OMR</td> <!-- Product price formatted to 3 decimal places -->
                        <td><?= htmlspecialchars($item['quantity']) ?></td> <!-- Product quantity -->
                        <td><?= number_format($item['price'] * $item['quantity'], 3) ?> OMR</td> <!-- Total price for the item (price * quantity) -->
                        <td>
                            <!-- Form to handle item removal from the cart -->
                            <form method="post">
                                <input type="hidden" name="product_id" value="<?= $id ?>"> <!-- Pass the product ID -->
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button> <!-- Remove button -->
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Display the total cost of all items in the cart -->
        <p class="text-end"><strong>Total: 
            <?= number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)), 3) ?> OMR</strong></p>
    <?php endif; ?>

    <!-- Link to continue shopping -->
    <a href="store.php" class="btn btn-primary">Continue Shopping</a>

    <!-- Link to proceed to the checkout page -->
    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
</div>
</body>
</html>