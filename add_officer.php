<?php
session_start();
$officer_name=$_SESSION['officer_name'];
$officer_code=$_SESSION['officer_code'];
// Check if session variables are set
if (!isset !isset($_SESSION['officer_code']) || !isset($_SESSION['officer_name'])) {
    // If not set, redirect to login page
    header("Location: index.php?error=Please log in to access this page!");
    exit();
}

include_once "db_conn.php";

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
                <a href="tasks.php" class="link"><span class="feather icon-chevron-right"></span><span>View Tasks</span></a>
            </div>
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
            <a href="account.php" class="link"><span class="feather icon-user"></span><span>Account Settings</span></a>
        </div>
    </aside>
    <main class="content">
        <div class="content-header">
            <div class="title">
                <h4>Officer</h4>
            </div>
            <div class="navigation">
                <span><a href="home_page.php"><i class="feather icon-home"></i></a></span>
                <span>/</span>
                <span class="text-fade">Add Officer</span>
            </div>
        </div>
        <div class="content-body">
                             <!-- display the error -->
                            <?php if (isset($_GET['error'])) { ?>
                                <p class="error"><?php echo $_GET['error']; ?></p>
                            <?php } ?>

                            <!-- Display success message -->
                            <?php if (isset($_GET['success'])) { ?>
                                        <p class="success"><?php echo $_GET['success']; ?></p>
                            <?php } ?>
            <form action= "create_officer.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Name</label>
                            <input type="text" class="form-control" name="Officer_Name" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Designation</label>
                            <select name="Officer_Designation" id="" class="form-control" required> 
                                            <option >----select user type---</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Officer">Officer</option>
                                        </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Department</label>
                            <input type="text" class="form-control" name="Department" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Contact</label>
                            <input type="number"name="Officer_Contact"class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Code</label>
                            <input type="number" name="Officer_Code" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Password</label>
                            <input type="text" name="Password" class="form-control" required>
                        
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Remarks</label>
                            <input type="text" name="Remarks" class="form-control">
                        
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Passport photo</label>
                              <input type="file" name="image" class="form-control">
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
            &copy; 2023 All Right Reserved <span>Developed By Omar, James, Sharon, Anthony, Faith and Cynthia @2024 By Ann, Deity, Charity, Delron, Brian, Keziah & Daniel </span>
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
</body>
</html>
