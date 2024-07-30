<?php
session_start();

include "db_conn.php";

// Function to remove unwanted characters and spaces
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate password requirements
function validatePassword($password) {
    $errors = [];

    // Check length
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    // Check for at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must contain at least one uppercase letter.';
    }
    // Check for at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Password must contain at least one lowercase letter.';
    }
    // Check for at least one number
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must contain at least one number.';
    }
    // Check for at least one special character
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = 'Password must contain at least one special character.';
    }

    return $errors;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and validate form inputs
    $current_password = validate($_POST['Current_Password']);
    $new_password = validate($_POST['New_Password']);
    $repeat_new_password = validate($_POST['Repeat_New_Password']);

    // Validate new password
    $passwordErrors = validatePassword($new_password);
    if (!empty($passwordErrors)) {
        header("Location: change_pass.php?error=" . implode(', ', $passwordErrors));
        exit();
    }

    // Fetch the existing password from the database
    $officer_code = $_SESSION['officer_code'];
    $sql = "SELECT * FROM `officers` WHERE Officer_Code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $officer_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Hash the passwords
    $psw1 = hash('sha512', $current_password);
    $psw2 = hash('sha512', $new_password);
    $psw3 = hash('sha512', $repeat_new_password);

    if ($row) {
        if ($row['Password'] === $psw1) {
            if ($psw2 === $psw3) {
                // Update the password
                $sql2 = "UPDATE `officers` SET Password=? WHERE Officer_Code=?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param("ss", $psw2, $officer_code);
                
                if ($stmt2->execute()) {
                    $stmt2->close();
                    $conn->close();
                    header("Location: account.php?success=Password updated successfully!");
                    exit();
                } else {
                    header("Location: change_pass.php?error=Failed to update password!");
                    exit();
                }
            } else {
                header("Location: change_pass.php?error=Password mismatch!");
                exit();
            }
        } else {
            header("Location: change_pass.php?error=Current password is incorrect!");
            exit();
        }
    } else {
        header("Location: change_pass.php?error=Officer code not found!");
        exit();
    }
} else {
    $conn->close();
    header("Location: change_pass.php?error=Unknown error occurred!");
    exit();
}
?>
