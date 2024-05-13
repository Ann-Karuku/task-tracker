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
        
		/*$sql = "SELECT * FROM  WHERE ='$' AND Password='$password'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['email'] === $email && $row['Password'] === $password) {
            	$_SESSION['email'] = $row['CompanyID'];
            	$_SESSION['CompanyName'] = $row['CompanyName'];
            	header("Location: home_page.php");
		        exit();
            }else{
				header("Location: index.php?error=Incorect Code or password");
		        exit();
			}
		}else{
			header("Location: index.php?error=Incorect Code or password");
	        exit();
		}*/
	}
	
}else{
	header("Location: index.php");
	exit();
}
?>