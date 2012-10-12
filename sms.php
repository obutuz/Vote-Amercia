<?php
    // grab the post data and send to andrew's fuction
    /* 
    doVote($election, $phone, $message)
   		responses:  invalidnetid, invalidcandidate, notinclass, alreadyvoted, invalidphone, votesuccess, othererror
    */

    $user_number = filter_var($_POST['From'], FILTER_SANITIZE_STRING);
    $message =filter_var($_POST['Body'], FILTER_SANITIZE_STRING);

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Sms>
    	<?
	    	include_once("index.php");
	    	$vote = doVote('testelection',$user_number,$message);
	    	if($vote == "votesuccess"){
		    	echo "Vote submitted!";
	    	} else if ($vote == "alreadyvoted"){
		    	echo "Voter fraud! You only get one vote!";
	    	} else if ($vote == "notinclass"){
	    		echo "Nice try, but you're not in this class.";
	    	} else if ($vote == "invalidcandidate" || $vote == "invalidnetid"){
	    		echo "Umm.... That doesn't look right. Try again.";
	    	} else if ($vote == "invalidphone"){
	    		echo "Can't vote from a different phone, sorry.";
	    	} else {
		    	echo "Uh-oh. Something went wrong. Try again?";
	    	}
    	?>
    </Sms>
</Response>