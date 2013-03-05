<?
if(!isset($_GET['refresh'])) $refresh = 2;
$username=""; $password=""; $database="";$hostname = "";
include_once("connect.php");
include_once("functions.php");
$mysqli = new mysqli($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
if (mysqli_connect_errno()) {printf("Connect failed: %s\n", mysqli_connect_error()); return $status;}
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
        padding-top: ; /* 60px to make the container go all the way to the bottom of the topbar */
      
      }
      h3 {
	      line-height: 25px;
	      padding: 5px 0 10px;
      }
      .pie{
	      height: 400px;
	      z-index: -9999;
      }
      .pieoutside{
	      height: ;
	      z-index: -9999;
	      overflow: hidden;
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
    <script src="http://js.pusher.com/1.12/pusher.min.js" type="text/javascript"></script>
        <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
    var chart1 = null, data1 = null, jsonData1 = null, dataArray1 = null, chart2 = null, data2 = null, jsonData2 = null, dataArray2 = null, chart3 = null, data3 = null, jsonData3 = null, dataArray3 = null, chart4 = null, data4 = null, jsonData4 = null, dataArray4 = null, chart5 = null, data5 = null, jsonData5 = null, dataArray5 = null, chart6 = null, data6 = null, jsonData6 = null, dataArray6 = null, v1width = $('#visualization').width(),v2width = $('#visualization2').width();
    function drawVisualization() {
        $("#loader").show();

  jsonData3 = $.ajax({
	  url: "json1.php?q=5",
	  dataType: "json",
	  async: false
  }).responseText;
  data3 = google.visualization.arrayToDataTable(JSON.parse(jsonData3));
  chart3 = new google.visualization.PieChart(document.getElementById('visualization3'));
  chart3.draw(data3, {title:"If no independent candidates were included on the ballot, who would receive your vote for president?", legend: {position: 'left'}, is3D: true, pieSliceText: "percentage", chartArea: {height: "400px"}}); 

     setTimeout(function(){ $("#loader").hide();},1000);

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
        <div style="padding:30px 0 0 0;text-align:center;"><a href="http://www.electionclass.com/"><img src="img/banner.png" border="0" /></a></div>

    <div class="container-fluid">
    
    <div class="row-fluid">
  	 <div class="span12"><div id="vizoutside" style="margin-top:; border-right:;width: ;" class="pieoutside">
    <div id="visualization3" style="width: ; height: ;" class="pie"><img src="img/loader.gif" /></div>
  	</div></div>
  	   </div>
    <div class="row-fluid">
    <div class="span6" style="text-align:left;">
        <p style="text-align:left;">
            <? if(!$refresh){?><p><a class="btn btn-info" href="/?refresh&id=<? echo $electionid; ?>">Auto-refresh results</a></p> <? } else { ?> 
<p><img src="img/loader.gif" id="loader" style="display:none;" /> Results updated every 30 seconds &nbsp;</p>
<? } ?></p>

    </div>
    <div class="span6">
    <p style="padding-top:5px;text-align:right;">[a NEXIS production by <a href="http://www.twitter.com/awbauer9" target="_blank">@awbauer9</a> and <a href="http://www.twitter.com/cbeck527" target="_blank">@cbeck527</a>]</p><br /><br />
    <form id="loginform" style="display:none;"><div class="input-append" style="float:right;"><input type="password" id="password" style="width:150px;" placeholder="Password" />&nbsp;<input type="submit" onclick="" class="btn" value="Login"></div></form>
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
    $("#loginform").submit(function(evt){
	    evt.preventDefault();
	    login();
    });
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
var id;	
    id = setInterval(function() {
	    drawVisualization();
	}, 30000);
    $(function() {
	   //drawChart('2'); 
    });
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