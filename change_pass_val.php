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

    if ($row) {
        if ($row['Password'] === $current_password) {
            if ($new_password === $repeat_new_password) {
                // Update the password
                $sql2 = "UPDATE `officers` SET Password='$new_password' WHERE Officer_Code='$officer_code'";
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
