<html>
<link href="css/bootstrap.css" rel="stylesheet">
<script src = "jquery/jquery.js"></script>
<head>
	<title>SRS: Ashesi</title>
</head>

<script>
var localURL = "http://localhost/SRS/srs_ajax.php?";

$(document).ready(function () {
	updateRecent();
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
function updateRecent(){
	var rt = document.getElementById("recentTable");
	var rtInfo;

	var x = syncAjax("fetchRecent");

	var rData = JSON.parse(x);	

	if(rData.length > 0){
		rtInfo = '<div id = "recentTable">';
		rtInfo += '<table class = "table table-striped"><tbody>';
		rtInfo += '<tr><th>Report ID</th><th>Reporter</th><th>Location</th><th>Description</th><th>Status</th><th>Vote</th></tr>';

		for(x = 0; x < rData.length; x++){
			rtInfo += '<tr><td>'+rData[x]+'</td><td>'+rData[x+1]+'</td><td>'+rData[x+2]+'</td><td>'+rData[x+3]+'</td><td>';

			if(rData[x+4] == "Unresolved")
				rtInfo+='<span class="label label-danger">'+rData[x+4]+'</span>';
			else if (rData[x+4] == "Pending")
				rtInfo+='<span class="label label-warning">'+rData[x+4]+'</span>';
			else if (rData[x+4] == "Resolved")
				rtInfo+='<span class="label label-success">'+rData[x+4]+'</span>';
			rtInfo+='</td><td>'
			+ '<span class = "glyphicon glyphicon-thumbs-up" onclick = "upvote(\''+rData[x]+'\')" style = "cursor: hand;"></span>   '
			+ '<span class = "glyphicon glyphicon-thumbs-down" onclick = "downvote(\''+rData[x]+'\')" style = "cursor: hand;"></span>    '
			+ '<span class = "badge">'+rData[x+5]+'</span></td></tr>';

			x+=5;
		}

		rtInfo += '</tbody></table>';
		rtInfo += '</div>'; 
		rt.innerHTML = rtInfo;
	}
}

//Upvote
function upvote(rid){
	var up = syncAjax("upvote&rid="+rid);
	var errorStr = '<div id = "status" class="alert alert-warning alert-dismissible" role="alert">Failed to Vote</div>';
	var successStr = '<div id = "status" class="alert alert-success alert-dismissible" role="alert">Upvoted Succesfully</div>';

	if(up == "True")
		alertStatus("success", "Upvoted Succesfully");
	else
		alertStatus("error", "Failed to Vote!");

	updateRecent();
}

//Downvote
function downvote(rid){
	var down = syncAjax("downvote&rid="+rid);

	if(down == "True")
		alertStatus("success", "Downvoted Succesfully");
	else
		alertStatus("error", "Failed to Vote!");

	updateRecent();
}

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
		</div>

	</br></br>
	<div class = "row" align = "left">
		<div class = "col-lg-2"></div>
		Recent Reports
	</div>
</br>

<!-- Recent Table -->
<div class = "row">
	<div class = "col-lg-2"></div>
	<div class = "col-lg-8">
		<div id = "recentTable"></div>
	</div>
</div>

</br></br></br>

<!--Status-->
<div class = "row" align = "center">
	<div id = "status"> </div>
</div>
</br></br></br>

<!--Report Button Below-->
<div class = "row" align = "center">
	<div class = "col-lg-5"></div>
	<div class = "col-lg-2">
		<a href = "reportPage.php" role = "button" class = "btn btn-primary">Report Issue</a>
	</div>
	<div class = "col-lg-5"></div>
</div>

</br>
</br>
</br>

<footer>
	<div class = "row" align = "right">
		<div class = "col-lg-8"></div>
		<div class = "col-lg-2">
			&copyTeam SRS
		</div>
		<div class = "col-lg-2"></div>
	</div>
</footer>

<div class = "col-lg-1"></div>
</div>
</div>
</body>
</html>