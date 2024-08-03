<?php
include "db_conn.php";

// Function to remove unwanted characters and spaces
function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $new_password = validate($_POST['new_password']);
    $confirm_password = validate($_POST['confirm_password']);
    $officer_code = validate($_POST['officer_code']);

    if ($new_password !== $confirm_password) {
        header("Location: reset_pass.php?error=Password mismatch!");
        exit();
    } else {
        // Validate password requirements
        if (strlen($new_password) < 8) {
            header("Location: forgot_pass.php?error=Password must be at least 8 characters long.");
            exit();
        } elseif (!preg_match('/[A-Z]/', $new_password)) {
            header("Location: forgot_pass.php?error=Password must contain at least one uppercase letter.");
            exit();
        } elseif (!preg_match('/[a-z]/', $new_password)) {
            header("Location: forgot_pass.php?error=Password must contain at least one lowercase letter.");
            exit();
        } elseif (!preg_match('/[0-9]/', $new_password)) {
            header("Location: forgot_pass.php?error=Password must contain at least one number.");
            exit();
        } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $new_password)) {
            header("Location: forgot_pass.php?error=Password must contain at least one special character.");
            exit();
        } else {
            // Hash the new password
            $hashed_password = hash('sha512', $new_password);

            // Update the password in the database
            $sql = "UPDATE `officers` SET `Password` = ? WHERE `Officer_Code` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashed_password, $officer_code);

            if ($stmt->execute()) {
                header("Location: forgot_pass.php?success=Password successfully reset.");
                exit();
            } else {
                header("Location: forgot_pass.php?error=Failed to reset password. Please try again.");
                exit();
            }
        }
    }
} else {
    header("Location: forgot_pass.php?error=Invalid request.");
    exit();
}
?>
