<?php
session_start(); 

include "db_conn.php";

if (isset($_POST['submit'])){

     //apply the function to the input
	$officer_Code=$_POST['Officer_Code'];
    $officer_Contact=$_POST['Officer_Contact'];

    //check if the required fields are empty if not login
	if (empty( $officer_Contact)) {

        header("Location: account.php?error=Officer Contact is required!");
        exit();

    } else{
         //sql query to select and compare details entered and those in the DB
    // update the Database
    $sql="UPDATE `officers` SET `Officer_Contact`=' $officer_Contact' WHERE Officer_Code=$officer_Code";
    $result = mysqli_query($conn, $sql);
 
    header("Location: account.php?success=Updated successfully");
    exit();
    }   
    }


?>