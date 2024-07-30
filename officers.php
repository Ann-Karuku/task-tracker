<!-- view_officer.php -->
<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['officer_code']) || !isset($_SESSION['officer_name'])) {
    // If not set, redirect to login page
    header("Location: index.php?error=Please log in to access this page!");
    exit();
}


$officer_name=$_SESSION['officer_name'];
$officer_code=$_SESSION['officer_code'];

include_once "db_conn.php";

$sql="SELECT * FROM `officers` WHERE Officer_Designation='Officer'";
$result = mysqli_query($conn, $sql);

$sql2="SELECT * FROM `officers` WHERE Officer_Code='$officer_code'";
$result2= mysqli_query($conn, $sql2);
$row=mysqli_fetch_assoc($result2);

// Check if delete request is made
if(isset($_GET['Officer_Code'])) {
    $Officer_Code= $_GET['Officer_Code'];
    $sql_delete = "DELETE FROM `officers` WHERE Officer_Code= $Officer_Code";

    if(mysqli_query($conn, $sql_delete)) {
        header("Location: officers.php?error=Officer deleted successfully.!"); 
    } else {        
        header("Location: officers.php?error=Error deleting officer:".mysqli_error($conn)); 
    }
}

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
                <a href="officers.php" class="link"><span class="feather icon-chevron-right"></span><span>View Officer</span></a>
            </div>
            <a href="account.php" class="link"><span class="feather icon-user"></span><span>Account Settings</span></a>
        </div>
    </aside>
    <main class="content">
        <div class="content-header">
            <div class="title">
                <h4>Officers</h4>
            </div>
            <div class="navigation">
                <span><a href="index.php"><i class="feather icon-home"></i></a></span>
                <span>/</span>
                <span class="text-fade">View officer</span>
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
                        <th>Officer Picture</th>                        
                        <th>Officer code</th>
                        <th>Officer Name</th>
                        <th>Designation</th>
                        <th>Phone Number</th>
                        <th>Department</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                //To tell you when no officers are in the DB
					if (mysqli_num_rows($result)==0) {
							echo '<span style="color:#0066cc;">There are no officers.</span>';
						}
					//Loop through the database to display all rows
					while($record = mysqli_fetch_assoc($result)) {	
			          ?>
                    <tr>
                        <td>
                        <img class="img-fluid rounded-circle" style="width:45px;height: 40px;" src="assets/uploads/<?php echo $record['Profile_Pic'];?>"  alt="photo.png">
                        </td>
                        <td><?php echo $record['Officer_Code']; ?></td>
                        <td><?php echo $record['Officer_Name']; ?></td>
                        <td><?php echo $record['Officer_Designation']; ?></td>
                        <td><?php echo $record['Officer_Contact']; ?></td>
                        <td><?php echo $record['Department']; ?></td>                        
                        <td><?php echo $record['Remarks']; ?></td>
                        <td>
                            <?php
                              $_SESSION['officer_code'] = $record['Officer_Code'];

                            ?>
                        <input type="hidden" name="Officer_Code" value="<?php  $record['Officer_Code'];?>">
                        <a href="edit.php?Officer_Code=<?php echo $record['Officer_Code']?>" class="btn btn-primary"><i class="feather icon-edit"></i></a>
                        <a href="?Officer_Code=<?php echo $record['Officer_Code']?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="feather icon-trash-2"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <marquee behavior="alternate" direction="">
            &copy; &copy; @2024 All Rights Reserved 
        </marquee>
    </footer>
    <script src="assets/js/custom.js"></script>
    <script>

    function confirmDelete(Officer_Code) {
        var confirmDelete = confirm("Are you sure you want to delete this officer?");
        if (confirmDelete) {
            window.location.href = "?Officer_Code" + Officer_Code;
        }
    }

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