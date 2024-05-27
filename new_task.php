<?php
session_start();

include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Date = $_POST['Date'];
    $Office_NO = $_POST['Office_Number'];
    $Support_Request = $_POST['Support_Requested_For'];
    $Support_Given = $_POST['Support_Given'];
    $Officer_Code = $_POST['Supporting_Officer_Code'];
    $Remarks = $_POST['Remarks'];
    $Department = $_POST['Department'];

    $sql = "INSERT INTO tasks (Date, Office_NO, Support_Request, Support_Given, Officer_Code, Remarks, Department)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", $Date, $Office_NO, $Support_Request, $Support_Given, $Officer_Code, $Remarks, $Department);

        if ($stmt->execute()) {
            header("Location: tasks.php?success=Task added successfully");
        } else {
            header("Location: add_task.php?error=Error adding task");
        }
        
        $stmt->close();
    } else {
        header("Location: add_task.php?error=Error preparing statement");
    }

    $conn->close();
} else {
    header("Location: add_task.php");
}
?>
