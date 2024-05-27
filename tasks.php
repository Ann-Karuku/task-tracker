<?php
session_start();
include "db_conn.php";

// Check if the role is set in session
$role = $_SESSION['user_type'];

if ($role == '----select user type---') {
    // If not, redirect back to the login page
    header("Location: index.php?error=Please select user type!");
    exit();
}

// Retrieve the role from session
$officer_name = $_SESSION['officer_name'];

// Check if delete request is made
if(isset($_GET['ID'])) {
    $Task_ID= $_GET['ID'];
    $sql_delete = "DELETE FROM `tasks` WHERE Task_ID= $Task_ID";

    if(mysqli_query($conn, $sql_delete)) {
        header("Location:tasks.php?error=Task deleted successfully.!"); 
    } else {
        header("Location:tasks.php?error=Error deleting Task:".mysqli_error($conn)); 
    }
}

// Fetch tasks from the database
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
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
            <a href="index.php" class="navbar-brand">
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
                <span><?php echo $officer_name ?></span>
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
                <a href="tasks.php" class="link"><span class="feather icon-chevron-right"></span><span>View Officer</span></a>
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
                <span class="text-fade">View Task</span>
            </div>
        </div>
        <div class="content-body">
            <table id="table_id" width="100%" class="cell-border hover nowrap">
                <thead>
                      <!-- display the error -->
                      <?php if (isset($_GET['error'])) { ?>
                                <p class="error"><?php echo $_GET['error']; ?></p>
                            <?php } ?>

                            <!-- Display success message -->
                            <?php if (isset($_GET['success'])) { ?>
                                        <p class="success"><?php echo $_GET['success']; ?></p>
                            <?php } ?>
                    <tr>
                        <th>Date</th>
                        <th>Office N0</th>
                        <th>Department</th>
                        <th>Support Request</th>
                        <th>Support Given</th>
                        <th>Supporting Officer</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                //To tell you when no officers are in the DB
					if (mysqli_num_rows($result)==0) {
							echo '<span style="color:#0066cc;">There are no tasks.</span>';
						}
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Office_NO']); ?></td>
                                <td><?php echo htmlspecialchars($row['Department']); ?></td>
                                <td><?php echo htmlspecialchars($row['Support_Request']); ?></td>
                                <td><?php echo htmlspecialchars($row['Support_Given']); ?></td>
                                <td><?php echo htmlspecialchars($row['Officer_Code']); ?></td>
                                <td><?php echo htmlspecialchars($row['Remarks']); ?></td>
                                <td>
                                    <a href="#" class="btn btn-primary"><i class="feather icon-edit"></i></a>
                                    <a href="?ID=<?php echo $row['Task_ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="feather icon-trash-2"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                </tbody>
            </table>
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

    function checkDelete(){
      return confirm('Are you sure?');
      }


        $(document).ready(function () {
            $('#table_id').DataTable({
                scrollX: true,
                scrollCollapse: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ]
            });

            $('.preloader').fadeOut('slow', function () {
                $(this).remove();
            }).delay(100);
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
