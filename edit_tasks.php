<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['officer_code']) || !isset($_SESSION['officer_name'])) {
    // If not set, redirect to login page
    header("Location: index.php?error=Please log in to access this page!");
    exit();
}


$officer_name=$_SESSION['officer_name'];

include_once "db_conn.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $task_id = intval($_GET['id']);

    $query = "SELECT * FROM tasks WHERE Task_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "Task not found!";
        exit;
    }
} else {
    echo "Invalid Request!";
    exit;
}

if (isset($_POST['update'])) {
    $date = $_POST['date'];
    $office_no = $_POST['office_no'];
    $department = $_POST['department'];
    $support_request = $_POST['support_request'];
    $support_given = $_POST['support_given'];
    $officer_code = $_POST['officer_code'];
    $remarks = $_POST['remarks'];

    $update_query = "UPDATE tasks SET Date = ?, Office_NO = ?, Department = ?, Support_Request = ?, Support_Given = ?, Officer_Code = ?, Remarks = ? WHERE Task_ID = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssi", $date, $office_no, $department, $support_request, $support_given, $officer_code, $remarks, $task_id);

    if ($stmt->execute()) {
        header("Location: tasks.php?success=Task updated successfully");
        exit;
    } else {
        echo "Error updating task: " . $stmt->error;
    }
}

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
                <a href="officers.php" class="link"><span class="feather icon-chevron-right"></span><span>View Officer</span></a>
            </div>

            <a href="account.php" class="link"><span class="feather icon-user"></span><span>Account Settings</span></a>
        </div>
    </aside>
    <main class="content">
        <div class="content-header">
            <div class="title">
                <h4>Edit Task</h4>
            </div>
            <div class="navigation">
                <span><a href="index.php"><i class="feather icon-home"></i></a></span>
                <span>/</span>
                <span class="text-fade">Edit Task</span>
            </div>
        </div>
        <div class="content-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="date" class="form-control-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="<?php echo htmlspecialchars($task['Date']); ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="office_no" class="form-control-label">Office Number</label>
                            <input type="text" name="office_no" class="form-control" value="<?php echo htmlspecialchars($task['Office_NO']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="department" class="form-control-label">Department</label>
                            <input type="text" name="department" class="form-control" value="<?php echo htmlspecialchars($task['Department']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="support_request" class="form-control-label">Support Request</label>
                            <textarea name="support_request" id="support_request" cols="30" rows="6" class="form-control" required><?php echo htmlspecialchars($task['Support_Request']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="support_given" class="form-control-label">Support Given</label>
                            <textarea name="support_given" id="support_given" cols="30" rows="6" class="form-control" required><?php echo htmlspecialchars($task['Support_Given']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="remarks" class="form-control-label">Remarks</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="6" class="form-control" required><?php echo htmlspecialchars($task['Remarks']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="officer_code" class="form-control-label">Supporting Officer Code</label>
                            <input type="text" name="officer_code" class="form-control" value="<?php echo htmlspecialchars($task['Officer_Code']); ?>" required readonly>
                        </div>
                    </div>
                </div>
                <input type="submit" name="update" value="Update Task" class="btn btn-primary">
                <a href="tasks.php" class="btn btn-warning">Cancel</a>
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
        $(document).ready(function() {
            $('.preloader').fadeOut('slow', function() {
                $(this).remove()
            }).delay(100);
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>