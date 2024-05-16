<?php
session_start();
include "db_conn.php";
 
if (isset($_POST['login'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$officer_Code = validate($_POST['officer_Code']);
	$password = validate($_POST['password']);

	if (empty($officer_Code)) {
		header("Location: index.php?error=Officer Code is required");
	    exit();
	}else if(empty($password)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		// hashing the psw
        $password = md5($password);
        header("Location: home_page.php");
      
	
}else{
	header("Location: index.php");
	exit();
}
?>