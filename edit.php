<?php
session_start();
$officer_name=$_SESSION['officer_name'];

$officer_code=$_GET['Officer_Code'];

include_once "db_conn.php";

$sql="SELECT * FROM `officers` WHERE Officer_Code='$officer_code'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
    
$name=$_POST['Officer_Name'];
$designation=$_POST['Officer_Designation'];
$contact=$_POST['Officer_Contact'];
$remarks=$_POST['Remarks'];
$old_pp=$_POST['old_pp'];


if (isset($_FILES['image']['name']) AND !empty($_FILES['image']['name'])) {
         
        
    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];
    
    if($error === 0){
       $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
       $img_ex_to_lc = strtolower($img_ex);

       $allowed_exs = array('jpg', 'jpeg', 'png');
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
          $sql2="UPDATE `officers` SET `Officer_Name`='$name',`Officer_Designation`='$designation',`Officer_Contact`='$contact'
          ,`Remarks`='$remarks',`Profile_Pic`='$new_img_name' WHERE Officer_Code=$officer_code";
         $result2 = mysqli_query($conn, $sql2);
          if($result2){
              header("Location:officers.php?success=Updated successfully!");
          }
           exit;
       }else {
         // header("Location: ../edit.php?error2=You cant upload files of this type");
          exit;
       }
    }else {
      // header("Location: ../edit.php?error2=unknown error occurred!");
       exit;
    }
 }

 // update the Database
 $sql2="UPDATE `officers` SET `Officer_Name`='$name',`Officer_Designation`='$designation',`Officer_Contact`='$contact'
 ,`Remarks`='$remarks' WHERE Officer_Code=$officer_code";
$result2 = mysqli_query($conn, $sql2);
 if($result2){
     header("Location:officers.php?success=Updated successfully!");
 }
  exit;
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
                <h4>Edit Officer</h4>
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
            <form action= "" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Name</label>
                            <input type="text" class="form-control" name="Officer_Name" value="<?php echo $row['Officer_Name'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Designation</label>
                            <select class="form-control" name="Officer_Designation" value="<?php echo $row['Officer_Designation'] ?>" readonly required>
                                     <option >----select user type---</option>
                                     <option >Officer</option>   
                                     <option >Admin</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Department</label>
                            <input type="text" class="form-control" name="Department" value="<?php echo $row['Department'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Contact</label>
                            <input type="number"name="Officer_Contact"class="form-control" value="<?php echo $row['Officer_Contact'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="" class="form-control-label">Officer Code</label>
                            <input type="number" name="Officer_Code" class="form-control" value="<?php echo $row['Officer_Code'] ?>" readonly>
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
                              <!-- display the error -->
                              <?php if (isset($_GET['error2'])) { ?>
                                <p class="error"><?php echo $_GET['error2']; ?></p>
                            <?php } ?>
                            <label for="" class="form-control-label">Passport photo</label>
                              <input type="file" name="image" class="form-control" >
                              <br>
                              <img src="assets/uploads/<?php echo $row['Profile_Pic'] ?>"class="rounded-circle" style="width:85px;height: 80px;">
                              <input type="text" hidden="hidden" name="old_pp" value="<?php echo $row['Profile_Pic'] ?>" >
                        </div>
                    </div>
                </div>
                <input type="submit" value="Update" name="submit" class="btn btn-primary">
                <a href="officers.php" class="link"><input type="reset" value="Cancel" class="btn btn-warning"></a>
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
