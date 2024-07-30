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
    $Officer_Name = validate($_POST['Officer_Name']);
    $Officer_Designation = validate($_POST['Officer_Designation']);
    $Department = validate($_POST['Department']);
    $Officer_Contact = validate($_POST['Officer_Contact']);
    $Officer_Code = validate($_POST['Officer_Code']);
    $Password = validate($_POST['Password']);
    $Remarks = validate($_POST['Remarks']);

    // Validate password
    $passwordErrors = validatePassword($Password);
    if (!empty($passwordErrors)) {
        header("Location: add_officer.php?error=" . implode(', ', $passwordErrors));
        exit();
    }

    // File upload directory 
    $targetDir = "assets/uploads/"; 

    if (!empty($_FILES["image"]["name"])) { 
        $fileName = basename($_FILES["image"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif'); 

        if (in_array($fileType, $allowTypes)) { 
            // Ensure file size is reasonable (e.g., 2MB max)
            if ($_FILES["image"]["size"] <= 2 * 1024 * 1024) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) { 

                    // Hash the password
                    $hashedPassword = hash('sha512', $Password);

                    // Prepare SQL query using prepared statements
                    $sql = "INSERT INTO officers (Officer_Code, Officer_Name, Officer_Designation, Department, Officer_Contact, Remarks, Password, Profile_Pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);

                // Bind parameters with data types
                $stmt->bind_param("ssssssss", $Officer_Code, $Officer_Name, $Officer_Designation, $Department, $Officer_Contact, $Remarks, $Password, $fileName);

                    if ($stmt->execute()) {
                        $stmt->close();
                        $conn->close();
                        header("Location: add_officer.php?success=New Officer created successfully");
                        exit();
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    header("Location: add_officer.php?error=Sorry, there was an error uploading your file!");
                    exit();
                }
            } else {
                header("Location: add_officer.php?error=File size is too large. Maximum allowed size is 2MB.");
                exit();
            }
        } else {
            header("Location: add_officer.php?error=Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload!");
            exit();
        }
    } else {
        header("Location: add_officer.php?error=Please upload a photo!");
        exit();
    }
} else {
    $conn->close();
    header("Location: add_officer.php?error=Unknown error occurred!");
    exit();
}
?>
