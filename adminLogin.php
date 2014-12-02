<?php

$msg="";
if(isset($_REQUEST['username'])){
		//the login form has been submitted
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
		//call login to check username and password
	if(login($username,$password)){
			session_start();	//initiate session for the current login
			loadUserProfile($username);	//load user information into the session
			header("location: adminPanel.php");	//redirect to home page
			exit();
		}elseif(!login($username,$password)){
			//if login returns false, then something is worng
			$msg="Your Login Name or Password is invalid";
			
		}
		else{
			$msg="Enter Login Details";
		}
	}
	?>

<html>
	<link href="css/bootstrap.css" rel="stylesheet">
	<head>
		<title>Admin Login</title>
	</head>
	<body>
		<div class = "container-fluid"
		<div align = "center">
			<div class = "row">
				<img src = "images/logo_small.png" alt = "SRS Logo" align = "center"></img>
			</div>
		</br>
			<div class = "row">
				<form action="adminLogin.php" method="POST">
					<div class = "row">
						<div class = "col-lg-6" align = "right">
							Username:
						</div>
						<div class = "col-lg-6" align = "left">
							<input type="text" name="username">
						</div>
					</div>
				</br>
					<div class = "row">
						<div class = "col-lg-6" align = "right">
							Password:
						</div>
						<div class = "col-lg-6" align = "left">
							<input type="password" name="password">
						</div>
					</div>
				</br>
					<div class = "row">
						<input class = "btn btn-primary" type="submit" name="submit" value="Login">
					</div>
				</br>
					<div class = "row">
						<div id="error"><?php if($msg!="") { echo $msg; } ?></div>
					</div>
				</form>
			</div>
		</div>
	</div>
	</body>
	</html>

	<?php
	function login($username, $password){

	$database="srsdb";	//this database has to exist. 
	$user="root";		//the main admin user of mysql
	$passwor="";			//use root password of mysql
	$server="localhost";	//name of the server
	
	$link=mysql_connect($server,$user,$passwor);
	//if result is false, the connection did not open
	if(!$link){	
		echo "Failed to connect to mysql.";
		//display error message from mysql
		echo mysql_error();	
		exit();		//end script
		echo "failed";
	}
	//select the database to work with using the open connection 
	if(!mysql_select_db($database,$link)){
		echo "Failed to select database.";
		//display error message from mysql
		echo mysql_error();	
		exit();	
		return false;
	}

	$dataset = mysql_query("SELECT * from SRS_ADMIN  where username='$username' and password = '$password'", $link);
	$result = mysql_fetch_assoc($dataset);
	
	if($result)
		return true;
	else{
		return false;
		echo mysql_error();
		exit();
	}
	
}

function loadUserProfile($username){
		//load username and other informaiton into the session 
		//the user informaiton comes from the database
	$_SESSION["user"]=$username;
}
?>
