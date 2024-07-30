<!-- view_officer.php -->
<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['user_type']) || !isset($_SESSION['officer_code']) || !isset($_SESSION['officer_name'])) {
    // If not set, redirect to login page
    header("Location: index.php?error=Please log in to access this page!");
    exit();
}

$officer_code=$_SESSION['officer_code'];
$officer_name=$_SESSION['officer_name'];
$role = $_SESSION['user_type'];

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
                <h4>Change Pasword</h4>
            </div>
            <div class="navigation">
                <span><a href="index.php"><i class="feather icon-home"></i></a></span>
                <span>/</span>
                <span class="text-fade">Change Pasword</span>
            </div>
        </div>

        <div class="content-body">
    <div class="row justify-content-center">
                             <!-- display the error -->
                            <?php if (isset($_GET['error'])) { ?>
                                <p class="error"><?php echo $_GET['error']; ?></p>
                            <?php } ?>

                            <!-- Display success message -->
                            <?php if (isset($_GET['success'])) { ?>
                                        <p class="success"><?php echo $_GET['success']; ?></p>
                            <?php } ?>
        <form action="change_pass_val.php" method="post" >
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="" class="form-control-label">Current Password</label>
                            <input type="password" name="Current_Password" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="form-control-label">New Password</label>
                            <input type="password" name="New_Password" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="form-control-label">Repeat New Password</label>
                            <input type="password" name="Repeat_New_Password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Change" name="submit" class="btn btn-primary">
                            <a href="account.php" class="btn btn-warning">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

   
    </main>
    <footer>
    <marquee behavior="alternate" direction="">
    &copy; @2023 All Right Reserved <span>Developed By Omar, James, Sharon, Anthony, Faith & Cynthia, @2024 Developed By Ann, Deity, Charity, Delron, Brian, Keziah, BrianRop,Faith & Daniel </span>
        </marquee>
    </footer>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(()=>{
            $('#table_id').DataTable({
                scrollX: true,
                scrollCollapse: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ]
            });

            $('.preloader').fadeOut('slow', function(){
                $(this).remove()
            }).delay(100)
        })
    </script>
</body>
</html>
