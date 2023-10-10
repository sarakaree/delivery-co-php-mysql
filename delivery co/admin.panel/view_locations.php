<!-- view_locations.php -->
<?php
// Database connection
$con = mysqli_connect('localhost', 'root', '', 'delivery');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch all locations from the "locations" table
$select_query = "SELECT * FROM `locations`";
$result = mysqli_query($con, $select_query);

$locations = array();
while ($row = mysqli_fetch_assoc($result)) {
    $locations[] = $row;
}

$con->close();
?>

<!-- HTML to display locations in a table -->
<html>
<head>
    <!-- Add your CSS and other head content here -->
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file for styling -->
</head>
<body>
    <h1 class="text-center">All Locations</h1>
    <table class="table table-bordered mt-5">
        <thead class="bg-secondary text-light">
            <tr>
                <th>Location ID</th>
                <th>Location Name</th>
            </tr>
        </thead>
        <tbody class="bg-light text-dark">
            <?php foreach ($locations as $location) { ?>
                <tr>
                    <td><?php echo $location['location_id']; ?></td>
                    <td><?php echo $location['location_name']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
