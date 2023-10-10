<!DOCTYPE html>
<html>


<?php
// Start a session
session_start();

// connect to the database (replace with your database connection code)
$con=mysqli_connect('localhost','root','','delivery');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve the hashed password from the database
    $select_query = "SELECT * FROM admins WHERE admin_name='$username'";
    $result = mysqli_query($con, $select_query);

    if ($row = mysqli_fetch_assoc($result)) {
        $hashed_password = $row['admin_password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Admin credentials are correct, set session variables
            $_SESSION['admin_id'] = $row['admin_id']; // the data of $_row should be the same names of the table cols
            $_SESSION['admin_username'] = $row['admi_name'];

            // Redirect to the admin panel
            header('Location:admin.php');
            exit();
        } else {
            // Incorrect password, redirect to login page with an error message
            echo "<script>alert('error')</script>";
            //$_SESSION['login_error'] = 'Invalid username or password';
            header('Location: admin_register.php');
            exit();
        }
    } else {
        // Admin not found, redirect to login page with an error message
        echo "<script>alert('admin not found')</script>";
        $_SESSION['login_error'] = 'Admin not found';
        header('Location: admin_register.php');
        exit();
    }
}
?>




<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="sb-nav-fixed bg-secondary">
    <div class="container mt-2">
        <h1 class="text-center text-light">admin Log In</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-outline mb-4">
                <label for="username" class="form-label text-light">User Name</label>
                <input type="text" name="username" id="username" class="form-control bg-light" required>
                <label for="userpassword" class="form-label text-light">User Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="userpassword" class="form-control bg-light" required>
                    <span class="input-group-text">
                        <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">Show</button>
                    </span>
                </div>
                <input type="submit" name="login" class="btn btn-outline-info  mt-3" value="Log In">
                <br>
                
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


