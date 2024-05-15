<?php
session_start(); 

include "db_conn.php";

if (isset($_POST['officer_Code'])&& isset($_POST['password'])){

	$officer_Code=$_POST['officer_Code'];
	$pass=$_POST['password'];

	if (empty($officer_Code)) {

        echo "Please enter your code";

        exit();

    }else if(empty($pass)){

        echo "please enter password";

        exit();

    }else{
		echo "login success";
	}

}




?>