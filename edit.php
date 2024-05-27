<?php
session_start();
// Check if the session variable is set
if (!isset($_SESSION['officer_name'])) {
    // Redirect the user to the login page or handle the session error
    header("Location: login.php");
    exit(); // Stop further execution
}

// Include or require your database connection file
include "db_conn.php"; // Adjust the filename as needed

// Check if ID is provided and is a valid integer
if (!empty($_GET["id"]) && is_numeric($_GET["id"])) {
    // Retrieve the officer ID from the URL
    $id = $_GET["id"];

    // Prepare and execute the SQL query using prepared statements
    $sql = "SELECT * FROM officers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the officer details
    if ($row = $result->fetch_assoc()) {
        // Officer details found
    } else {
        // Redirect or display an error message if officer ID doesn't exist
        header("Location: error.php");
        exit();
    }
} else {
    // Redirect or display an error message if ID is missing or invalid
    header("Location: error.php");
    exit();
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
        </div>
        <div class="profile-tab">
            <div class="profile-photo">
                <img src="assets/images/pic-1.png" alt="" class="image-responsive">
            </div>
            <div class="profile-description">
                <span><?php echo $_SESSION['officer_name']; ?></span>
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
            <a href="#" class="link"><span class="feather icon-user"></span><span>Account Settings</span></a>
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
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>

            <form action="create_officer.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Name</label>
                            <input type="text" class="form-control" name="Officer_Name" value="<?php echo $row['Officer_Name'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Designation</label>
                            <select name="Officer_Designation" id="" class="form-control">
                                <!-- Populate options here -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Department</label>
                            <input type="text" class="form-control" name="Department" value="<?php echo $row['Department'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Contact</label>
                            <input type="number" name="Officer_Contact" class="form-control" value="<?php echo $row['Officer_Contact'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Code</label>
                            <input type="number" name="Officer_Code" class="form-control" value="<?php echo $row['Officer_Code'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Password</label>
                            <input type="text" name="Password" class="form-control" value="<?php echo $row['Password'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Remarks</label>
                            <input type="text" name="Remarks" class="form-control" value="<?php echo $row['Remarks'] ?>">
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
                <input type="reset" value="Clear" class="btn btn-warning">
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
        $(document).ready(() => {
            // JavaScript code here
        });
        $('.preloader').fadeOut('slow', function () {
            $(this).remove()
        }).delay(100);
    </script>
</body>
</html>
