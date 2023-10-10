<!-- to display each product previous info into the boxes -->

<?php
include('../connection.php');
if (isset($_GET['editorder'])) {
    $edit_id = $_GET['editorder'];
    //prevent SQL injection
    $get_productinfo = "SELECT * FROM `orders` WHERE order_id=?";
    $stmt = mysqli_prepare($con, $get_productinfo);
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $user_name = $row['user_name'];
        $products = $row['products'];
        $total_cost = $row['total_cost'];
        $user_contact = $row['user_contact'];
        $location=$row['location'];
        $order_status = $row['order_status'];
        $payment_status = $row['payment_status'];
        $date = $row['date'];
    }
}
?>

<html>
<head>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="sb-nav-fixed">
<div class="container mt-2">
    <h1 class="text-center">تعديل الطلب</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline mb-4">
            <!-- (for ) and (id) should exactly be the same-->
            <label for="user_name" class="form-label">اسم الزبون</label> 
            <input type ="text" name="username" id="user_name" value="<?php echo $user_name; ?>" class="form-control bg-light" required>

            <label for="products" class="form-label">المنتجات</label> 
            <textarea id="products" name="products" class="form-control bg-light" required><?php echo $products; ?></textarea>

            <script>
                const textarea = document.getElementById('products');

                // Add an input event listener to the textarea
                textarea.addEventListener('input', function () {
                    this.style.height = 'auto'; // Reset the height
                    this.style.height = this.scrollHeight + 'px'; // Set the height to fit the content
                });
            </script>

            <label for="cost" class="form-label">السعر الكلي</label> 
            <input type ="number" name="cost" id="cost" value="<?php echo $total_cost; ?>" class="form-control bg-light" required>
 
            <label for="location" class="form-label">المنطقه</label> 
                    <select name="location" id="location" class="form-control btn-outline-info bg-light" required>
                        <?php
                        $select_query="Select * from `locations`";
                        $result_query=mysqli_query($con,$select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $cat_name=$row['location_name'];
                            $cat_id=$row['location_id'];
                            echo"<option value='$cat_name'>$cat_name</option>";
                        }
                        ?>  
                    </select>


            <label for="contact" class="form-label">التواصل</label> 
            <input type ="text" name="contact" id="contact" value="<?php echo $user_contact; ?>" class="form-control bg-light" required>

            <label for="ostatus" class="form-label">حالة الطلب</label> 
            <select name="ostatus" id="ostatus" class="form-control btn-outline-info bg-light">
                <option value=""><?php echo $order_status ?></option>
                <option value="pending">قيد الارسال</option>
                <option value="deliverd">قيد التسليم</option> 
            </select>

            <label for="pstatus" class="form-label">حالة الدفع</label> 
            <select name="pstatus" id="pstatus" class="form-control btn-outline-info bg-light" required>
                <option value=""><?php echo $payment_status ?></option>
                <option value="cash">كاش</option>
                <option value="visa">فيزا</option>
            </select>

            <label for="date" class="form-label">التاريخ</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>" class="form-control bg-light" required>

            <input type="submit" name="update" class="btn-outline-info text-dark mt-3">
        </div>
    </form>
</div>

<!-- submitting the update -->
<?php
if (isset($_POST['update'])) {
    $user_name = $_POST['username'];
    $products = $_POST['products'];
    $total_cost = $_POST['cost'];
    $user_contact = $_POST['contact'];
    $location=$_POST['location'];
    $order_status = $_POST['ostatus'];
    $payment_status = $_POST['pstatus'];
    $date = $_POST['date'];

    $update_query = "UPDATE `orders` SET `user_name`='$user_name', `products`='$products', `total_cost`='$total_cost',
        `user_contact`='$user_contact',`location`='$location', `order_status`='$order_status', `payment_status`='$payment_status', `date`='$date'
        WHERE order_id='$edit_id'";
    $result_update = mysqli_query($con, $update_query);
   // After successful update
if ($result_update) {
    header("Location: merchant_interface.php?vieworders");
    exit;
    //echo "<script>alert('Order updated successfully')</script>";
    
    // Redirect to another page
     // Make sure to exit the scrip
}

    
}
?>
</body>
</html>

