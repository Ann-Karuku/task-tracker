<?php

session_start(); 

include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Officer_Name = $_POST['Officer_Name'];
    $Officer_Designation = $_POST['Officer_Designation'];
    $Department = $_POST['Department'];
    $Officer_Contact = $_POST['Officer_Contact'];
    $Officer_Code = $_POST['Officer_Code'];
    $Password = $_POST['Password'];

    // File upload directory 
    $targetDir = "uploads/"; 

    if (!empty($_FILES["image"]["name"])) { 
        $fileName = basename($_FILES["image"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif'); 

        if (in_array($fileType, $allowTypes)) { 
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) { 
                $sql = "INSERT INTO officers (Officer_Code, Officer_Name, Officer_Designation, Department, Officer_Contact, Password, Profile_Pic) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
                $stmt = $conn->prepare($sql);

                // Bind parameters with data types
                $stmt->bind_param("sssssss", $Officer_Code, $Officer_Name, $Officer_Designation, $Department, $Officer_Contact, $Password, $fileName);

                if ($stmt->execute()) {
                    echo "New Officer created successfully";
                    $stmt->close();
                    $conn->close();
                    header("Location: officers.php");
                    exit();
                } else {
                    echo "Error " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        }
    } else {
        echo "Please upload a file";
    }
} else {
    echo "Error";
    $conn->close();
    header("Location: add_officer.php");
    exit();
}
?>
