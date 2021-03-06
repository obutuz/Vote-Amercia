<?
if(isset($_GET['refresh'])) $refresh = 2;
$electionid = 2;
if(isset($_GET['id'])) $electionid = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$username=""; $password=""; $database="";$hostname = "";
include_once("connect.php");
include_once("functions.php");
$election = "amercia";
$mysqli = new mysqli($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
if (mysqli_connect_errno()) {printf("Connect failed: %s\n", mysqli_connect_error()); return $status;}

$sql = "select election_keyword from elections where election_id = $electionid";
if(!$result = $mysqli->query($sql)) die('There was an error running the query [' . $mysqli->error . ']');
$row = $result->fetch_array(MYSQLI_NUM);
$keyword = $row[0];
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <title>Vote!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 0; /* 60px to make the container go all the way to the bottom of the topbar */
      }
      h3 {
	      line-height: 25px;
	      padding: 5px 0 10px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
       <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
       <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
        <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
    var chart1 = null, chart2 = null, data = null, data2 = null, jsonData = null, jsonData2 = null, dataArray = null, dataArray2 = null, v1width = $('#visualization').width(),v2width = $('#visualization2').width();
    function drawVisualization() {
  // Create and populate the data table.
  jsonData = $.ajax({
	  url: "json.php?election=<? echo $electionid; ?>",
	  dataType: "json",
	  async: false
  }).responseText;
  jsonData2 = $.ajax({
	  url: "json.php?election=<? echo $electionid; ?>&userstatus",
	  dataType: "json",
	  async: false
  }).responseText;
dataArray = JSON.parse(jsonData);
dataArray2 = JSON.parse(jsonData2);
    data = google.visualization.arrayToDataTable(dataArray);
  data2 = google.visualization.arrayToDataTable(dataArray2);
  // Create and draw the visualization.
 chart1 = new google.visualization.BarChart(document.getElementById('visualization'));
 chart1.draw(data,
           {title:"Votes, by Candidate",
            width:v1width, height:500,
            vAxis: {title: null, minValue: 0, baseline: 0},
            hAxis: {title: null, minValue: 0, baseline: 0},
            legend: {position: "bottom"},
            chartArea: {left: 0, right: 0, top: 30, width: '90%', height: '400px'},
            axisTitlesPosition: "none"
            }
      );
  chart3 = new google.visualization.PieChart(document.getElementById('visualization3'));
      chart3.draw(data2, {title:"Total Voters", is3D: true, legend: {position: 'bottom'}, pieSliceText: 'value'}); 
     
}
      google.setOnLoadCallback(drawVisualization);
    </script>

  </head>
  <body>
     <div class="navbar navbar-inverse navbar-static-top" style="display:;">
      <div class="navbar-inner">
          <a class="brand" href="/">Amercia Elections</a>
      </div>
    </div>
    <div class="container-fluid">
    <div class="row-fluid">
        <div class="span6">
    <h2><? if($keyword == "votedem"){ echo "Democratic Primary";} else if($keyword == "voterep") { echo "Republican Primary";}?></h2>
      <p style="font-size:20px;font-weight:bold;">Text "[NETID] [CANDIDATE]" to (315) 605-0277</p>
        	<div id="vizoutside" style="padding:0; border:;width: ;">
    <div id="visualization" style="width: ; height: 500px; "><img src="img/loader.gif" /></div>
        	</div>
    </div>
    <div class="span6">
    <div id="vizoutside" style="margin-top:10px; border-right:;width: ;">
    <div id="visualization3" style="width: ; height: 500px;"><img src="img/loader.gif" /></div>
  	</div>
    </div>
    </div>
    <div class="row-fluid">
    <div class="span6" style="text-align:left;">
        <p style="text-align:left;">
            <? if(!$refresh){?><p><button class="btn btn-info" onclick="activateRefresh();">Auto-refresh results</button></p> <? } else { ?> 
<p><img src="img/loader.gif" /> Live results... &nbsp; <a href="/?id=<? echo $electionid; ?>" class="btn">Disable auto-refresh</a></p>
<? } ?><br />
        <? 
    if($keyword == "votedem"){ 
    	echo "Democratic Primary&nbsp;&nbsp;<a href='/?id=1'>Republican Primary</a>"; 
    } else if ($keyword == "voterep"){ 
	    echo "<a href='/?id=2'>Democratic Primary</a>&nbsp;&nbsp;Republican Primary";	
    	}?></p>

    </div>
    <div class="span6">
    <p style="padding-top:5px;text-align:right;">[an <a href="http://www.twitter.com/awbauer9" target="_blank">@awbauer9</a> and <a href="http://www.twitter.com/cbeck527" target="_blank">@cbeck527</a> production]</p><br /><br />
    <form id="loginform"><div class="input-append" style="float:right;"><input type="password" id="password" style="width:150px;" placeholder="Password" />&nbsp;<input type="submit" onclick="" class="btn" value="Login"></div></form>
    </div>
    </div>
    <div class="row-fluid">
    <div class="span8" style="">
<div style="padding-top:30px;margin:auto;">

</div>
    </div>
        <div class="span4" style="text-align:right;padding-top:40px;">
        
   &nbsp;    </div>
    </div>
    </div>
    <script type="text/javascript">
    function activateRefresh(){
    	var interval = $('#refreshInt').val();
	    window.location = '/?refresh&id=<? echo $electionid; ?>';
    }
    function refresh(){
  jsonData = $.ajax({
	  url: "json.php?election=<? echo $electionid; ?>",
	  dataType: "json",
	  async: false
  }).responseText;
  jsonData2 = $.ajax({
	  url: "json.php?election=<? echo $electionid; ?>&userstatus",
	  dataType: "json",
	  async: false
  }).responseText;
dataArray = JSON.parse(jsonData);
dataArray2 = JSON.parse(jsonData2);
    data = google.visualization.arrayToDataTable(dataArray);
  data2 = google.visualization.arrayToDataTable(dataArray2);
  // Create and draw the visualization.
 chart1 = new google.visualization.BarChart(document.getElementById('visualization'));
 chart1.draw(data,
           {title:"Votes, by Candidate",
            width:v1width, height:500,
            vAxis: {title: null, minValue: 0, baseline: 0},
            hAxis: {title: null, minValue: 0, baseline: 0},
            legend: {position: "bottom"},
            chartArea: {left: 0, right: 0, top: 30, width: '90%', height: '400px'},
            axisTitlesPosition: "none"
            }
      );
  chart3 = new google.visualization.PieChart(document.getElementById('visualization3'));
      chart3.draw(data2, {title:"Total Voters", is3D: true, legend: {position: 'bottom'}, pieSliceText: 'value'}); 
}
    $("#loginform").submit(function(evt){
	    evt.preventDefault();
	    login();
    })
    function login(){
    	var pass = $('#password').val();
	    $.post('admin.php?dologin', {password: pass}, function(data){
		   if(data == 'badpassword'){
		   		alert('THERE WILL BE NO VOTER FRAUD HERE!');
		   } else if(data != 'success'){
			   alert(data);
		   } else {
			   document.location = '/admin.php';
		   }
	    });
    }
    
    <? 
    if($refresh > 0) {
    	echo "
    var id;	
    id = setInterval(function() {
	    refresh();
	}, 2000);";	 
	    }
    ?>
    </script>
    <!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=8382375; 
var sc_invisible=1; 
var sc_security="c4d43e79"; 
var sc_https=1; 
var sc_remove_link=1; 
var scJsHost = (("https:" == document.location.protocol) ?
"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost +
"statcounter.com/counter/counter.js'></"+"script>");</script>
<noscript><div class="statcounter"><img class="statcounter"
src="https://c.statcounter.com/8382375/0/c4d43e79/1/"
alt="web analytics"></div></noscript>
<!-- End of StatCounter Code for Default Guide -->
  </body>
</html>