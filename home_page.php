<?php
session_start();

    // Retrieve the role from session
    $role = $_SESSION['user_type'];

    // Check if the role is set in session
    if($role=='----select user type---'){
        // If not, redirect back to the login page
        header("Location: index.php?error=Please select user type!");
    }
        // Retrieve the name from session
    $officer_name=$_SESSION['officer_name'];

 
if(isset($_GET['logout'])) {
    // Destroy session
    session_destroy();
    // Redirect to login page
    header("Location: index.php");
    exit; // Ensure script stops executing after redirection
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Tracker</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/icons/feather/css/feather.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.css">

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
                <img src="assets/images/pic-1.png" alt="profilepic" class="image-responsive">
            </div>
            <div class="profile-description">
                <span><?php echo $officer_name?></span>
                <a href="logout.php"><span class="feather icon-power text-danger"></span></a>
            </div>
        </div>
    </header>

    <aside class="sidebar">
        <div class="sidebar-header">
            <span class="text-fade">navigation</span>
        </div>
        <div class="sidebar-menu">
            <a href="home_page.php" class="link"><span class="feather icon-home"></span><span>Dashboard</span></a>
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
                    <h4>ICT DEPARTMENT TECHNICAL SUPPORT REGISTER</h4>
                    <h2>Welcome</h2>
                     <p>You are logged in as <?php echo $role; ?>.</p>      
                </div>
            </div>
        </div>
    </main>
    <footer>
    <marquee behavior="alternate" direction="">
            &copy; 2023 All Right Reserved <span>Developed By Omar, James, Sharon, Anthony, Faith & Cynthia</span><br>
            &copy; 2024 All Right Reserved <span>Developed By Ann, Deity, Charity, Delron, Brian, Faith, Keziah & Daniel </span>
        </marquee>
    </footer>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(()=>{})
        $('.preloader').fadeOut('slow', function(){
            $(this).remove()
        }).delay(100)
    </script>
</body>
</html>