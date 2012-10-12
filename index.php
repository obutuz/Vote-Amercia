<? /* http://vote.anewamercia.com */
$username=""; $password=""; $database="";$hostname = "";
include_once("connect.php");
include_once("functions.php");
//print_r(doVote('testelection','23232323','otherab candidate1'));

$mysqli = new mysqli($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
if (mysqli_connect_errno()) {printf("Connect failed: %s\n", mysqli_connect_error()); return $status;}

echo "Users who voted:<br />";
$sql = "SELECT user_netid FROM log JOIN users ON users.user_id = log.user_id WHERE log_category = 'user_voted'";
if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
while($voted = $result->fetch_array(MYSQLI_ASSOC)){
	echo $voted["user_netid"]."<br />";
}
echo "<br /><br />";
print_r($voted);

echo "Users who haven't voted:<br />";
$sql = "SELECT user_netid FROM users LEFT JOIN log ON users.user_id = log.user_id WHERE log_id IS NULL";
if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
while($unvoted = $result->fetch_array(MYSQLI_ASSOC)){
	echo $unvoted["user_netid"]."<br />";
}
echo "<br /><br />";
print_r($voted);

$sql = "SELECT * FROM users WHERE user_netid = '$netid'";
if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
$wantes = $result->fetch_array(MYSQLI_ASSOC);
?>