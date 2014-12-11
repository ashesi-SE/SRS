<?php
session_start();
//if(!$_SESSION["user"])
//header("Location: adminLogin.php");

?>
<html>
<link href="css/bootstrap.css" rel="stylesheet">
<script src = "jquery/jquery.js"></script>
<script src = "js/jquery.dataTables.js"></script>
<script src = "js/jquery.dataTables.min.js"></script>
<link href="css/jquery.dataTables.css" rel="stylesheet">
<link href="css/jquery.dataTables.min.css" rel="stylesheet">
<link href="css/jquery.dataTables_themeroller.css" rel="stylesheet">

<head>
	<title>SRS: Admin Panel</title>
</head>

<script>
var localURL = "http://localhost/SRS/srs_ajax.php?";

$(document).ready(function () {
	updateReportTable();
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


//Update Recent Reports table
function updateReportTable(){
	var rt = document.getElementById("reportTable");
	var rtInfo;

	var x = syncAjax("fetchReports&all");

	var rData = JSON.parse(x);	

	if(rData.length > 0){
		rtInfo = '<div id = "reportTable">';
		rtInfo += '<table id = "dataTable" class = "table table-striped"><thead>';
		rtInfo += '<tr><th>Report ID</th><th>Reporter</th><th>Location</th><th>Description</th><th>Status</th><th>Votes</th><th align = "center">Assigned To</th></tr></thead><tbody>';

		for(x = 0; x < rData.length; x++){
			rtInfo += '<tr style = "cursor:hand;" onclick = edit(\''+rData[x]+'\')><td>'+rData[x]+'</td><td>'+rData[x+1]+'</td><td>'+rData[x+2]+'</td><td>'+rData[x+3]+'</td><td>';

			if(rData[x+4] == "Unresolved")
				rtInfo+='<span class="label label-danger">'+rData[x+4]+'</span>';
			else if (rData[x+4] == "Pending")
				rtInfo+='<span class="label label-warning">'+rData[x+4]+'</span>';
			else if (rData[x+4] == "Resolved")
				rtInfo+='<span class="label label-success">'+rData[x+4]+'</span>';

//Fetch Worker name
var workerName = syncAjax("fetchWorker&wid="+rData[x+6]);
rtInfo+='</td><td align = "center"><span class = "badge">'+rData[x+5]+'</span></td><td align = "center">'+workerName+'</td></tr>';

x+=7;
}

rtInfo += '</tbody></table>';
rtInfo += '</div>'; 
rt.innerHTML = rtInfo;
}

$(document).ready(function () {
	$("#dataTable").DataTable();
});

}

//Edit Page
function edit(rid){
	document.location = "adminPanel_edit.php?rid="+rid;
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


function logout(){
	var logout = '<?php session_destroy(); ?>';
	document.location = "adminLogin.php";
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
					<li class="active"><a href="adminPanel.php">Home</a></li>
					<li class = "divider"></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class = "row" align = "center">
		<div class = "col-lg-2"></div>
		<div class = "col-lg-8"><div id = "reportTable"></div></div>
		<div class = "col-lg-2"></div>
	</div>
</br></br></br>

<div class = "row" align = "center">
	<div class = "col-lg-5"></div>
	<div class = "col-lg-2">
		<button class = "btn btn-danger" onclick = "logout()">Logout</div>
		</div>
		<div class = "col-lg-5"></div>
	</div>

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