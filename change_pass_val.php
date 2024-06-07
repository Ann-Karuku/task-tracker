<?php
session_start();

$officer_code = $_SESSION['officer_code'];

include "db_conn.php";

if (isset($_POST['submit'])) {
    $current_password = $_POST['Current_Password'];
    $new_password = $_POST['New_Password'];
    $repeat_new_password = $_POST['Repeat_New_Password'];

    // Fetch the existing password from the database
    $sql = "SELECT * FROM `officers` WHERE Officer_Code = '$officer_code'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

     // hashing the passwords
     $psw1=hash('sha512',$current_password);
     $psw2=hash('sha512',$new_password);
     $psw3=hash('sha512',$repeat_new_password);

    if ($row) {
        if ($row['Password'] === $psw1) {
            if ($psw2 === $psw3) {
                // Update the password
                $sql2 = "UPDATE `officers` SET Password='$psw2' WHERE Officer_Code='$officer_code'";
                $result2 = mysqli_query($conn, $sql2);

                if ($result2) {
                    header("Location: account.php?success=Password updated successfully!");
                    exit;
                } else {
                    header("Location: change_pass.php?error=Failed to update password!");
                    exit;
                }
            } else {
                header("Location: change_pass.php?error=Password mismatch!");
                exit;
            }
        } else {
            header("Location: change_pass.php?error=Current password is incorrect!");
            exit;
        }
    } else {
        header("Location: change_pass.php?error=Officer code not found!");
        exit;
    }
} else {
    header("Location: change_pass.php");
    exit;
}
?>
