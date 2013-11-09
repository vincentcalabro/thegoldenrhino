<?php   require_once('helpers/parse_email.php'); // TODO: use codeignitor or other framework, remove connection from here and add to some base class
        $db = Email::connectDB();
        $sql = "SELECT body FROM email.chats ORDER BY RAND() LIMIT 1";
        $rs = mysql_query($sql,$db);
        $row = mysql_fetch_assoc($rs);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vinny's Macbook Pro</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap.less" rel="stylesheet/less">
    <!-- jQuery ui -->
    <link href="css/ui-darkness/jquery-ui-1.10.0.custom.css" rel="stylesheet">
</head>
<body>
<div class="chat-window">
    <div class="contact">
        Jesse Goodenough
        <button class="close">&times;</button>
    </div>
    <div class="message">
        <div class="message-container">
            <?php echo $row['body']; ?>
        </div>
        <textarea class="input-block-level" placeholder="Send a message..."></textarea>
    </div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/less-1.3.3.min.js"></script>
<script src="js/jquery-ui-1.10.0.custom.js"></script>
<script src="js/jquery.ez-bg-resize.js"></script>
<script src="js/rhino.js"></script>
</body>
</html>