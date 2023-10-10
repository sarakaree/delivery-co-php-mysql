<?php
session_start();
// connect to the database 
$con = mysqli_connect('localhost', 'root', '', 'delivery');

$query = "ALTER DATABASE merchant CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
mysqli_query($con, $query);

if (isset($_POST['login'])) {
    $username = $_POST['merchant_name'];
    $password = $_POST['password'];

    // Check if the merchant's username exists in the database
    $check_query = "SELECT * FROM merchant WHERE merchant_name = '$username'";
    $result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Merchant is registered, check the password
        $row = mysqli_fetch_assoc($result);
        if ($password === $row['password']) {
            // Password is correct, set session variables
            $_SESSION['merchant_name'] = $username;
            $_SESSION['merchant_password'] = $password;
            $_SESSION['merchant_id'] = $row['merchant_id'];

            // Redirect to the merchant's interface after login
            header('Location: merchant_interface.php');
            exit();
        } else {
            // Incorrect password, handle the error (e.g., show an error message)
            echo "Incorrect password. Please try again.";
        }
    } else {
        // Merchant username not found, handle the error (e.g., show an error message)
        echo "Merchant not found. Please register.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <title>تسجيل دخول التاجر</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="sb-nav-fixed bg-dark">
    <div class="container mt-2">
        <h1 class="text-center text-light">تسجيل دخول التاجر</h1>
        <form action="" method="post">
            <div class="form-outline mb-4">
                <label for="merchant_name" class="form-label text-light">اسم المستخدم</label>
                <input type="text" name="merchant_name" id="merchant_name" class="form-control bg-light" required>
                <label for="userpassword" class="form-label text-light">الرمز السري</label>
                <div class="input-group">
                    <input type="password" name="password" id="userpassword" class="form-control bg-light" required>
                    <span class="input-group-text">
                        <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">عرض</button>
                    </span>
                </div>
                
                <input type="submit" name="login" class="btn btn-outline-info mt-3" value="تسجيل الدخول">
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("userpassword");
            var toggleButton = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.textContent = "إخفاء";
            } else {
                passwordInput.type = "password";
                toggleButton.textContent = "عرض";
            }
        }
    </script>
</body>
</html>
