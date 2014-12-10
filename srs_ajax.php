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


//Fetch Reports
if(isset($_REQUEST["fetchReports"])){
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
		$allArray[] = $queryResult["wid"];
		$allArray[] = $queryResult["tags"];

		$queryResult = mysql_fetch_assoc($queryRecent);
	}


	if(isset($_REQUEST["all"])){
		echo (json_encode($allArray));
	}

	else{
		$rArray = [];
		$count = 0;

//Store recent 5
		for($i = count($allArray)-1; $i >= 0; $i--){
			if($count <= 40){
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
}

//Fetch Singular Report
else if(isset($_REQUEST["fetchReport"])){
	$rid = $_REQUEST["rid"];

	$query = mysql_query("SELECT * from SRS_REPORT where rid = $rid", $link);
	$result = mysql_fetch_assoc($query);
	$rArray = Array();

$rArray[] = $result["reporter"];		//0
$rArray[] = $result["email"];			//1
$rArray[] = $result["location"];		//2
$rArray[] = $result["description"];		//3
$rArray[] = $result["status"];			//4
$rArray[] = $result["votes"];			//5
$rArray[] = $result["wid"];				//6
$rArray[] = $result["tags"];			//7

echo (json_encode($rArray));
}

//Single Worker
else if(isset($_REQUEST["fetchWorker"])){
	$wid = $_REQUEST["wid"];

	$query = mysql_query("SELECT name from SRS_WORKER where wid = $wid", $link);
	$result = mysql_fetch_assoc($query);
	$result = $result["name"];

	echo $result;
}

//All Workers
else if(isset($_REQUEST["fetchWorkers"])){
	$query = mysql_query("SELECT * from SRS_WORKER", $link);
	$result = mysql_fetch_assoc($query);
	$resultArray = Array();

	while($result){
		$resultArray[] = $result["wid"];
		$resultArray[] = $result["name"];

		$result = mysql_fetch_assoc($query);
	}

	echo (json_encode($resultArray));
}

//Save Report
else if(isset($_REQUEST["saveReport"])){
	$reporter = $_REQUEST["reporter"];
	$email = $_REQUEST["email"];
	$location = $_REQUEST["location"];
	$description = $_REQUEST["description"];
	$tags = $_REQUEST["tags"];

	$query = mysql_query("INSERT into SRS_REPORT(reporter, email, location, description, tags) values ('$reporter', '$email', '$location', '$description', '$tags')", $link);

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

//Update Report!
else if(isset($_REQUEST["updateReport"])){
	$rid = $_REQUEST["rid"];
	$status = $_REQUEST["status"];
	$wid = $_REQUEST["wid"];

	$query = mysql_query("UPDATE SRS_REPORT set status = '$status', wid = $wid where rid = $rid", $link);

	if($query)
		echo "True";
	else
		echo "False";
}

//Admin login
else if (isset($_REQUEST["adminLogin"])){
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	$query = mysql_query("SELECT * from SRS_ADMIN where username = '$username' and password = '$password'", $link);
	$rows = mysql_num_rows($query);

	if($rows >= 1){
		echo "True";
		session_start();
		$_SESSION["username"]=$username;
	}
	else
		echo  "False";
}

//User Login
else if (isset($_REQUEST["userLogin"])){
	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];

	$query = mysql_query("SELECT * from SRS_User where username = '$username' and password = '$password'",$link);

	if(mysql_num_rows($query) == 1){
		echo "True";
		session_start();
		$_SESSION["username"]=$username;
	}
	else
		echo "False";
}

//Post Comment
else if (isset($_REQUEST["addComment"])){
	$rid = $_REQUEST["rid"];
	$username = $_REQUEST["username"];
	$comment = $_REQUEST["comment"];

	$query = mysql_query("INSERT into SRS_Comment (rid, username, comment) values ('$rid', '$username', '$comment')",$link);

	if($query)
		echo "True";
	else
		echo "False";
}

//Fetch Comments
else if(isset($_REQUEST["fetchComments"])){
	$rid = $_REQUEST["rid"];
	$query = mysql_query("SELECT * from SRS_Comment where rid = '$rid'",$link);

	if($query){
		$result = mysql_fetch_assoc($query);
		$resultArray = Array();

		while($result){
			$resultArray[] = $result["username"];
			$resultArray[] = $result["comment"];
			$result = mysql_fetch_assoc($query);
		}
		echo (json_encode($resultArray));
	}
	else
		echo "False";
}


//Logout
else if(isset($_REQUEST["logout"])){
	session_start();
	session_destroy();
}

mysql_close($link);
?>