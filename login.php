<?php
session_start();

include "db_conn.php";

if (isset($_POST['officer_Code']) && isset($_POST['password'])) {

    // Retrieve the selected role from the form
    $role = isset($_POST['user_type']) ? $_POST['user_type'] : '';

    // Function to remove unwanted characters and spaces
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Apply the function to the input
    $officer_Code = validate($_POST['officer_Code']);
    $password = validate($_POST['password']);

    // Check if the required fields are empty
    if (empty($officer_Code)) {
        header("Location: index.php?error=Officer code is required!");
        exit();
    } else if (empty($password)) {
        header("Location: index.php?error=Please enter password!");
        exit();

    }else{

        // hashing the psw
       // $psw=hash('sha512',$psw);

        //sql query to select and compare details entered and those in the DB
        $sql= "SELECT * FROM `officers` WHERE Officer_Code= '$officer_Code' AND Password='$pass'";
        $result = mysqli_query($conn, $sql);//pass the query to the mysql connection


        //check if there's a result of the query
        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['Officer_Code'] === $officer_Code && $row['Password'] === $pass) {

                if($row['Officer_Designation']!=$role){
                    header("Location: index.php?error=Kindly select the correct role!");
                } else {
                    // Store user information in session
                    $_SESSION['user_type'] = $role;
                    $_SESSION['officer_code'] = $row['Officer_Code'];
                    $_SESSION['officer_name'] = $row['Officer_Name'];

                    header("Location: home_page.php");
                    exit();
                }
            } else {
                header("Location: index.php?error=Incorrect Officer Code or password");
                exit();
            }
        } else {
            header("Location: index.php?error=Officer Does not Exist!");
            exit();
        }
    }
} else {
    header("Location: index.php?error=Invalid Request");
    exit();
}
?>
