<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lensandLightdb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);

        }
        

    $sql = "SELECT * FROM Bookings";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h1>All bookings:</h1>";
        echo "<table border='1'>
                <tr>
                    <th>Booking ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Service Type</th>
                    <th>Preferred Date</th>
                    <th>Location</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["Booking_ID"]."</td>
                    <td>".$row["Customer_name"]."</td>
                    <td>".$row["Email"]."</td>
                    <td>".$row["Service_type"]."</td>
                    <td>".$row["Preferred_date"]."</td>
                    <td>".$row["location"]."</td>

                </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $conn->close();
?>
