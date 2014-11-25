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

$queryRecent = mysql_query("select * from SRS_REPORT", $link);
$queryResult = mysql_fetch_assoc($queryRecent);

$recentArray = [];

while($queryResult){
	$recentArray[] = $queryResult["rid"];
	$recentArray[] = $queryResult["reporter"];
	$recentArray[] = $queryResult["location"];
	$recentArray[] = $queryResult["description"];
	$recentArray[] = $queryResult["status"];

	$queryResult = mysql_fetch_assoc($queryRecent);
}
?>

<html>
<link href="css/bootstrap.css" rel="stylesheet">
<script src = "jquery/jquery.js"></script>
<head>
	<title>SRS: Ashesi</title>
</head>

<script>
	$(document).ready(function () {
		updateRecent();
	});

	function updateRecent(){
		var rt = document.getElementById("recentTable");
		var rtInfo;
		var rData = JSON.parse('<?php echo json_encode($recentArray); ?>');	

		if(rData.length > 0){
			rtInfo = '<div id = "recentTable">';
			rtInfo += '<table class = "table table-striped"><tbody>';
			rtInfo += '<tr><th>Report ID</th><th>Reporter</th><th>Location</th><th>Description</th><th>Status</th></tr>';

			for(x = 0; x < rData.length; x++){
				rtInfo += '<tr><td>'+rData[x]+'</td><td>'+rData[x+1]+'</td><td>'+rData[x+2]+'</td><td>'+rData[x+3]+'</td><td>'+rData[x+4]+'</td></tr>';

				x+=4;
			}

			rtInfo += '</tbody></table>';
     		rtInfo += '</div>'; 
     		rt.innerHTML = rtInfo;
		}
	}
</script>

<body>


<div class = "container-fluid">

	<div class = "row" align = "center">
		<img src = "images/logo.png" alt = "Service Request System" style = "width:200px;height:150px"></img>
	</div>

</br></br>
<div class = "row" align = "left">
	Recent Reports
</div>
</br>

<div class = "row">
	<div class = "col-lg-2"></div>
	<div class = "col-lg-8">
			
			<div id = "recentTable">
			</div>

	</div>
</div>
<div class = "col-lg-2"></div>
</div>

</br></br>

<!--Report Button Below-->
<div class = "row" align = "center">
	<div class = "col-lg-5"></div>
	<div class = "col-lg-2">
		<a href = "reportPage.php" role = "button" class = "btn btn-primary">Report Issue</a>
	</div>
	<div class = "col-lg-5"></div>
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