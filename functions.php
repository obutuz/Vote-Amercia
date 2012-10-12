<? /* http://vote.anewamercia.com */
$username=""; $password=""; $database="";$hostname = "";
include_once("connect.php");

/* tables: 
	votes (vote_id,vote_candidate,vote_time)
	users (user_id,user_netid,user_phone)
	log (log_id,log_type,log_message,user_id,log_time)
*/

require_once("twilio-php/Services/Twilio.php");

function doVote($election = 'election1', $phone, $message){
	$status = 'othererror'; $userid = 0;
	
	//connect to DB
	$mysqli = new mysqli($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
	if (mysqli_connect_errno()) {printf("Connect failed: %s\n", mysqli_connect_error()); return $status;}
	
	//split message into array of netid & candidate
	$msgarray = explode(" ", $message);
	
	//filter for string
	$netid = strtolower(filter_var($msgarray[0], FILTER_SANITIZE_STRING));
	if(strlen($netid) > 10 || strlen($netid) < 5){ 
		$sql = "INSERT INTO log VALUES (null,'error','invalid netid: $netid',null,null)";
		if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
		$status = "invalidnetid"; 
		return $status; 
		}
	$candidate = strtolower(filter_var($msgarray[1], FILTER_SANITIZE_STRING));
	if(strlen($candidate) > 30 || strlen($candidate) < 3){ 
		//log error
		$sql = "INSERT INTO log VALUES (null,'error','invalid candidate: $candidate',null,null)";
		if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
		$status = "invalidcandidate";
		return $status; 
		}
		
	//find user
	$sql = "SELECT * FROM users WHERE user_netid = '$netid'";
    if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
	$user = $result->fetch_array(MYSQLI_ASSOC);
	if (!$result->num_rows) {  
		$status = 'notinclass'; 
		//log error
		$sql = "INSERT INTO log VALUES (null,'error_user_not_found','$netid',null,null)";
		if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
		return $status;
	} else {
		$userid = $user["user_id"];	
	}
	
	//verify phone number
	if(!$user["user_phone"]){
		$sql = "UPDATE users SET user_phone = '$phone' WHERE user_id = $userid";
		if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
	} else {
		if($user["user_phone"] != $phone) { 
			$sql = "INSERT INTO log VALUES (null,'error_invalid_phone','$phone','$userid',null)";
			if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
			$status = 'invalidphone'; return $status; 
		}
	}
		
	//check for previous votes for user
	$sql = "SELECT * FROM users JOIN log ON users.user_id = log.user_id WHERE log_category = 'user_voted' AND log_message = '$election' AND users.user_id = '$userid'";
    if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
	    if ($result->num_rows > 0) {  
			$status = 'alreadyvoted'; 
			//log error
			$sql = "INSERT INTO log VALUES (null,'error_already_voted','attempt from: $phone',$userid,null)";
			if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
			return $status;
		}
	
	//add vote to db
	$mysqli->autocommit(FALSE);
	try {
		$q2 = $mysqli->prepare("INSERT INTO votes VALUES (null,?,null)");
		$q2->bind_param('s', $candidate);
		if (!$q2->execute()) throw new Exception("Cannot insert record. Reason :".$q2->error);
		$q1 = $mysqli->prepare("INSERT INTO log VALUES (null,'user_voted',?,?,null)");
		$q1->bind_param('si', $election, $userid);
		if (!$q1->execute()) throw new Exception("Cannot insert record. Reason :".$q1->error); 
		$mysqli->commit();
		$status = "votesuccess";
	} catch (Exception $e) {
		$mysqli->rollback();  	    
	}
	
	return $status;
}

?>