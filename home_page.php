<?php
session_start();
include "db_conn.php";

// Check if session variables are set
if (!isset($_SESSION['user_type']) || !isset($_SESSION['officer_code']) || !isset($_SESSION['officer_name'])) {
    // If not set, redirect to login page
    header("Location: index.php?error=Please log in to access this page!");
    exit();
}

    // Retrieve from session
    $role = $_SESSION['user_type'];
    $officer_code=$_SESSION['officer_code'];
    $officer_name=$_SESSION['officer_name'];

    // Check if the role is set in session
    if($role=='----select user type---'){
        // If not, redirect back to the login page
        header("Location: index.php?error=Please select user type!");
    }

    $sql="SELECT * FROM `officers` WHERE Officer_Code='$officer_code'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);

    
    mysqli_close($conn);
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Tracker</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/icons/feather/css/feather.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="index.css">

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.js"></script>
</head>
<body>
    <div class="preloader"></div>
    
    <header class="header">
        <div class="title-tab">
            <a href="home_page.php" class="navbar-brand">
                <div class="icon">
                    <img src="assets/images/arms.png" alt="">
                </div>
                <div class="title-text">ICT Task Tracker</div>
            </a>
            <!--<div class="screen">
                <span class="feather icon-maximize scre"></span>
            </div>-->
        </div>
        <div class="profile-tab">
            <div class="profile-photo">
            <?php
            if($row['Profile_Pic']) {
            echo '<img src="assets/uploads/'.$row['Profile_Pic'] . '"">';
        } else {
        echo '<img src="assets/images/pic-5.jpg">';
        }
        ?>
            </div>
            <div class="profile-description">
                <span><?php echo $officer_name?></span>
                <a href="logout.php" id="logoutButton"><span class="feather icon-power text-danger"></span></a>
            </div>
        </div>
    </header>

    <aside class="sidebar">
        <div class="sidebar-header">
            <span class="text-fade">navigation</span>
        </div>
        <div class="sidebar-menu">
            <a href="home_page.php" class="link"><span class="feather icon-home"></span><span>Dashboard</span></a>
            <a href="about_us.php" class="link"><span class="feather icon-info"></span><span>About Us</span></a>
            <div class="drop">
                <span>
                    <span class="feather icon-clipboard"></span>
                    <span>Task</span>
                </span>
                <span class="feather icon-chevron-right"></span>
            </div>
            <div class="drop-content">
                <a href="add_task.php" class="link"><span class="feather icon-chevron-right"></span><span>New Task</span></a>
                <a href="tasks.php" class="link"><span class="feather icon-chevron-right"></span><span>View Task</span></a>
            </div>
            <?php if ($role === 'Admin'): ?>
            <div class="drop">
                <span>
                    <span class="feather icon-users"></span>
                    <span>Officers</span>
                </span>
                <span class="feather icon-chevron-right"></span>
            </div>
            <div class="drop-content">
            
                <a href="add_officer.php" class="link"><span class="feather icon-chevron-right"></span><span>New Officer</span></a>
                <a href="officers.php" class="link"><span class="feather icon-chevron-right"></span><span>View Officers</span></a>
                </div>
            <?php endif; ?>
                
                
            
            <a href="account.php" class="link"><span class="feather icon-user"></span><span>Account Settings</span></a>
        </div>
    </aside>
    <main class="content">
        <div class="content-header">
            <div class="title">
                <h4>Dashboard</h4>
            </div>
            <div class="navigation">
                <span><a href="home_page.php"><i class="feather icon-home"></i></a></span>
                <span>/</span>
                <span class="text-fade">Dashboard</span>
            </div>
        </div>
        <div class="content-body">
            <div class="banner">
                <div class="banner-text">
                    <h1>MINISTRY OF INVESTMENTS, TRADE & INDUSTRY</h1>
                    <h2>STATE DEPARTMENT FOR TRADE</h2>
                    <h4>ICT DEPARTMENT TECHNICAL SUPPORT</h4>
                    <h2>Welcome</h2>
                     <p>You are logged in as <?php echo $role; ?>.</p>      
                </div>
                <div class="container-cont">
            <div class="wrapper-cont">
                <img src="assets/images/Team.jpg" alt="">
                <img src="assets/images/Team1.jpg" alt="">
                <img src="assets/images/Team2.jpg" alt="">
                <img src="assets/images/Team3.jpg" alt="">
                <img src="assets/images/Team4.jpg" alt="">
                <img src="assets/images/Team5.jpg" alt="">
                <img src="assets/images/Team6.jpg" alt="">
            </div>
        </div>
            </div>
        </div><br>
    <div class="head-1">
            <h2>Meet Our Team</h2>
        </div>
    </div>    
    </main>
    <footer>
    <marquee behavior="alternate" direction="">
    &copy; @2024 All Rights Reserved 
        </marquee>
    </footer>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(()=>{})
        $('.preloader').fadeOut('slow', function(){
            $(this).remove()
        }).delay(100)
    </script>
     <script>
    document.getElementById('logoutButton').onclick = function() {
     var confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
        // Redirect to logout page or call your PHP logout script
        window.location.href = 'logout.php'; 
        }
        };
  </script>
</body>
</html>