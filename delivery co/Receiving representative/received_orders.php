<?php
session_start(); // Make sure to start the session

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"])) {
    $order_id = $_POST["order_id"];

    // Connect to your database (replace with your database connection code)
    $con = mysqli_connect('localhost', 'root', '', 'delivery');

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch the order details from the database
    $query = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Display the order details
        echo "<h1>Order Details</h1>";
        echo "<p>Order ID: " . $row['order_id'] . "</p>";
        echo "<p>User Name: " . $row['user_name'] . "</p>";
        echo "<p>Products: " . $row['products'] . "</p>";
        
    } else {
        echo "Order not found or an error occurred.";
    }

    
    mysqli_close($con);
}
?>
