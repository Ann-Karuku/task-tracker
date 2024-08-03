<?php
include "db_conn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['officer_code'])) {
        $officer_code = $_POST['officer_code'];
    } else {
        header("Location: forgot_pass.php?error=Officer code not provided!");
        exit();
    }

    // Fetch the officer's details from the database
    $sql = "SELECT * FROM `officers` WHERE Officer_Code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $officer_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: forgot_pass.php?error=Officer code not found!");
        exit();
    } 
} else {
    header("Location: forgot_pass.php?error=BAD BAD!");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
    <div class="content-body">
        <div class="row justify-content-center">
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>
            <form action="reset_pass_val.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="new_password" class="form-control-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirm_password" class="form-control-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="officer_code" value="<?php echo htmlspecialchars($row['Officer_Code']); ?>">
                                <input type="submit" value="Reset Password" name="submit" class="btn btn-primary">
                                <a href="forgot_pass.php" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
