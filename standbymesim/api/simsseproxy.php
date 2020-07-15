<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

/**
 * Constructs the SSE data format and flushes that data to the client.
 *
 * @param string $id Timestamp/id of this connection.
 * @param string $msg Line of text that should be transmitted.
 */
//function sendMsg($id , $msg) {
function sendMsg($msg) {
	$jmsg = json_encode($msg);
	echo "data: {$jmsg}\n\n";	
/*	
  echo "data: {\n";
  echo "data: \"msg\": \"$msg\" \n";
  echo "data: }\n";
*/  
  echo PHP_EOL;
  ob_flush();
  flush();
}
function getinfo($result) {
		
}

$startedAt = time();
//connect to database
//local SDK
$mysqli = new mysqli('localhost','standbymeuser','qwerty','standbyme');
//remote SDK: replace  hostname or IP, username, password, dbname with appropriate values
//$mysqli = new mysqli('hostname or IP','username','password','dbname');
//extract info
$result = $mysqli -> query("SELECT * FROM proxy ORDER BY timestamp DESC");
//get numbers of proxy alarms
$numrow=$result->num_rows;
//transform result in JSON format
$msg['numrow']="$numrow";
for($i=0;$i<$numrow;$i++){
	$row = $result -> fetch_assoc();
	$msg['events'][$i]['mybtmac']=$row['mybtmac'];
	$msg['events'][$i]['otherbtmac']=$row['otherbtmac'];
	$msg['events'][$i]['timestamp']=$row['timestamp'];
	$msg['events'][$i]['status']=$row['status'];
}
//send first msg anyway
sendMsg($msg);  

do {	
  // Cap connections at 10 seconds. The browser will reopen the connection on close
  if ((time() - $startedAt) > 10) {
    die();
  }
  //count proxy record number	
  //extract info
  $result = $mysqli -> query("SELECT * FROM proxy  ORDER BY timestamp DESC");
  //get numbers of proxy alarms
  $newnumrow=$result->num_rows;
  //if new record update table
  if($newnumrow!=$numrow) { //number of row changed: send table
    $numrow=$newnumrow;
//transform result in JSON format
	$msg['numrow']="$newnumrow";
	for($i=0;$i<$numrow;$i++){
		$row = $result -> fetch_assoc();
		$msg['events'][$i]['mybtmac']=$row['mybtmac'];
		$msg['events'][$i]['otherbtmac']=$row['otherbtmac'];
		$msg['events'][$i]['timestamp']=$row['timestamp'];
		$msg['events'][$i]['status']=$row['status'];
	}
	sendMsg($msg);  
  }
  sleep(1);
  // If we didn't use a while loop, the browser would essentially do polling
  // every ~3seconds. Using the while, we keep the connection open and only make
  // one request.
} while(true);
?>