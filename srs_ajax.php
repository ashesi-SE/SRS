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

if(isset($_REQUEST["saveReport"])){
	$reporter = $_REQUEST["reporter"];
	$email = $_REQUEST["email"];
	$location = $_REQUEST["location"];
	$description = $_REQUEST["description"];

	$query = mysql_query("insert into SRS_REPORT(reporter, email, location, description) values ('$reporter', '$email', '$location', '$description')", $link);

	if($query)
		echo "True";
	else
		echo "False";
}

mysql_close($link);
?>