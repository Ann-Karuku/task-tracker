<?php
session_start();
include_once "db_conn.php";

// Check if the role is set in session
    $role = $_SESSION['user_type'];
    // Check if session variables are set
if (!isset($_SESSION['user_type']) ) {
    // If not set, redirect to login page
    header("Location: index.php?error=Please log in to access this page!");
    exit();
}

    if($role=='----select user type---'){
        // If not, redirect back to the login page
        header("Location: index.php?error=Please select user type!");
    }
        // Retrieve the role from session
    $officer_name=$_SESSION['officer_name'];
    $officer_code=$_SESSION['officer_code'];
   
    $sql="SELECT * FROM `officers` WHERE Officer_Code='$officer_code'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);

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

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.js"></script>
</head>
<body>
    <div class="preloader"></div>

    <header class="header">
        <div class="title-tab">
            <a href="index.php" class="navbar-brand">
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
                <a href="officers.php" class="link"><span class="feather icon-chevron-right"></span><span>View Officer</span></a>
            </div>
            <?php endif; ?>

            <a href="account.php" class="link"><span class="feather icon-user"></span><span>Account Settings</span></a>
        </div>
    </aside>
    <main class="content">
        <div class="content-header">
            <div class="title">
                <h4>Task</h4>
            </div>
            <div class="navigation">
                <span><a href="index.php"><i class="feather icon-home"></i></a></span>
                <span>/</span>
                <span class="text-fade">Add Task</span>
            </div>
        </div>
        <div class="content-body">
        <form action="new_task.php" method="post">
                <div class="row">
                    <div class="col-md-4 mb-3">
                       <div class="form-group">
                            <label for="date" class="form-control-label">Date</label>
                            <input type="date" name="Date" id="date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="office_number" class="form-control-label">Office Number</label>
                            <input type="text" name="Office_Number" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="department" class="form-control-label">Department</label>
                            <input type="text" name="Department" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="support_requested" class="form-control-label">Support Requested For</label>
                            <textarea name="Support_Requested_For" id="support_requested" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="support_given" class="form-control-label">Support Given</label>
                            <textarea name="Support_Given" id="support_given" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="remarks" class="form-control-label">Remarks</label>
                            <textarea name="Remarks" id="remarks" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Supporting Officer Code</label>
                            <input type="text" class="form-control" name="Supporting_Officer_Code" value="<?php echo $officer_code?>" required readonly>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Clear" class="btn btn-warning" id="clearButton">
            </form>
        </div>
    </main>
    <footer>
    <marquee behavior="alternate" direction="">
    &copy; @2023 All Right Reserved <span>Developed By Omar, James, Sharon, Anthony, Faith & Cynthia, @2024 Developed By Ann, Deity, Charity, Delron, Brian, Keziah, BrianRop,Faith & Daniel </span>
        </marquee>
    </footer>
    <script src="assets/js/custom.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        });

        $(document).ready(function() {
            $('.preloader').fadeOut('slow', function() {
                $(this).remove()
            }).delay(100);
        });
    </script>
    <script>
              // JavaScript to clear inputs
        document.addEventListener("DOMContentLoaded", function() {
            var clearButton = document.getElementById('clearButton');
            var inputs = document.querySelectorAll('input[type="text"], input[type="email"]');
            clearButton.addEventListener('click', function() {
                inputs.forEach(function(input) {
                    input.value = '';
                });
            });
        });
    </script>
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