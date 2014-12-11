<?php
//session_start();
if(isset($_REQUEST["rid"])){
	$rid = $_REQUEST["rid"];
}

else{
	header("Location: adminPanel.php");
}
?>

<html>
<script src = "jquery/jquery.js"></script>
<script src = "js/bootstrap.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">
<head>
	<title>SRS: Admin Panel</title>
</head>

<script>
var localURL = "http://localhost/SRS/srs_ajax.php?";
var rid = "<?php echo $rid; ?>";
var setStatus;
var setWorker;

$(document).ready(function () {
	fetchInfo();
	$('dropdown-toggle').dropdown();
});

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


function fetchInfo(){
	var info = syncAjax("fetchReport&rid="+rid);
	var rArray = JSON.parse(info);

	document.getElementById("name").placeholder = rArray[0];
	document.getElementById("email").placeholder = rArray[1];
	document.getElementById("location").placeholder = rArray[2];
	document.getElementById("description").placeholder = rArray[3];
	document.getElementById("tags").placeholder = rArray[7];

//Status Info
	var rsInfo = '<div id = "reportStatus"><form name = "status"><div class = "input-group"><span class = "input-group-addon">Status:'
	+'</span><div class = "input-group-button">'
	+'<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">'+ rArray[4]+ ' <span class="caret"></span></button>'
	+'<ul class="dropdown-menu dropdown-menu-left">';
	rsInfo+='<li><a href="#">Unresolved</a></li><li><a href="#">Pending</a></li><li><a href="#">Resolved</a></li><li>';
	rsInfo += '</ul></div></form></div>';

	document.getElementById("reportStatus").innerHTML = rsInfo;

setStatus = rArray[4];


//Worker Info
var workerID = rArray[6];
var wInfo = syncAjax("fetchWorker&wid="+workerID);

var wsInfo = syncAjax("fetchWorkers");
var wsArray = JSON.parse(wsInfo);

var rwInfo = '<div id = "reportWorker"><form name = "Worker"><div class = "input-group" id = "test"><span class = "input-group-addon">Worker:'
	+'</span><div class = "input-group-button">'
	+'<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><div id = "worker">'+wInfo+ ' <span class="caret"></span></div></button>'
	+'<ul class="dropdown-menu dropdown-menu-left">';
	for(var w = 0; w < wsArray.length; w++){
			rwInfo += '<li><a href = "#">'+wsArray[w+1]+'</a></li>';
		w++;
	}
	rwInfo += '</ul></div></form></div>';

	document.getElementById("reportWorker").innerHTML = rwInfo;

//Update setWorker variable from name to Worker ID
setWorker = wInfo;
for(var z = 0; z < wsArray.length; z++){
			if(setWorker == wsArray[z+1]){
				setWorker = wsArray[z];
				break;
			}
			z++;
		}

//Dropdown function
$(".dropdown-menu li a").click(function(){
	var selText = $(this).text();
	$(this).parents('.input-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');

	if(selText == "Unresolved" || selText == "Pending" || selText == "Resolved")
		setStatus = selText;
	else{
		setWorker = selText;
		for(var z = 0; z < wsArray.length; z++){
			if(setWorker == wsArray[z+1]){
				setWorker = wsArray[z];
				break;
			}
			z++;
		}
	}
});
}


function updateReport(){
	var update = syncAjax("updateReport&rid="+rid+"&status="+setStatus+"&wid="+setWorker);
	if(update == "False")
		alertStatus("error", "Update of Record failed!");
	else
		document.location = "adminPanel.php";
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

<body>

	<!--Nav Bar-->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand">Admin Panel</a>
			</div>
			<!--Home-->
			<div>
				<ul class="nav navbar-nav">
					<li><a href="adminPanel.php">Home</a></li>
					<li class = "divider"></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class = "row">
		<div class = "col-lg-2"></div>

		<div class = "col-lg-8">
			<div class = "input-group">
				<span class = "input-group-addon">Name:</span>
				<input type = "text" class = "form-control" id = "name" placeholder = "Anonymous" disabled>
			</div>
		</br>
		<div class = "input-group">
			<span class = "input-group-addon">Email:</span>
			<input type = "text" class = "form-control" id = "email" placeholder = "No Email Provided" disabled>
		</div>
	</br>

	<!--Location Input-->
	<div class = "input-group">
		<span class = "input-group-addon">Location:</span>
		<input type = "text" class = "form-control" id = "location" placeholder = "None" disabled>
	</div>
</br>

<!--Description-->
<div class = "input-group">
	<span class = "input-group-addon">Description:</span>
	<input type = "text" class = "form-control" id = "description" placeholder = "None" disabled>
</div>
</br>

<!--Tags-->
<div class = "input-group">
	<span class = "input-group-addon">Tags:</span>
	<input type = "text" class = "form-control" id = "tags" placeholder = "None" disabled>
</div>
</br>


<!--Report Status-->
<div id = "reportStatus">
</div>

<!--Report Worker-->
<div id = "reportWorker">
</div>
</br>

<!--Status Bar-->
<div class = "row" align = "center">
	<div id = "status"> </div>
</div>
</br>


<!--Save Button-->
<div class = "row">
	<div class = "col-lg-5"></div>
	<div class = "col-lg-2">
		<div role = "button" class = "btn btn-success" onClick = "updateReport()">Save</div>
		<a href = "adminPanel.php" role = "button" class = "btn btn-danger">Cancel</a>
	</div>
	<div class = "col-lg-5"></div>
</div>
</br>


</br></br></br>
<footer>
	<div class = "row" align = "right">
		<div class = "col-lg-8"></div>
		<div class = "col-lg-2">
			&copyTeam SRS
		</div>
		<div class = "col-lg-2"></div>
	</div>
</footer>

</body>
</html>