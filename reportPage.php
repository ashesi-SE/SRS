<html>

<script src = "jquery/jquery.js"></script>
<script src = "js/bootstrap.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">

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

	if(reporter == "" || email == "" || location == "" || description == ""){
		var errorStr = '<div id = "status" class="alert alert-warning alert-dismissible" role="alert">Please fill all fields</div>';
		document.getElementById("status").innerHTML = errorStr;
	}

	else{
		var saveURL = localURL+"saveReport&reporter="+encodeURIComponent(reporter)+"&email="+email+"&location="+encodeURIComponent(location)+"&description="+encodeURIComponent(description);

		$.ajax({
			url: saveURL,
			async: false,
			success: function(response){
				if(response == "True")
					document.location = "index.php";
				else{
					var errorStr = '<div id = "status" class="alert alert-danger" role="alert">Error Saving Report!</div>';
					document.getElementById("status").innerHTML = errorStr;
				}

			}
		});
	}
}
</script>
<body style = "background-color: #D9D9D9">

	<div class = "col-lg-1"></div><div class = "col-lg-10" style="background-color: white">
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


<!--Location DropDown--><!--
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
</br>
-->

<!--Location Input-->
<div class = "input-group">
	<span class = "input-group-addon">Location:</span>
	<input type = "text" class = "form-control" id = "location" placeholder = "Enter location">
</div>
</br>

<!--Description-->
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

<div class = "row" align = "center">
	<div id = "status"> </div>
</div>

</br>

<!--Footer-->
<footer>
	<div align = "right">
		&copyTeam SRS
	</div>
</footer>

</div>
</div>
</body>
</html>