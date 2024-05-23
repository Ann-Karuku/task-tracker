<?php

$conn = mysqli_connect("localhost", "root", "", "task_tracker");

// Check connection
if (!$conn) {
  echo "Connection Failed!";
}

$id = "";
$Officer_Name = "";
$Officer_Designation = "";
$Department = "";
$Officer_Contact = "";
$Officer_Code = "";
$Password = "";
$Remarks = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET["id"])) {
        header("location: addofficer.php");
        exit;
    }

    $id = $_GET["id"];

    $sql = "SELECT * FROM officers WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: home_page.php");
        exit;
    }
    $Officer_Name = $row['Officer_Name'];
    $Officer_Designation = $row['Officer_Designation'];
    $Department = $row['Department'];
    $Officer_Contact = $row['Officer_Contact'];
    $Officer_Code = $row['Officer_Code'];
    $Password = $row['Password'];
    $Remarks = $row['Remarks'];
} else {
    $Officer_Name = $_POST['Officer_Name'];
    $Officer_Designation = $_POST['Officer_Designation'];
    $Department = $_POST['Department'];
    $Officer_Contact = $_POST['Officer_Contact'];
    $Officer_Code = $_POST['Officer_Code'];
    $Password = $_POST['Password'];
    $Remarks = $_POST['Remarks'];

    do {
        if (empty($id) || empty($Officer_Name) || empty($Officer_Designation) || empty($Department) || empty($Officer_Contact) || empty($Officer_Code) || empty($Password) || empty($Remarks)) {
            $errorMessage = "All Fields are Required";
            break;
        }
        $sql = "UPDATE officers " .
            "SET Officer_Name = '$Officer_Name', Officer_Designation = '$Officer_Designation', Department = '$Department', Officer_Contact = '$Officer_Contact', Officer_Code = '$Officer_Code', Password = '$Password', Remarks = '$Remarks' " .
            "WHERE id = $id";

        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $successMessage = "Officer Updated Correctly";

        header("location: home_page.php");
        exit;
    } while (true);
}

session_start();
$officer_name = $_SESSION['officer_name'];

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
                <img src="assets/images/pic-1.png" alt="" class="image-responsive">
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
                             <!-- display the error -->
                            <?php if (isset($_GET['error'])) { ?>
                                <p class="error"><?php echo $_GET['error']; ?></p>
                            <?php } ?>

                            <!-- Display success message -->
                            <?php if (isset($_GET['success'])) { ?>O
                                        <p class="success"><?php echo $_GET['success']; ?></p>
                            <?php } ?>
            <form action= "create_officer.php" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo $id; ?>">
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
                            <input type="number" name="Officer_Code" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Password</label>
                            <input type="text" name="Password" class="form-control">
                        
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
                <input type="reset" value="Clear" class="btn btn-warning">
            </form>
        </div>
    </main>
    <footer>
        <marquee behavior="alternate" direction="">
            &copy; 2023 All Right Reserved <span>Developed By Omar, James, Sharon, Anthony, Faith and Cynthia @2024 By Ann, Deity, Charity, Delron, Brayo, Keziah & Daniel</span>
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