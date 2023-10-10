<!-- register.php -->


<!DOCTYPE html>
<html>

<?php
// connect to the database 
$con=mysqli_connect('localhost','root','','delivery');
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; 

    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    // Insert the admin into the database
    $insert_query = "INSERT INTO admins (admin_name, admin_password) VALUES ('$username', '$hashed_password')";
    mysqli_query($con, $insert_query);

    // Redirect to the login page after registration
    header('Location: admin_login.php');
    exit();
}
?>



<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="sb-nav-fixed bg-secondary">
    <div class="container mt-2">
        <h1 class="text-center text-light">admin registeration</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-outline mb-4">
                <label for="username" class="form-label text-light">Name</label>
                <input type="text" name="username" id="username" class="form-control bg-light" required>
                <label for="userpassword" class="form-label text-light">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="userpassword" class="form-control bg-light" required>
                    <span class="input-group-text">
                        <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">Show</button>
                    </span>
                </div>
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
