<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Task Tracker</title>
    
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="assets/css/style.css">

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
                            <div class="card-header">Login </div>
                            <div class="card-body">
                                <form action="home_page.php">
                                    <div class="form-group mb-3">
                                        <label for="" class="form-control-label">Select Type of User</label>
                                        <select name="user_type" id="" class="form-control">
                                            <option value="">----select user type---</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Officer</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="" class="form-control-label" name="officer_code">Officer Code</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="" class="form-control-label" name="password">Password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <a href="" class="mb-2">forgot password</a>
                                    <input type="submit" value="Login" class="btn btn-primary w-100">
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
    </script>
</body>
</html>