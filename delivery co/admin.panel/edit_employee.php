<?php
$con=mysqli_connect('localhost','root','','delivery');
if (isset($_GET['editemployee'])) {
    $edit_id = $_GET['editemployee'];
    
    // Selecting the appropriate role table based on the employee ID
    $roleTables = array(
        'receiving_rep' => 'receiving_id',
        'trackers' => 'tracker_id',
        'delivery_rep' => 'delivery_id',
        'sorting_off' => 'sorting_id'
    );

    foreach ($roleTables as $roleTable => $id_col) {
        $get_employee_info = "SELECT * FROM `$roleTable` WHERE $id_col=?";
        $stmt = mysqli_prepare($con, $get_employee_info);
        mysqli_stmt_bind_param($stmt, "i", $edit_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $employee_name = $row['employee_name'];
            $password = $row['password'];
            $locations = isset($row['locations']) ? $row['locations'] : null;
            $role = $roleTable;
        }
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
    <h1 class="text-center">تعديل الموظف</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline mb-4">
            <label for="employee_name" class="form-label">اسم الموظف</label>
            <input type="text" name="employee_name" id="employee_name" value="<?php echo $employee_name; ?>" class="form-control bg-light" required>

            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" name="password" id="password" value="<?php echo $password; ?>" class="form-control bg-light" required>

            <?php if ($role === 'receiving_rep') { ?>
                <div id="locations_div">
                    <label for="locations">المواقع</label>
                    <select name="locations[]" id="locations" class="form-control bg-light" multiple>
                        <?php
                        $select_query = "SELECT * FROM `locations`";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $location_id = $row['location_id'];
                            $location_name = $row['location_name'];
                            $selected = (isset($locations) && in_array($location_id, explode(',', $locations))) ? 'selected' : '';
                            echo "<option value='$location_id' $selected>$location_name</option>";
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>

            <input type="submit" name="update" class="btn-outline-info text-dark mt-3">
        </div>
    </form>
</div>

<!-- submitting the update -->
<?php
if (isset($_POST['update'])) {
    $employee_name = $_POST['employee_name'];
    $password = $_POST['password'];

    // Concatenate selected locations if any
    $selected_locations = isset($_POST['locations']) ? implode(',', $_POST['locations']) : null;

    $update_query = "UPDATE `$role` SET employee_name=?, password=?, locations=? WHERE $id_col=?";
    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "sssi", $employee_name, $password, $selected_locations, $edit_id);
    mysqli_stmt_execute($stmt);

    // After successful update
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<script>alert('Employee updated successfully')</script>";

        // Redirect to another page
        header("Location: view_employees.php");
        exit; // Make sure to exit the script
    }
}
?>
</body>
</html>


