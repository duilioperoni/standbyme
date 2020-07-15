<?php
/**************************************************************
SIM UPDate STATUS
Update current status (ok=0 or alert=1) 
requires following GET parameters
"thing": bt mac address of the current thing
"status": type of event 0=end of alert, 1= start of alert
Update real time status of thing in table thing
Returns the global status of the updated thing as a string in JSON format:
{"response":"ok | ok","data":{"id":"bt_mac","status":"0|1","timestamp":"##########"} | "fail_desc" }
***************************************************************/
//extract GET parameters
$thing = $_REQUEST['thing'];
$status = $_REQUEST['status'];
//connect to database
//local SDK
$mysqli = new mysqli('localhost','standbymeuser','qwerty','standbyme');
//remote SDK: replace  hostname or IP, username, password, dbname with appropriate values
//$mysqli = new mysqli('hostname or IP','username','password','dbname');
//update real time status
//update sensor value in related database record
//$ts=
$result = $mysqli -> query("UPDATE device SET status=$status,timestamp=UNIX_TIMESTAMP() WHERE btmac='$thing'");
//extract current thing global status as an associative array
$result = $mysqli -> query("SELECT * FROM device WHERE btmac='$thing'");
$row = $result -> fetch_assoc();
//transform result in JSON format
$response['response']='ok';
$response['data']['id']=$row['id'];
$response['data']['btmac']=$row['btmac'];
$response['data']['wifimac']=$row['wifimac'];
$response['data']['status']=$row['status'];
$response['data']['timestamp']=$row['timestamp'];
//send response to client in JSON format
header('Content-type: application/json');
echo json_encode($response);
?>
