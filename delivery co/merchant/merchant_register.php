<!-- register.php -->


<!DOCTYPE html>
<html>

<?php
session_start();
// connect to the database 
$con = mysqli_connect('localhost', 'root', '', 'delivery');

$query = "ALTER DATABASE merchant CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
mysqli_query($con, $query);

if (isset($_POST['register'])) {
    $username = $_POST['merchant_name'];
    $location = $_POST['merchant_location'];
    $password = $_POST['password'];

    // Insert the admin into the database
    $insert_query = "INSERT INTO merchant (`merchant_name`,  `password`, `merchant_location`) VALUES ('$username', '$password', '$location')";
    mysqli_query($con, $insert_query);

    // Get the last inserted ID
    $merchant_id = mysqli_insert_id($con);

    // Store data in session
    $_SESSION['merchant_name'] = $username;
    $_SESSION['merchant_password'] = $password;
    $_SESSION['merchant_id'] = $merchant_id;

    // Redirect to the login page after registration
    header('Location: merchant_interface.php');
    exit();
}
?>




<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="sb-nav-fixed bg-dark">
    <div class="container mt-2">
        <h1 class="text-center text-light">تسجيل التاجر</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-outline mb-4">
                <label for="username" class="form-label text-light">اسم التاجر</label>
                <input type="text" name="merchant_name" id="username" class="form-control bg-light" required>
                
                
                <label for="userpassword" class="form-label text-light">الرمز السري</label>
                <div class="input-group">
                    <input type="password" name="password" id="userpassword" class="form-control bg-light" required>
                    <span class="input-group-text">
                        <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">Show</button>
                    </span>
                </div>
                <label for="location" class="form-label">المنطقه</label> 
                    <select name="merchant_location" id="" class="form-control btn-outline-info bg-light" required>
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
                <input type="submit" name="register" class="btn btn-outline-info mt-3" value="SIGN UP">
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("userpassword");
            var toggleButton = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.textContent = "Hide";
            } else {
                passwordInput.type = "password";
                toggleButton.textContent = "Show";
            }
        }
    </script>
</body>
</html>
