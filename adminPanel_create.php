<?php
session_start();
if(!isset($_SESSION["admin"])){
	header("Location: adminPanel.php");
}

?>

<html>
<script src = "jquery/jquery.js"></script>
<script src = "js/bootstrap.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">
<head>
	<title>SRS: Admin Panel - Create Worker</title>
</head>

<script>
var localURL = "srs_ajax.php?";


//Ajax sync function
function syncAjax(u){
	u = localURL + u;

	var response; 
	$.ajax(
		{url:u,
			async:false,
			success: function(res){
				response = res;
			}
		}
		);

	return response;
}


function create(){
	var fullname = document.getElementById("fullname").value;
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;

	var x = syncAjax("createWorker&fullname="+encodeURIComponent(fullname)+"&username="+encodeURIComponent(username)+"&password="+encodeURIComponent(password));

	if(x == "True"){
		alert("Worker created successfully!");
		document.location = "adminPanel.php";
	}
	else
		alert("Error creating worker!");

}


//Status
function alertStatus(type, msg){
	var info;

	if(type == "success"){
		info = '<div id = "status" class = "alert alert-success alert-dismissible" role = "alert">'
		+' <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
		+msg+'</div>'
		document.getElementById("status").innerHTML = info;
	}

	else if (type == "error"){
		info = '<div id = "status" class = "alert alert-danger alert-dismissible" role = "alert">'
		+' <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
		+msg+'</div>'
		document.getElementById("status").innerHTML = info;
	}
}

</script>
<body style = "background-color: #D9D9D9">

	<div class = "container-fluid">
		<div class = "col-lg-1"></div><div class = "col-lg-10" style="background-color: white">
		<div class = "row" align = "center">
			<img src = "images/logo.png" alt = "Service Request System" style = "width:200px;height:150px"></img>
			<h1>Service Request System: Create User</h1>
		</div>

	</br></br>

	<!-- Full Name input -->
	<div class = "row">
		<div class = "col-lg-4"></div>
		<div class = "col-lg-4" align = "center">
			<div class = "input-group">
				<span class = "input-group-addon">Full Name:</span>
				<input type = "text" class = "form-control" id = "fullname">
			</div>
		</div>
		<div class = "col-lg-4"></div>
	</div><!-- End of full name input -->
</br>

	<!-- Username input -->
	<div class = "row">
		<div class = "col-lg-4"></div>
		<div class = "col-lg-4" align = "center">
			<div class = "input-group">
				<span class = "input-group-addon">Userame:</span>
				<input type = "text" class = "form-control" id = "username">
			</div>
		</div>
		<div class = "col-lg-4"></div>
	</div><!-- End of username input -->
</br>

<!-- Password input -->
<div class = "row">
	<div class = "col-lg-4"></div>
	<div class = "col-lg-4" align = "center">
		<div class = "input-group">
			<span class = "input-group-addon">Password:</span>
			<input type = "password" class = "form-control" id = "password">
		</div>
	</div>
	<div class = "col-lg-4"></div>
</div><!-- End of password input -->
</br>

<!-- Create Button -->
<div class = "row">
	<div class = "col-lg-4"></div>
	<div class = "col-lg-4" align = "center">
		<div role = "button" class = "btn btn-success" onClick = "create()">Create User</div>
		<a href = "index.php" role = "button" class = "btn btn-danger">Cancel</a>
	</div>
	<div class = "col-lg-4"></div>
</div><!-- End of create button -->
</br></br>

<footer>
	<div class = "row" align = "right">
		<div class = "col-lg-8"></div>
		<div class = "col-lg-4">
			&copyTeam SRS
		</div>
	</div>
</footer>

</div><!-- End of background-color -->
</div>
</body>
</html>