<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Task Tracker</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel = "icon" href ="" type = "image/x-icon">

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.dataTables.js"></script>
</head>
<body>

    <div class="preloader"></div>

    <main class="m-footer">
        <div class="container">
            <div class="form-header text-center pt-4">
                <img src="assets/images/arms.png" alt="">
                <h4>REPUBLIC OF KENYA</h4>
                <br><br>
                <h4>MINISTRY OF INVESTMENTS, TRADE & INDUSTRY</h4>
                <h4>STATE DEPARTMENT FOR TRADE</h4>
                <h6 class="mt-5">ICT DEPARTMENT TECHNICAL SUPPORT REGISTER</h6>
            </div>
            
            
            <div class="form-body mt-2">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-4">
                        <div class="card"> 

                            <!-- display the error -->
                            <?php if (isset($_GET['error'])) { ?>
                                <p class="error"><?php echo $_GET['error']; ?></p>
                            <?php } ?>

                            <!-- Display success message -->
                            <?php if (isset($_GET['success'])) { ?>
                                        <p class="success"><?php echo $_GET['success']; ?></p>
                            <?php } ?>

                            <div class="card-header">Login </div>
                            <div class="card-body">

                                <form action="login.php" method="post">
                                    <div class="form-group mb-3">
                                        <label for="" class="form-control-label">Select Type of User</label>
                                        <select name="user_type" id="" class="form-control">
                                            <option >----select user type---</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Officer">Officer</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="" class="form-control-label" >Officer Code</label>
                                        <input type="text" name="officer_Code" class="form-control">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="" class="form-control-label" >Password</label>
                                        <input name="password" type="password" class="form-control" id="myInput">
                                        <br>
                                        <input type="checkbox"  onclick="myFunction()">Show Password
                                    </div>

                                    <a href="forgot_pass.php" class="mb-2">forgot password</a>
                                    <input name="login" type="submit" value="Login" class="btn btn-primary w-100">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(()=>{
            $('.preloader').fadeOut('slow', function(){
                $(this).remove()
            }).delay(100)
        })

        //toggle password
        function myFunction() {
            var x = document.getElementById("myInput");
             if (x.type === "password") {
                 x.type = "text";
                } else {
            x.type = "password";
            }
        }
    </script>
</body>
</html>
