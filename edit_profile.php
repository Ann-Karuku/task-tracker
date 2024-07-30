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

$sql="SELECT * FROM `officers` WHERE Officer_Code='$officer_code'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){

    $old_pp=$_POST['old_pp'];


    if (isset($_FILES['image']['name']) AND !empty($_FILES['image']['name'])) {
         
        
    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];
    
    if($error === 0){
       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
       $img_ex_to_lc = strtolower($img_ex);

       $allowed_exs = array('jpg', 'jpeg', 'png','jfif');
       if(in_array($img_ex_to_lc, $allowed_exs)){
          $new_img_name = uniqid($uname, true).'.'.$img_ex_to_lc;
          $img_upload_path = 'assets/uploads/'.$new_img_name;
          // Delete old profile pic
          $old_pp_des = "assets/uploads/$old_pp";
          if(unlink($old_pp_des)){
                // just deleted
                move_uploaded_file($tmp_name, $img_upload_path);
          }else {
             // error or already deleted
                move_uploaded_file($tmp_name, $img_upload_path);
          }
          

          // update the Database
          $sql2="UPDATE `officers` SET `Profile_Pic`='$new_img_name' WHERE Officer_Code=$officer_code";
         $result2 = mysqli_query($conn, $sql2);
          if($result2){
              header("Location:account.php?success=Updated successfully!");
              exit;
          }
           
       }else {
        // header("Location: edit.php?error2=You cant upload files of this type");
          exit;
       }
    }else {
      // header("Location: ../edit.php?error2=unknown error occurred!");
       exit;
    }
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
            <a href="home_page.php" class="navbar-brand">
                <div class="icon">
                    <img src="assets/images/arms.png" alt="">
                </div>
                <div class="title-text">ICT Task Tracker</div>
            </a>
        </div>
        <div class="profile-tab">
            <div class="profile-photo">
          <?php
          if($row['Profile_Pic']){
            echo '<img src="assets/uploads/'.$row['Profile_Pic'] . '"">';
          }else{
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
                <a href="officers.php" class="link"><span class="feather icon-chevron-right"></span><span>View Officers</span></a>
            </div>
            <a href="account.php" class="link"><span class="feather icon-user"></span><span>Account Settings</span></a>
        </div>
    </aside>

    <main class="content">
        <div class="content-header">
            <div class="title">
                <h4>Edit Profile Picture</h4>
            </div>
            <div class="navigation">
                <span><a href="home_page.php"><i class="feather icon-home"></i></a></span>
                <span>/</span>
                <span class="text-fade">Edit Profile Picture</span>
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
            <form action= "" method="post" enctype="multipart/form-data">
                <div class="row">               
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                              <!-- display the error -->
                              <?php if (isset($_GET['error2'])) { ?>
                                <p class="error"><?php echo $_GET['error2']; ?></p>
                            <?php } ?>
                            <label for="" class="form-control-label">Profile Picture</label>
                              <input type="file" name="image" class="form-control" >
                              <br>
                              <img src="assets/uploads/<?php echo $row['Profile_Pic'] ?>"class="rounded-circle" style="width:85px;height: 80px;">
                              <input type="text" hidden="hidden" name="old_pp" value="<?php echo $row['Profile_Pic'] ?>" >
                        </div>
                    </div>
                </div>
                <input type="submit" value="Update" name="submit" class="btn btn-primary">
                <a href="account.php" class="btn btn-warning">Cancel</a>
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
        $(document).ready(() => {
            // JavaScript code here
        });
        $('.preloader').fadeOut('slow', function () {
            $(this).remove()
        }).delay(100);
    </script>
</body>
</html>
