<?php
$con=mysqli_connect('localhost','root','','delivery');

if(!$con){
    echo "connection success";
 }
?>
<!-- to make the database display arabic-->
<!--$con=mysqli_connect('localhost','root','','delivery');
$query = "ALTER DATABASE merchant CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
mysqli_query($con, $query);--> 