<?php
/**************************************************************
SIM UPDate PROXYmity
Update  backtracking (mac of this thing, other proxy thing and type of event 0=end alert, 1=start alert
requires following GET parameters
"mything": bt mac address of the current thing
"otherthing": bt mac addres of the other proxy thing
"status": type of event 0=end of alert, 1= start of alert
Create a new record in table proxy
Returns the global status of the updated thing as a string in JSON format:
{"response":"ok | ok","data":{"id":"bt_mac","status":"0|1","timestamp":"##########"} | "fail_desc" }
***************************************************************/
//extract GET parameters
$mything = $_REQUEST['mything'];
$otherthing = $_REQUEST['otherthing'];
$status = $_REQUEST['status'];
//connect to database
//local SDK
$mysqli = new mysqli('localhost','standbymeuser','qwerty','standbyme');
//remote SDK: replace  hostname or IP, username, password, dbname with appropriate values
//$mysqli = new mysqli('hostname or IP','username','password','dbname');
/*
$result = $mysqli -> query("SELECT * FROM thing WHERE btmac='$mything'");
$row = $result -> fetch_assoc();
//transform result in JSON format
$response['response']='ok';
$response['data']['id']=$row['id'];
$response['data']['btmac']=$row['btmac'];
$response['data']['wifimac']=$row['wifimac'];
$response['data']['status']=$row['status'];
$response['data']['timestamp']=$row['timestamp'];
*/
//if end alert find previous start alert and compute duration
$endev=0;
if($status==0) {//end alert: compute alert duration
  $result=$mysqli -> query("SELECT timestamp FROM proxy WHERE mybtmac='$mything' AND otherbtmac='$otherthing' AND status=1 ORDER BY timestamp DESC LIMIT 1");		
  $numrow=$result->num_rows;
  if($numrow>0) {
	$row = $result -> fetch_assoc();
	$strev=$row['timestamp'];
	$endev=time();
	$duration=$endev-$strev;
  }
  else { //no element found set 0
	  $duration=0;
  }
}
else { //start alert: alert duration=0
	$duration=0;
}
//insert new event record
$result = $mysqli -> query("INSERT INTO proxy(mybtmac,otherbtmac,timestamp,status,duration) VALUES('$mything','$otherthing',UNIX_TIMESTAMP(),$status,$duration)");
$response['response']='ok';
$response['data']['mybtmac']=$mything;
$response['data']['otherbtmac']=$otherthing;
$response['data']['status']=$status;
$response['data']['timestamp']=$endev;
$response['data']['duration']=$duration;
//send response to client in JSON format
header('Content-type: application/json');
echo json_encode($response);
?>
