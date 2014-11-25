<?php
$database = "srsdb";
$username = "root";
$password = "";
$server = "localhost";

$link = mysql_connect($server, $username, $password);

if(!$link){
	echo " Failed Connection to MySQL!";
	echo mysql_error();
	exit();
}

if(!mysql_select_db($database, $link)){
	echo "Failed to select the database";
	echo mysql_error();
	exit();
}
?>

<html>
<link href="css/bootstrap.css" rel="stylesheet">
<script src = "jquery/jquery.js"></script>
<head>
	<title>SRS: Ashesi</title>
</head>
<script>
var localURL = "http://localhost/SRS/srs_ajax.php?";

function saveReport(){
	var reporter = document.getElementById("name").value;
	var email = document.getElementById("email").value;
	var location = document.getElementById("location").value;
	var description = document.getElementById("description").value;

	var saveURL = localURL+"saveReport&reporter="+encodeURIComponent(reporter)+"&email="+email+"&location="+encodeURIComponent(location)+"&description="+encodeURIComponent(description);

	$.ajax({
		url: saveURL,
		async: false,
		success: function(response){
			if(response == "True")
				document.location = "index.php";
			else
				document.getElementById("status").innerHTML = "Error Saving Report" + saveURL;

		}
	});
}
</script>
<body>


	<div class = "container-fluid">

		<div class = "row" align = "center">
			<img src = "images/logo.png" alt = "Service Request System" style = "width:200px;height:150px"></img>
		</div>

	</br></br>
	<div class = "row">
		Report Issue:
	</div>
</br>

<!--Issue Form-->
<div class = "row">
	<div class = "col-lg-2"></div>

	<div class = "col-lg-8">
		<div class = "input-group">
			<span class = "input-group-addon">Name:</span>
			<input type = "text" class = "form-control" id = "name" placeholder = "Enter Your Name">
		</div>
	</br>
	<div class = "input-group">
		<span class = "input-group-addon">Email:</span>
		<input type = "text" class = "form-control" id = "email" placeholder = "example@ashesi.edu.gh">
	</div>
</br>
<!--
<div class = "input-group">
<span class = "input-group-addon">Location:</span>
<div class = "input-group-button">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">LH 218 <span class="caret"></span></button>
<ul class="dropdown-menu dropdown-menu-right" role="menu">
<li><a href="#">LH 217</a></li>
<li><a href="#">LH 216</a></li>
<li><a href="#">LH 218</a></li>
</ul>
</div>

</div>
-->

<div class = "input-group">
	<span class = "input-group-addon">Location:</span>
	<input type = "text" class = "form-control" id = "location" placeholder = "Enter location">
</div>

</br>
<div class = "input-group">
	<span class = "input-group-addon">Description:</span>
	<input type = "text" class = "form-control" id = "description" placeholder = "Enter a description of the issue">
</div>

</div>
<div class = "col-lg-2"></div>

</div>

</br></br>

<!--Report Button Below-->
<div class = "row">
	<div class = "col-lg-5"></div>
	<div class = "col-lg-2">
		<div role = "button" class = "btn btn-success" onClick = "saveReport()">Save</div>
		<a href = "index.php" role = "button" class = "btn btn-danger">Cancel</a>
	</div>
	<div class = "col-lg-5"></div>
</div>

</br>

<div class = "row">
	<div id = "status">Status: </div>
</div>

</br>

<footer>
	<div align = "right">
		&copyTeam SRS
	</div>
</footer>

</div>
</body>
</html>

<?php
mysql_close($link);
?>