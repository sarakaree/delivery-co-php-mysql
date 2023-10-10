<?php
include('../connection.php');



if (isset($_POST['insert'])){
    $user_name = $_POST['username'];
    $products = $_POST['products'];
    $total_cost = $_POST['cost'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];
    $order_status = $_POST['ostatus'];
    $payment_status = $_POST['pstatus'];
    $rep = $_POST['rep'];
    $date = $_POST['date'];

    // Retrieve the merchant_id from the session
    $merchant_id = $_SESSION['merchant_id'];

    $insert_products = "INSERT INTO orders (`merchant_id`, `user_name`, `products`, `total_cost`, `user_contact`, `location`, `order_status`, `payment_status`,`receiving_rep`, `date`)
        VALUES ('$merchant_id', '$user_name', '$products', '$total_cost', '$contact', '$location', '$order_status', '$payment_status','$rep', '$date') ";
    $result_query = mysqli_query($con, $insert_products);

    if ($result_query) {
        echo "<script>alert('Order inserted successfully')</script>";

        // Redirect to the "View Orders" page
        header('Location: merchant_interface.php?vieworders');
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>



<html>
    <head>
        <!--bootstrap css-->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <body class="sb-nav-fixed"> 
        <link rel="stylesheet" href="style.css">
   </head>

    <body>
        <div class="class container mt-2">
            <h1 class="class text-center">أضف الطلب</h1>
             
            <form action="" method="post" enctype="multipart/form-data">
                <div class="class form-outline mb-4">
                    <!-- (for ) and (id) should exacly the same-->
                    <label for="user_name" class="form-label">اسم الزبون</label> 
                    <input type ="text" name="username" id="user_name" class="form-control bg-light" required>

                    <label for="products" class="form-label">المنتجات</label> 
                    <textarea id="products" name="products" class="form-control bg-light" required>
                    
                    </textarea>
                    <script>
                      const textarea = document.getElementById('products');

                       // Add an input event listener to the textarea
                       textarea.addEventListener('input', function () {
                      this.style.height = 'auto'; // Reset the height
                       this.style.height = this.scrollHeight + 'px'; // Set the height to fit the content
                       });
                      </script>

                    <label for="cost" class="form-label">السعر الكلي</label> 
                    <input type ="number" name="cost" id="cost" class="form-control bg-light" required >

                    <label for="location" class="form-label">المنطقه</label> 
                    <select name="location" id="" class="form-control btn-outline-info bg-light" required>
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
                    <input type ="text" name="contact" id="contact" class="form-control bg-light" required>
                    



                    <label for="ostatus" class="form-label">حالة الطلب</label> 
                    <select name="ostatus" id="ostatus" class="form-control btn-outline-info bg-light">
                       <option value="لدى التاجر">لدى التاجر</option>
                       <option value="لدى مندوب الاستلام">لدى مندوب الاستلام</option>
                      
                       
                        
                    </select>
            

                    <label for="pstatus" class="form-label">حالة الدفع</label> 
                    <select name="pstatus" id="pstatus" class="form-control btn-outline-info bg-light" required>
                    <option value="cash">كاش</option>
                    <option value="visa">فيزا</option>
                        
                    </select>

                   <!-- <label for="rep" class="form-label">مندوب الاستلام</label> 
                    <select name="rep" id="" class="form-control btn-outline-info bg-light" required>
                        <?php
                        $select_query="Select * from `receiving rep.`";
                        $result_query=mysqli_query($con,$select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $rep_name=$row['employee_name'];
                            $rep_id=$row['rep_id'];
                            echo"<option value='$rep_name'>$rep_name</option>";
                        }
                        ?>  
                    </select> -->
                     
                    <label for="date" class="form-label">التاريخ</label>
                    <input type="date" id="date" name="date" class="form-control bg-light" required>

                    <input type="submit" name="insert" class="btn-outline-info text-dark mt-3">
                    
            



                     


                    
                 </div>

             </form>
         
         </div>

    
      </body>




</html>
