<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">

<h1 class="class text-center">All Employees</h1>
<table class="table table-bordered mt-5">
    <thead class="class bg-secondary text-light">
        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Role</th>
            <th>Password</th>
            <th>Locations</th>
            <th>Edit</th>
        </tr>
    </thead>

    <tbody class="bg-light text-dark">
        <?php
        // Define an array to store results from each role table
        $employeeData = array();

        // Database connection (modify with your database credentials)
        $con=mysqli_connect('localhost','root','','delivery');

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $employeeCounter = 1;

        // Query and fetch employees from each role table
        $roleTables = array('receiving rep.', 'trackers', 'delivery_rep', 'sorting_off');

        foreach ($roleTables as $roleTable) {
            $query = "SELECT * FROM `$roleTable`";
            $result = mysqli_query($con, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Add the role as a key to distinguish employees from different tables
                    $row['role'] = $roleTable;
                    $employeeData[] = $row;
                }
            }
        }

        // Loop through the combined employee data and display it in the table
        foreach ($employeeData as $employee) {
            
            $employee_name = $employee['employee_name'];
            $role = $employee['role'];
            $password = $employee['password'];
            $locations = isset($employee['locations']) ? $employee['locations'] : ''; // Check if 'locations' key exists

            echo "<tr class='text-center'>";
            echo "<td>$employeeCounter</td>";
            echo "<td>$employee_name</td>";
            echo "<td>$role</td>";
            echo "<td>$password</td>";
            echo "<td>$locations</td>";
            echo "<td><a href='admin.php?editemployee='' class='text-dark'><i class='fas fa-edit'></i></a></td>";
            $employeeCounter++;
            echo "</tr>";
        }

        // Close the database connection
        mysqli_close($con);
        ?>
    </tbody>
</table>










       <!-- <tr class="text-center" >
            <td>hiiiiii</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><a href="" class="text-dark"><i class="fas fa-edit"></i></a></td>
            <td><a href="" class="text-dark"><i class="fa-solid fa-square-minus"></i></i></a></td>

         </tr> -->

     </tbody>

</table>