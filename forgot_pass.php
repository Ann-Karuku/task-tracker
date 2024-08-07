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
            <form action="reset_pass.php" method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <h3>Forgot Password</h3>
                                <label for="" class="form-control-label">Officer Code</label>
                                <input type="text" name="officer_code" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <input type="submit" value="Reset" name="submit" class="btn btn-primary">
                                <a href="index.php" class="btn btn-warning">Back</a>
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
