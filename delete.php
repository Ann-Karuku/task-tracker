<?php
include "db_conn.php";

// Check if the 'id' key is set in the $_GET array
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Prepare the SQL statement to delete the record with the given id
    $sql= "DELETE FROM officers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the home page with a success message
        header("Location: home_page.php?msg=record deleted successfully");
        exit(); // Stop further execution
    } else {
        // Handle the error if the deletion fails
        echo "Failed: " . $stmt->error;
    }
} else {
    // Redirect or handle the case where 'id' is not set in the URL
    header("Location: error.php");
    exit(); // Stop further execution
}
?>
