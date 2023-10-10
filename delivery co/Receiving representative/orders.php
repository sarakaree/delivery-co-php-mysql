<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<!--bootstrap css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <body class="sb-nav-fixed">
<link rel="stylesheet" href="style.css">


<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'delivery');

// Check if the user is logged in
if (!isset($_SESSION['rep_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the rep locations from the rep table
$location_query = "SELECT locations FROM `receiving rep.` WHERE rep_id = {$_SESSION['rep_id']}";
$location_result = mysqli_query($con, $location_query);

if (!$location_result) {
    die("Error: " . mysqli_error($con)); // Display the MySQL error message
}

$rep_locations = array();
while ($row = mysqli_fetch_assoc($location_result)) {
    // Assuming locations are stored as a comma-separated string in the database
    $locations = explode(',', $row['locations']);
    foreach ($locations as $location) {
        $rep_locations[] = trim($location);
    }
}

// Query to fetch orders based on matching merchant locations
$locationList = "'" . implode("','", $rep_locations) . "'";
$query = "SELECT o.* FROM orders o
          INNER JOIN merchant m ON o.merchant_id = m.merchant_id
          WHERE m.merchant_location IN ($locationList)";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con)); // Display the MySQL error message
}



// Handle the form submission when the تم الاستلام button is clicked
if (isset($_POST['order_delivered'])) {
    $order_id = $_POST['order_id'];

    // Fetch the merchant_id associated with the order
    $merchant_id_query = "SELECT merchant_id FROM orders WHERE order_id = $order_id";
    $merchant_id_result = mysqli_query($con, $merchant_id_query);

    if ($merchant_id_result && mysqli_num_rows($merchant_id_result) > 0) {
        $row = mysqli_fetch_assoc($merchant_id_result);
        $merchant_id = $row['merchant_id'];

        // Update the order status to "for rep"
        $update_query = "UPDATE orders SET order_status = 'لدى مندوب الاستلام' WHERE order_id = $order_id";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            // Notify the merchant about the status change
            $notification_message = 'تم تغيير حالة طلبك إلى "للمندوب"';
            
            // Insert the notification into the merchant's notifications table (assuming you have one)
            $insert_notification_query = "INSERT INTO merchant_notifications (merchant_id, message) VALUES ($merchant_id, '$notification_message')";
            $insert_notification_result = mysqli_query($con, $insert_notification_query);
            
            if (!$insert_notification_result) {
                die("Error: " . mysqli_error($con)); // Handle the error if notification insertion fails
            }
        } else {
            die("Error: " . mysqli_error($con)); // Handle the error if order status update fails
        }
    } else {
        die("Error: Unable to fetch merchant_id for the order.");
    }
}



?>



<!DOCTYPE html>
<html>
<head>
<title>واجهة مندوب الاستلام</title>
<meta charset="UTF-8">
</head>
<body>
    <h1>الطلبات الغير مستلمه</h1>
    <table class="table table-bordered mt-5">
        <thead class="bg-secondary text-light text-center">
            <tr>
                <th>Order ID</th>
                <th>اسم الزبون</th>
                <th>المنتجات</th>
                <th>السعر الكلي</th>
                <th>التواصل</th>
                <th>الموقع</th>
                <th>حالة الطلب</th>
                <th>حالة الدفع</th>
                <th>التاريخ</th>
                <th>merchant ID</th>
                <!-- Add other order data columns here -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['products']; ?></td>
                    <td><?php echo $row['total_cost']; ?></td>
                    <td><?php echo $row['user_contact']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['order_status']; ?></td>
                    <td><?php echo $row['payment_status']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['merchant_id']; ?></td>

              
<td>
    <form method="post">
        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
        <button type="submit" name="order_delivered" class="btn btn-danger green-button">استلم</button>
    </form>
</td>

                    
                    <!-- Add other order data columns here -->
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>



