<?php
include('../connection.php');

if(isset($_POST['insert'])){
    $loc_title = $_POST['location'];
    $insert_query = "INSERT INTO `locations` (location_name) VALUES ('$loc_title')";
    $result = mysqli_query($con, $insert_query);
    if($result){
        echo "<script>alert('location added')</script>";
            

            

    }
}
?>


<form action="" method="POST" class="col-md-10">
<div class="input-group mb-3">
  <input type="text" class="form-control" name="location" placeholder="اضف الموقع"  aria-label="prodect cat" aria-describedby="button-addon2" required>
  <input type="submit" class="btn btn-outline-info text-dark" name="insert" value="insert">
</div> 
</form>