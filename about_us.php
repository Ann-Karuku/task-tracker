<?php
session_start();
include "db_conn.php";

// Check if session variables are set
if (!isset($_SESSION['user_type']) || !isset($_SESSION['officer_code']) || !isset($_SESSION['officer_name'])) {
    // If not set, redirect to login page
    header("Location: index.php?error=Please log in to access this page!");
    exit();
}

    // Retrieve from session
    $role = $_SESSION['user_type'];
    $officer_code=$_SESSION['officer_code'];
    $officer_name=$_SESSION['officer_name'];

    // Check if the role is set in session
    if($role=='----select user type---'){
        // If not, redirect back to the login page
        header("Location: index.php?error=Please select user type!");
    }

    $sql="SELECT * FROM `officers` WHERE Officer_Code='$officer_code'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);

    
    mysqli_close($conn);
   
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
    <link rel="stylesheet" href="index.css">

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
                <a href="officers.php" class="link"><span class="feather icon-chevron-right"></span><span>View Officers</span></a>
                </div>
            <?php endif; ?>
                
                
            
            <a href="account.php" class="link"><span class="feather icon-user"></span><span>Account Settings</span></a>
        </div>
    </aside>
    <main class="content">
        <div class="content-header">
            <div class="title">
                <h4>Dashboard</h4>
            </div>
            <div class="navigation">
                <span><a href="home_page.php"><i class="feather icon-home"></i></a></span>
                <span>/</span>
                <span class="text-fade">Dashboard</span>
            </div>
        </div>
        <div class="content-body">
            <div class="banner">
                <div class="banner-text">
                    <h1>MINISTRY OF INVESTMENTS, TRADE & INDUSTRY</h1>
                    <h2>STATE DEPARTMENT FOR TRADE</h2>
                    <h4>ICT DEPARTMENT TECHNICAL SUPPORT</h4>     
                </div>
                <div class="container-cont">
            <div class="wrapper-cont">
                <img src="assets/images/Team.jpg" alt="">
                <img src="assets/images/Team1.jpg" alt="">
                <img src="assets/images/Team2.jpg" alt="">
                <img src="assets/images/Team3.jpg" alt="">
                <img src="assets/images/Team4.jpg" alt="">
                <img src="assets/images/Team5.jpg" alt="">
                <img src="assets/images/Team6.jpg" alt="">
            </div>
        </div>
            </div>
        </div><br>
    <div class="head-1">
    <h2>Meet Our Team</h2>
    <h3>Developers:</h3>
    <div class="team-container">
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Omar.jpeg" alt="Omar">
                <div class="card-overlay">
                    <p class="name-title">Omar - Senior Backend Developer</p>
                </div>
            </div>
            <div class="card-back">
                <p>Omar - Senior Backend Developer with a passion for scalable systems.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/James.png" alt="James">
                <div class="card-overlay">
                    <p class="name-title">James - Full-Stack Developer</p>
                </div>
            </div>
            <div class="card-back">
                <p>James - Full-stack developer specializing in modern web applications.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/sharon.jpeg" alt="Sharon">
                <div class="card-overlay">
                    <p class="name-title">Sharon - Data Scientist</p>
                </div>
            </div>
            <div class="card-back">
                <p>Sharon - Data Scientist with expertise in predictive analytics.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Antony.jpeg" alt="Antony">
                <div class="card-overlay">
                    <p class="name-title">Antony - Cloud Architect</p>
                </div>
            </div>
            <div class="card-back">
                <p>Antony - Cloud Architect focused on scalable and secure systems.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Faith.jpeg" alt="Faith">
                <div class="card-overlay">
                    <p class="name-title">Faith - UI/UX Designer</p>
                </div>
            </div>
            <div class="card-back">
                <p>Faith - UI/UX Designer crafting intuitive and user-friendly interfaces.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Cynthia.jpeg" alt="Cynthia">
                <div class="card-overlay">
                    <p class="name-title">Cynthia - Frontend Developer</p>
                </div>
            </div>
            <div class="card-back">
                <p>Cynthia - Frontend Developer creating sleek and interactive designs.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Anne.jpeg" alt="Ann">
                <div class="card-overlay">
                    <p class="name-title">Ann Karuku - DevOps Engineer</p>
                </div>
            </div>
            <div class="card-back">
                <p>Ann Karuku - DevOps Engineer ensuring smooth deployment pipelines.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Brian.jpeg" alt="Brian">
                <div class="card-overlay">
                    <p class="name-title">Brian - Mobile Developer</p>
                </div>
            </div>
            <div class="card-back">
                <p>Brian - Mobile Developer building cross-platform applications.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Deighty.jpeg" alt="Deighty">
                <div class="card-overlay">
                    <p class="name-title">Deighty - AI Specialist</p>
                </div>
            </div>
            <div class="card-back">
                <p>Deighty - AI Specialist developing intelligent automation solutions.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Charity.png" alt="Charity">
                <div class="card-overlay">
                    <p class="name-title">Charity - Product Manager</p>
                </div>
            </div>
            <div class="card-back">
                <p>Charity - Product Manager aligning business goals with technical strategies.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Bleah.jpeg" alt="Delron">
                <div class="card-overlay">
                    <p class="name-title">Delron - Cybersecurity Expert</p>
                </div>
            </div>
            <div class="card-back">
                <p>Delron - Cybersecurity Expert securing systems against vulnerabilities.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Koskei.jpeg" alt="Koskei">
                <div class="card-overlay">
                    <p class="name-title">Koskei - Blockchain Developer</p>
                </div>
            </div>
            <div class="card-back">
                <p>Koskei - Blockchain Developer innovating in decentralized technologies.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Keziah.jpeg" alt="Keziah">
                <div class="card-overlay">
                    <p class="name-title">Keziah - Machine Learning Engineer</p>
                </div>
            </div>
            <div class="card-back">
                <p>Keziah - Machine Learning Engineer creating predictive models.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Teklah.jpeg" alt="Teklah">
                <div class="card-overlay">
                    <p class="name-title">Teklah - Database Administrator</p>
                </div>
            </div>
            <div class="card-back">
                <p>Teklah - Database Administrator maintaining data integrity and availability.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <div class="card-front">
                <img src="assets/images/Daniel.jpeg" alt="Daniel">
                <div class="card-overlay">
                    <p class="name-title">Daniel - Technical Writer</p>
                </div>
            </div>
            <div class="card-back">
                <p>Daniel - Technical Writer producing clear documentation for complex systems.</p>
            </div>
        </div>
    </div>
</div>
</div>
    </div>    
    </main>
    <footer>
    <marquee behavior="alternate" direction="">
    &copy; @2024 All Right Reserved 
        </marquee>
    </footer>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(()=>{})
        $('.preloader').fadeOut('slow', function(){
            $(this).remove()
        }).delay(100)
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