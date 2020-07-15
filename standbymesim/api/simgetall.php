<?php
/**************************************************************
SIM GET ALL (things)
Extract all things stored in database
No parameters
Returns all things status as a JSON array:
{"response":"ok","data":[{"id":"id_code","description":"descr_id","type:"M|W|H|A","status":"0|1|2|3","sensore:"0|1","timestamp":"##########"}, ...]} | "fail_desc" }
***************************************************************/
//connect to database
//local SDK
$mysqli = new mysqli('localhost','standbymeuser','qwerty','standbyme');
//remote SDK: replace  hostname or IP, username, password, dbname with appropriate values
//$mysqli = new mysqli('hostname or IP','username','password','dbname');
//extract info
$result = $mysqli -> query("SELECT * FROM device");
//get numbers of things
$numrow=$result->num_rows;
//transform result in JSON format
$response['response']='ok';
for($i=0;$i<$numrow;$i++){
	$row = $result -> fetch_assoc();
	$response['response']='ok';
	$response['data'][$i]['id']=$row['id'];
	$response['data'][$i]['btmac']=$row['btmac'];
	$response['data'][$i]['wifimac']=$row['wifimac'];
	$response['data'][$i]['status']=$row['status'];
	$response['data'][$i]['timestamp']=$row['timestamp'];
}
//send response to client in JSON format
header('Content-type: application/json');
echo json_encode($response);
?>