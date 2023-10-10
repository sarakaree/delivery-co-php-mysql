<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">

<h1 class="text-center">كل الطلبات</h1>
<table class="table table-bordered mt-5">
    <thead class="bg-secondary text-light text-center">
        <tr>
            <th>اسم التاجر</th>
            <th>تسلسل الزبون</th>
            <th>اسم الزبون</th>
            <th>المنتجات</th>
            <th>السعر الكلي</th>
            <th>التواصل</th>
            <th>الموقع</th>
            <th>حالة الطلب</th>
            <th>حالة الدفع</th>
            <th>التاريخ</th>
            <th>تعديل</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody class="bg-light text-dark">
    <?php
include('../connection.php');

// Check if the merchant is logged in (you may have a login check)
if (isset($_SESSION['merchant_id'])) {
    $merchant_id = $_SESSION['merchant_id'];

    // Fetch only the orders associated with the merchant's ID
    $query = "SELECT orders.*, merchant.merchant_name FROM orders 
             LEFT JOIN merchant ON orders.merchant_id = merchant.merchant_id WHERE orders.merchant_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $merchant_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

   

    while ($row = mysqli_fetch_assoc($result)) {
        $order_id = $row['order_id'];
        $user_name = $row['user_name'];
        $products = $row['products'];
        $total_cost = $row['total_cost'];
        $user_contact = $row['user_contact'];
        $location = $row['location'];
        $order_status = $row['order_status'];
        $payment_status = $row['payment_status'];
        $date = $row['date'];
        $merchant_name = $row['merchant_name'];
?>
        <tr class='text-center'>
            <td><?php echo $merchant_name; ?></td>
            <td><?php echo $order_id; ?></td>
            <td><?php echo $user_name; ?></td>
            <td><?php echo nl2br($products); ?></td>
            <td><?php echo $total_cost; ?></td>
            <td><?php echo $user_contact; ?></td>
            <td><?php echo $location; ?></td>
            <td><?php echo $order_status; ?></td>
            <td><?php echo $payment_status; ?></td>
            <td><?php echo $date; ?></td>
            
            <td><a href='merchant_interface.php?editorder=<?php echo $order_id; ?>' class='text-dark'><i class='fas fa-edit'></i></a></td>
            <td><a href='merchant_interface.php?deleteorder=<?php echo $order_id; ?>' class='text-dark'><i class='fas fa-trash'></i></a></td>
        </tr>
<?php
    }
}
?>


    </tbody>
</table>
