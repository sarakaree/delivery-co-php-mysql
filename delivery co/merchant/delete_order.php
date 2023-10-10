<?php

if (isset($_GET['deleteorder'])){
    $delete_id=$_GET['deleteorder'];

    $delete_query="delete from `orders` where order_id=$delete_id";
    $delete_result=mysqli_query($con, $delete_query);
    if($delete_result){
        echo "<script>alert('deletedddd')</script>";
        // Redirect to another page
    header("Location: merchant_interface.php?vieworders");
    exit; // Make sure to exit the script
    }
}
?>