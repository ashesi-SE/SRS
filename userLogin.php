<html>
<link href="css/bootstrap.css" rel="stylesheet">
<script src = "jquery/jquery.js"></script>
<head>
	<title>SRS: User Login</title>
</head>

<script>
var localURL = "srs_ajax.php?";

//Login function
function login(){
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;

	if(username == "" || password == "")
		alert("Kindly fill all fields!");

	else{
	$.ajax(
		{url:localURL+"userLogin&username="+username+"&password="+password,
			async:false,
			success: function(response){
				if(response == "True"){
					document.location = "index.php";
				}
				else
					alert("Incorrect Login!");
			}
	}
	);
}
}
</script>

<body style = "background-color: #D9D9D9">

	<div class = "container-fluid">
		<div class = "col-lg-1"></div><div class = "col-lg-10" style="background-color: white">
		<div class = "row" align = "center">
			<img src = "images/logo.png" alt = "Service Request System" style = "width:200px;height:150px"></img>
			<h1>Service Request System: Login</h1>
		</div>

	</br></br>

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

<!-- Login Button -->
<div class = "row">
	<div class = "col-lg-4"></div>
	<div class = "col-lg-4" align = "center">
		<div role = "button" class = "btn btn-success" onClick = "login()">Login</div>
	</div>
	<div class = "col-lg-4"></div>
</div><!-- End of login button -->
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