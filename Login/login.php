<?php
	$usrname="";
	$pass="";
	// Grab User submitted information
	$usrname = $_POST["username"];
	$pass = $_POST["password"];
	/*
	This portion is to enter code for: 
	**connecting to database
	**selecting from a table that has '$usrname' and '$pass'
	*/
	
	if($usrname=="--username in database--" && $pass=="--password in database--"){
		
		session_start();
		
		if($_REQUEST['username']==$usrname && $_REQUEST['password']==$pass){
			
			$_SESSION['username'] = $usrname;
			
			$_SESSION['password'] = $pass;
			
			header("Location:--homepage--");
		}
		}
		else{
		//redirects if the username or password is not in the database
			header("Location:Login.html");
	}
?>