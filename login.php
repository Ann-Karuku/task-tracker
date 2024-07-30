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
    } else {
        // Prepare SQL query using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM `officers` WHERE Officer_Code = ?");
        $stmt->bind_param("s", $officer_Code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Check if the password matches
            if (hash('sha512', $password) === $row['Password']) {
                // Check if the selected role matches the officer's designation
                if ($row['Officer_Designation'] !== $role) {
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
