<?
$username=""; $password=""; $database="";$hostname = "";
include_once("connect.php");
include_once("functions.php");
$election = "testelection";

$mysqli = new mysqli($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
if (mysqli_connect_errno()) {printf("Connect failed: %s\n", mysqli_connect_error()); return $status;}

$sql = "SELECT user_netid FROM log JOIN users ON users.user_id = log.user_id WHERE log_category = 'user_voted' AND log_message = '$election'";
if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
$sql1 = "SELECT COUNT(*) FROM users";
if(!$result1 = $mysqli->query($sql1)) die('There was an error running the query [' . $mysqli->error . ']');
$res = $result1->fetch_array(MYSQLI_NUM);

$sql2 = "SELECT COUNT(*) FROM votes WHERE vote_candidate = 'candidate1'";
if(!$result2 = $mysqli->query($sql2)) die('There was an error running the query [' . $mysqli->error . ']');
$res2 = $result2->fetch_array(MYSQLI_NUM); 
$candidate1_count = $res2[0];

$sql3 = "SELECT COUNT(*) FROM votes WHERE vote_candidate = 'candidate2'";
if(!$result3 = $mysqli->query($sql3)) die('There was an error running the query [' . $mysqli->error . ']');
$res3 = $result3->fetch_array(MYSQLI_NUM); 
$candidate2_count = $res3[0];

$sql4 = "SELECT COUNT(*) FROM votes WHERE vote_candidate = 'candidate3'";
if(!$result4 = $mysqli->query($sql4)) die('There was an error running the query [' . $mysqli->error . ']');
$res4 = $result4->fetch_array(MYSQLI_NUM); 
$candidate3_count = $res4[0];

$sql5 = "SELECT COUNT(*) FROM votes WHERE vote_candidate = 'candidate4'";
if(!$result5 = $mysqli->query($sql5)) die('There was an error running the query [' . $mysqli->error . ']');
$res5 = $result5->fetch_array(MYSQLI_NUM); 
$candidate4_count = $res5[0];

$sql6 = "SELECT COUNT(*) FROM votes WHERE vote_candidate = 'candidate5'";
if(!$result6 = $mysqli->query($sql6)) die('There was an error running the query [' . $mysqli->error . ']');
$res6 = $result6->fetch_array(MYSQLI_NUM); 
$candidate5_count = $res6[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Google Visualization API Sample
    </title>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
    function drawVisualization() {
  // Create and populate the data table.
  var data = google.visualization.arrayToDataTable([
    ['Year', 'Candidate1', 'Candidate2', 'Candidate3', 'Candidate4'],
    ['<? echo $election; ?>',  <? echo $candidate1_count; ?>,    <? echo $candidate2_count; ?>,    <? echo $candidate3_count; ?>,   <? echo $candidate4_count; ?>]  ]);

  // Create and draw the visualization.
  new google.visualization.BarChart(document.getElementById('visualization')).
      draw(data,
           {title:"Primary Votes, by Election",
            width:600, height:400,
            vAxis: {title: ""},
            hAxis: {title: "Votes"}}
      );
}
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <body style="font-family: Arial;border: 0 none;">
  <p>Text "[NETID] [CANDIDATE]" to (315) 605-0277</p>
    <div id="visualization" style="width: 600px; height: 400px;"></div>

<? /* http://vote.anewamercia.com */
//print_r(doVote('testelection','23232323','otherab candidate1'));
echo "Users who voted in $election (".$result->num_rows."/".$res[0]."):<br />";
while($voted = $result->fetch_array(MYSQLI_ASSOC)){
	echo $voted["user_netid"]."<br />";
}

echo "<br /><br />";
print_r($voted);

$sql = "SELECT * FROM users WHERE user_netid = '$netid'";
if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
$wantes = $result->fetch_array(MYSQLI_ASSOC);
?>
  </body>
</html>