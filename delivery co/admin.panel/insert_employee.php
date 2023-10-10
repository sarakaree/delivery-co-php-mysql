<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {

    $employee_name = $_POST['employee_name'];
    $employee_password = $_POST['password'];
    $role = $_POST['role'];

    // Database connection
    $con = mysqli_connect('localhost', 'root', '', 'delivery');

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Prepare the SQL statement based on the selected role
    $sql = "";

    switch ($role) {
        case 'receiving_rep':
            $sql = "INSERT INTO `receiving_rep` (`employee_name`, `password`, `locations`) VALUES (?, ?, ?)";
            break;
        case 'trackers':
            $sql = "INSERT INTO `trackers` (`employee_name`, `password`) VALUES (?, ?)";
            break;
        case 'delivery_rep':
            $sql = "INSERT INTO `delivery_rep` (`employee_name`, `password`,`locations`) VALUES (?, ?, ?)";
            break;
        case 'sorting_off':
            $sql = "INSERT INTO `sorting_off` (`employee_name`, `password`) VALUES (?, ?)";
            break;
        default:
            echo "Invalid role selected.";
            break;
    }

    if (!empty($sql)) {
        // Bind parameters based on the selected role
        if ($role === 'receiving_rep' || $role === 'delivery_rep') {
            // Get selected locations (up to 3)
            $selected_locations = isset($_POST['locations']) ? $_POST['locations'] : array();

            // Limit the number of selected locations to 3
            $selected_locations = array_slice($selected_locations, 0, 3);

            // Convert the selected locations to a comma-separated string
            $locations_str = implode(',', $selected_locations);

            // Bind parameters including locations
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sss", $employee_name, $employee_password, $locations_str);
        } else {
            // Bind parameters without locations
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ss", $employee_name, $employee_password);
        }

        if ($stmt->execute()) {
            echo "Employee added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Close the database connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>

<head>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="sb-nav-fixed">
    <div class="container mt-2">
        <h1 class="text-center">اضافة موظف</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-outline mb-4">
                <!-- (for ) and (id) should exactly the same-->
                <label for="employee_name" class="form-label">اسم الموظف</label>
                <input type="text" name="employee_name" id="employee_name" class="form-control bg-light" required>

                <label for="employee_password" class="form-label">الرمز السري</label>
                <input type="password" name="password" id="employee_password" class="form-control bg-light" required>

                <label for="role">الوظيفه:</label>
                <select name="role" id="role" class="form-control bg-light" required>
                    <option value="" disabled selected>اختر وظيفه</option>
                    <option value="receiving_rep">مندوب استلام</option>
                    <option value="trackers">مراقب</option>
                    <option value="delivery_rep">مندوب تسليم</option>
                    <option value="sorting_off">موظف فرز</option>
                </select>

                <!-- Select box for locations -->
                <div id="locations_div" style="display: none;">
                    <label for="locations">اختر المواقع (اختر حتى 3 مواقع)</label>
                    <select name="locations[]" id="locations" class="form-control bg-light" multiple>
                        <?php
                        // Fetch all locations initially
                        $con = mysqli_connect('localhost', 'root', '', 'delivery');

                        if ($con->connect_error) {
                            die("Connection failed: " . $con->connect_error);
                        }

                        $select_query = "SELECT * FROM `locations`";
                        $result_query = mysqli_query($con, $select_query);

                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $cat_name = $row['location_name'];
                            echo "<option value='$cat_name'>$cat_name</option>";
                        }

                        // Close the database connection
                        mysqli_close($con);
                        ?>
                    </select>
                </div>

                <input type="submit" name="submit" class="btn-outline-info text-dark mt-3">
            </div>
        </form>
    </div>

    <script>
        // Function to show/hide the locations select box based on the selected role
        document.getElementById('role').addEventListener('change', function () {
            var role = this.value;
            var locationsDiv = document.getElementById('locations_div');

            if (role === 'receiving_rep' || role === 'delivery_rep') {
                locationsDiv.style.display = 'block';
            } else {
                locationsDiv.style.display = 'none';
            }
        });
    </script>
</body>

</html>



