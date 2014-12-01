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

if(isset($_REQUEST["fetchRecent"])){
	$queryRecent = mysql_query("select * from SRS_REPORT", $link);
	$queryResult = mysql_fetch_assoc($queryRecent);

	$allArray = [];

	while($queryResult){
		$allArray[] = $queryResult["rid"];
		$allArray[] = $queryResult["reporter"];
		$allArray[] = $queryResult["location"];
		$allArray[] = $queryResult["description"];
		$allArray[] = $queryResult["status"];
		$allArray[] = $queryResult["votes"];

		$queryResult = mysql_fetch_assoc($queryRecent);
	}

	$rArray = [];
	$count = 0;

	for($i = count($allArray)-1; $i >= 0; $i--){
		if($count <= 30){
			$rArray[] = $allArray[$i];
			$count++;
		}
		else
			break;
	}

//Reverse Array
	$recentArray = [];

	for($x = count($rArray)-1; $x >= 0; $x--){
		$recentArray[] = $rArray[$x];
	}

	echo(json_encode($recentArray));
}


//Save Report
else if(isset($_REQUEST["saveReport"])){
	$reporter = $_REQUEST["reporter"];
	$email = $_REQUEST["email"];
	$location = $_REQUEST["location"];
	$description = $_REQUEST["description"];

	$query = mysql_query("INSERT into SRS_REPORT(reporter, email, location, description) values ('$reporter', '$email', '$location', '$description')", $link);

	if($query)
		echo "True";
	else
		echo "False";
}

//Upvote
else if (isset($_REQUEST["upvote"])){
	$rid = $_REQUEST["rid"];
	$query = mysql_query("UPDATE SRS_REPORT SET votes = (votes + 1) where rid = $rid", $link);

	if($query)
		echo "True";
	else
		echo "False";
}

//Downvote
else if (isset($_REQUEST["downvote"])){
	$rid = $_REQUEST["rid"];
	$query = mysql_query("UPDATE SRS_REPORT SET votes = (votes - 1) where rid = $rid", $link);

	if($query)
		echo "True";
	else
		echo "False";
}
mysql_close($link);
?>