<?php
/**************************************************************
SIM GET BACKTRACE (history of alerts of a student)
Extract all proxy alerts related to a student in a fixed period stored in database
requires following GET parameters
"thing": bt mac of address of the requested thing
"strtime": start time of backtracing in unix time format (optional)
"endtime": end time of backtracing in unix time format (optional)
Returns all alerts status as a JSON array:
{"response":"ok","data":[{"mybtmac":"############","otherbtmac":"############","timestamp":"##########"}, ...]} | "fail_desc" }
***************************************************************/
//extract GET parameters
$thing = $_REQUEST['thing'];
if(isset($_REQUEST['strtime'])) $strtime = $_REQUEST['strtime'];
else 							$strtime = 0;
if(isset($_REQUEST['endtime'])) $endtime = $_REQUEST['endtime'];
else 							$endtime = 9999999999;
//connect to database
//local SDK
$mysqli = new mysqli('localhost','standbymeuser','qwerty','standbyme');
//remote SDK: replace  hostname or IP, username, password, dbname with appropriate values
//$mysqli = new mysqli('hostname or IP','username','password','dbname');
//extract info
$result = $mysqli -> query("SELECT 	t1.id myid,
									t1.btmac mymac,
									(SELECT DISTINCT t3.id 
										FROM device t3,proxy t4 
										WHERE t3.btmac=t4.otherbtmac 
										AND t4.otherbtmac=t2.otherbtmac) othid,
										t2.otherbtmac othmac,
										t2.status st,
										t2.timestamp ts, 
										t2.duration dur 
							FROM   device t1, proxy t2 
							WHERE  t1.btmac=t2.mybtmac 
							AND    t2.mybtmac='$thing' 
							AND    t2.timestamp>=$strtime
							AND    t2.timestamp<=$endtime
							ORDER BY t2.timestamp");
//get numbers of things
$numrow=$result->num_rows;
//transform result in JSON format
$response['response']='ok';
for($i=0;$i<$numrow;$i++){
	$row = $result -> fetch_assoc();
	$response['response']='ok';
	$response['data'][$i]['myid']=$row['myid'];
	$response['data'][$i]['mymac']=$row['mymac'];
	$response['data'][$i]['othid']=$row['othid'];
	$response['data'][$i]['othmac']=$row['othmac'];
	$response['data'][$i]['st']=$row['st'];
	$response['data'][$i]['ts']=$row['ts'];
	$response['data'][$i]['dur']=$row['dur'];
}
//send response to client in JSON format
header('Content-type: application/json');
echo json_encode($response);
?>