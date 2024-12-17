<?php
//Database connection details
$host = "localhost";
$username = "root";
$password = "";
$database = "LensAndLight";

//Create a database connection
$conn = new mysqli($host, $username, $password, $database);

//Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Handle POST request to add a new order
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Style
    echo "<html><head>
    <style>
    h2, h3, h4 { margin-left: 20px; margin-right: 20px; }
    table { border: 1px solid black; border-collapse: collapse; margin: 20px;}
    table td, table th { border: 1px solid black; margin: 10px 10px; padding: 5px 5px; }
    </style></head><body>";

    //Retreive customer name, phone number, status, and location address from the form
    $customerName = $_POST['name'];
    $customerNumber = $_POST['phone'];
    $status = $_POST['status'];
    $location = $_POST['location'];

    //Set discount to 0
    $discountRate = 0;
                
    //If the customer status is student, give discount 10%
    if ($status == "s") {
        $discountRate = 0.10;
    }

    //Get order date
    $date = date('Y-m-d H:i:s');
    //To calculate total price
    $totalPrice = 0;

    //Insert data into the orders table
    $sql_order = "INSERT INTO orders (customerName, phoneNumber, customerStatus, locationAddress, orderDate, totalPrice) VALUES ('$customerName', '$customerNumber', '$status', '$location', '$date', '$totalPrice')";
    
    if ($conn->query($sql_order) === TRUE) {
        //Get the last inserted order_id
        $order_id = $conn->insert_id;

        //Display title and customer information
        echo "<h2>Lens and Light - Your Order</h2>";
        echo "<h4>Customer Name: $customerName</h4>";
        echo "<h4>Phone Number: $customerNumber</h4>";
        echo "<h4>Location Address: $location</h4>";
        
        //Display table headings
        echo "<table><tr><th>Description</th><th>Quantity</th>
        <th>Price Per Unit</th><th>Discounted Price</th><th>Total</th></tr>";
        
        //Now insert order items
        for ($i = 1; $i <= 7; $i++) {
            if (!empty($_POST["item".$i."ID"]) && !empty($_POST["item".$i."Qty"])) {
                $product_id = $_POST["item".$i."ID"];
                $quantity = $_POST["item".$i."Qty"];
                
                //Retreive the price and description of the selected product
                $sql_price = "SELECT description, price FROM products WHERE product_id = $product_id";
                $result = $conn->query($sql_price);
                $row = $result->fetch_assoc();
                $description = $row['description'];
                $price = $row['price'];

                //Print product description, quantity, and price per unit
                echo "<tr><td>".$row['description']."</td>
                <td>".$quantity."</td>
                <td>".number_format($price, 3)." OMR</td>";
                
                //Calculate the total price for this item
                $discountedPrice = $price * (1 - $discountRate);
                $itemTotal = $discountedPrice * $quantity;
                $totalPrice += $itemTotal;

                //Print discounted price and total
                echo "<td>".number_format($discountedPrice, 3)." OMR</td>
                <td>".number_format($itemTotal, 3)." OMR</td></tr>";
                
                //Insert the item into the orderItems table
                $sql_item = "INSERT INTO orderItems (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $discountedPrice)";
                $conn->query($sql_item);
            }
        }
        
        //Update the total price of the order
        $sql_update_order = "UPDATE orders SET totalPrice = $totalPrice WHERE order_id = $order_id";
        $result_update_order = mysqli_query($conn, $sql_update_order);
        
        //Print total price
        echo "</table>";
        $totalPrice = number_format($totalPrice, 3);
        echo "<h3>Total Amount = $totalPrice OMR</h3>";

        //Print date
        $sql_date = "SELECT orderDate FROM orders WHERE order_id = $order_id";
        $result_date = $conn->query($sql_date);
        $row = $result_date->fetch_assoc();
        $date = $row['orderDate'];
        echo "<h4>$date</h4>";
        echo "<h3>Thank you for your order!</h3>";
    }
}

//Close the database connection
$conn->close();
?>
