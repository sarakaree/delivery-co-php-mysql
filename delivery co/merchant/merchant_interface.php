<?php
// Start a session
session_start();

// Check if the user is logged in as a merchant
if (!isset($_SESSION['merchant_id'])) {
    // Redirect to login page if not logged in
    header('Location: merchant_register.php');
    exit();
}

// User is logged in, display merchant panel content
$merchantName = $_SESSION['merchant_name']; // Retrieve the merchant's name
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <?php
         include('../connection.php');
         ?>
    </head>
    <title>
        واجهة التاجر
      </title>

    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <body class="sb-nav-fixed">

     <!--font awesome-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

     





     
        

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">
                <!-- Inside your navbar, display the welcome message with the merchant's name -->
                <div class="text-light">
                مرحبًا، <?php echo $merchantName; ?>!
                </div>
                
            </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <div class="text-end">
          <a href="merchant_login.php" class="btn btn-outline-light">تسجيل دخول</a>

          <a href="merchant_register.php" class="btn btn-outline-light" style="background-color: purple">تسجيل</a>
          <a href="merchant_logout.php" class="btn btn-outline-light">تسجيل خروجt</a>
        </div>
            </ul>
            

            

        </nav>
        <br>
       

        
      <div class="class row">
        <div class="col-md-2 bg-dark">
            <ul>
                <br>
                <li class="nav-item bg-dark">
                    <a href="merchant_interface.php?insertorders" class="btn btn-outline-info text-light">اضافة طلبات</a>
                </li>
                <br>
                <li class="nav-item bg-dark">
                    <a href="merchant_interface.php?vieworders" class="btn btn-outline-info text-light">مشاهدة الطلبات</a>
                </li>
                <br>

                <li class="nav-item bg-dark">
                    <a href="merchant_interface.php?recivedorders" class="btn btn-outline-info text-light">الطلبات التي تم تسليمها</a>
                </li>
                <br>

               

               
            
            </ul>
        </div>
            <div class="class col-md-10">
              <?php
              if(isset($_GET['insertorders'])){
               include('insert_orders.php');
              } 
               ?>
               <?php
              if(isset($_GET['vieworders'])){
               include('view_orders.php');
              } 
               ?>

              <?php
              if(isset($_GET['editorder'])){
               include('edit_order.php');
              } 
               ?>
               
               <?php
              if(isset($_GET['deleteorder'])){
               include('delete_order.php');
              } 
               ?>





            </div>
     </body>
    

</html>