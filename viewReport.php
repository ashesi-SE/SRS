<?php
session_start();
if(isset($_REQUEST["rid"])){
	$rid = $_REQUEST["rid"];

	if(isset($_SESSION["username"]))
		$username = $_SESSION["username"];
}

else{
	header("Location: index.php");
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
var username = '<?php echo $username; ?>';
var setStatus;
var setWorker;

$(document).ready(function () {
	fetchInfo();
	fetchComments();

	if(username != "" || username != null)
		cBox();
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

//Fetch report information
function fetchInfo(){
	var info = syncAjax("fetchReport&rid="+rid);
	var rArray = JSON.parse(info);

	document.getElementById("name").placeholder = rArray[0];
	document.getElementById("email").placeholder = rArray[1];
	document.getElementById("location").placeholder = rArray[2];
	document.getElementById("description").placeholder = rArray[3];
	document.getElementById("reportStatus").placeholder= rArray[4];
	document.getElementById("tags").placeholder = rArray[7];
}


//Fetch Comments
function fetchComments(){
	var c = syncAjax("fetchComments&rid="+rid);

	if(c != "False" && c != ""){
		cArray = JSON.parse(c);
		var comments = document.getElementById("comments");
		var cInfo = '<div id = "comments">';

		for(var x = 0; x < cArray.length; x++){
			cInfo += '<b>'+cArray[x]+'</b>: '+cArray[x+1];
			cInfo += '</br>';
			x++;
		}

		cInfo += '</div>';
		comments.innerHTML=cInfo;
	}
}

//Add comment
function addComment(){
	var comment = document.getElementById("comment").value;
	var addComment = syncAjax("addComment&rid="+rid+"&username="+username+"&comment="+encodeURIComponent(comment));

	if(addComment == "True"){
		fetchComments();
		document.getElementById("comment").value = "";
	}
	else
		alert("Failed to post comment!");
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

function cBox(){
	var cBox = document.getElementById("commentBox");
	var cbInfo = '<div id = "commentBox" align = "left"><div class="form-group"><label for="comment">Posting as: <b>'+username+'</b></label>'
	+'<input type="text" class="form-control input-md" id = "comment"placeholder = "Enter comment here"></div></div>';

	cBox.innerHTML = cbInfo;

}

//Logout
function logout(){
	var x = syncAjax("logout");
	document.location = "index.php";
}
</script>

<body>

	<body style = "background-color: #D9D9D9">

		<div class = "container-fluid">
			<div class = "col-lg-1"></div><div class = "col-lg-10" style="background-color: white">
			<div class = "row" align = "center">
				<img src = "images/logo.png" alt = "Service Request System" style = "width:200px;height:150px"></img>
			</div>

		</br></br>

		<div class = "row"><!--First row-->
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
		<div class = "input-group">
			<span class = "input-group-addon">Location:</span>
			<input type = "text" class = "form-control" id = "location" placeholder = "None" disabled>
		</div>
	</br>
	<div class = "input-group">
		<span class = "input-group-addon">Description:</span>
		<input type = "text" class = "form-control" id = "description" placeholder = "None" disabled>
	</div>
</br>


<!--Report Status-->
<div class = "input-group">
	<span class = "input-group-addon">Status:</span>
	<input type = "text" class = "form-control" id = "reportStatus" placeholder = "None" disabled>
</div>

	</br>
	<div class = "input-group">
		<span class = "input-group-addon">Tags:</span>
		<input type = "text" class = "form-control" id = "tags" placeholder = "None" disabled>
	</div>

</br>
</div>
</div><!--End first row-->

</br>
<!--Comments-->
<div class = "row" align = "left">
	<div class = "col-lg-2"></div>
	<div class = "col-lg-8">
		<h1>Comments</h1>
		<hr class = "divider">
		<div id = "comments">No Comments Yet!</div>
	</div>
</div>

</br>

<!--Comment Box-->
<div class = "row" align = "center">
	<div class = "col-lg-2"></div>
	<div class = "col-lg-8">
		<hr class = "divider">
		<div id = "commentBox"></div>
	</div>
	<div class = "col-lg-2"></div>
</div>



<!--Status Bar-->
<div class = "row" align = "center">
	<div id = "status"> </div>
</div>
</br>


<!--Save Button-->
<div class = "row" align = "center">
	<div class = "col-lg-4"></div>
	<div class = "col-lg-4">
		<div role = "button" class = "btn btn-success" onClick = "addComment()">Save</div>
		<a href = "index.php" role = "button" class = "btn btn-danger">Cancel</a>
	</div>
	<div class = "col-lg-4"></div>
</div>
</br>


</br>
</br>

<div class = "row">
	<div class = "col-lg-2"></div>
	<div class = "col-lg-8" align = "right">
		<div role = "button" class = "btn btn-danger" onclick = "logout()"><span class = "glyphicon glyphicon-off"></span> Logout</div>
	</div>
</div>

<footer>
	<div class = "row" align = "right">
		<div class = "col-lg-2"></div>
		<div class = "col-lg-8">
			&copyTeam SRS
		</div>
	</div>
</footer>

</div>
</div>

</body>
</html>