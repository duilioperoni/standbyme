<?php
/**************************************************************
SIM RESET PROXYmity
Set current status of all bt to ok and delete all backtracking
no parameters
Update real time status of mything in table thing and delete all records in table proxy
Returns the global status of the updated thing as a string in JSON format:
{"response":"ok | ok"}
***************************************************************/
//connect to database
//local SDK
$mysqli = new mysqli('localhost','standbymeuser','qwerty','standbyme');
//remote SDK: replace  hostname or IP, username, password, dbname with appropriate values
//$mysqli = new mysqli('hostname or IP','username','password','dbname');
//update real time status
//update sensor value in related database record
//$ts=
$result = $mysqli -> query("UPDATE device SET status=0,timestamp=UNIX_TIMESTAMP() WHERE 1");
//extract current thing global status as an associative array
$result = $mysqli -> query("DELETE FROM proxy WHERE 1");
$response['response']='ok';
//send response to client in JSON format
header('Content-type: application/json');
echo json_encode($response);
?>
