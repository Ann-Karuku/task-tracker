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
    $Remarks = $_POST['Remarks'];

    // File upload directory 
    $targetDir = "assets/uploads/"; 

    if (!empty($_FILES["image"]["name"])) { 
        $fileName = basename($_FILES["image"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif'); 

        if (in_array($fileType, $allowTypes)) { 
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) { 

                	// hashing the psw
                $psw=hash('sha512',$Password);

                $sql = "INSERT INTO officers (Officer_Code, Officer_Name, Officer_Designation, Department, Officer_Contact, Remarks, Password, Profile_Pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
                $stmt = $conn->prepare($sql);

                // Bind parameters with data types
                $stmt->bind_param("ssssssss", $Officer_Code, $Officer_Name, $Officer_Designation, $Department, $Officer_Contact, $Remarks, $psw, $fileName);

                if ($stmt->execute()) {
                    $stmt->close();
                    $conn->close();
                    header("Location: add_officer.php?success=New Officer created successfully");
                 exit();
                } else {
                    echo "Error " . $sql . "<br>" . $conn->error;
                }
            } else {
                header("Location: add_officer.php?error=Sorry, there was an error uploading your file!");
                 exit();
            }
        } else {
            header("Location: add_officer.php?error=Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload!");
            exit();
        }
    } else {
        header("Location: add_officer.php?error=please upload a file!");
         exit();
    }
} else {
    $conn->close();
    header("Location: add_officer.php?error=unknown error occured!");
    exit();
}
?>
