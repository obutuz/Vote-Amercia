<?php
    // grab the post data and send to andrew's fuction

    $user_number = $_POST['From'];
    $message = $_POST['Body'];

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Sms>This should be your message... <?php echo $message ?></Sms>
</Response>