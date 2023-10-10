<?php
session_start();
$con=mysqli_connect('localhost','root','','delivery'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform database query to validate credentials
    $query = "SELECT * FROM `receiving rep.` WHERE `employee_name` = ? AND `password` = ?";
    $stmt = mysqli_prepare($con, $query);
    
    if ($stmt === false) {
        die("Prepare failed: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    $success = mysqli_stmt_execute($stmt);
    
    if ($success === false) {
        die("Execute failed: " . mysqli_error($con));
    }

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            // Valid credentials,session variables
            $_SESSION['rep_id'] = $row['rep_id'];
            $_SESSION['employee_name'] = $row['employee_name'];
            $_SESSION['rep_locations'] = $row['locations'];

            echo $_SESSION['rep_id'];


            // Redirect to the orders display page
            header("Location: orders.php");
            exit();
        } else {
            
            echo "Invalid username or password.";
        }
    } else {
       
        echo "Error fetching result.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>واجهة مندوب الاستلام</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="rep_login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>

