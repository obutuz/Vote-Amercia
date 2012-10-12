<? /* http://vote.anewamercia.com */
$username=""; $password=""; $database="";$hostname = "";
include_once("connect.php");
include_once("functions.php");
/* tables: 
	votes (vote_id,vote_candidate,vote_time)
	users (user_id,user_netid,user_phone)
	log (log_id,log_type,log_message,user_id,log_time)
*/


?>