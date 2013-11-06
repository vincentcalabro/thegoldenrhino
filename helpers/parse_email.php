<?php

$server = "{imap.gmail.com:993/ssl}";
$mailbox = "[Gmail]/Chats";
$needle = "chat with jesse goodenough";
$user = "";             //email address
$password = "";         //password

$imap = imap_open($server.$mailbox, $user, $password);

//$message_count = imap_num_msg($imap);
//echo "Total message count: ".$message_count."<br />";

function getMailboxNames($imap, $server, $mailbox) {
    $mailboxes = imap_list($imap, $server, '*');
    foreach($mailboxes as $mailbox) {
        $shortname = str_replace($server, '', $mailbox);
        echo "$shortname\n";
    }
}
//getMailboxNames($imap, $server, $mailbox);

$chats = imap_search($imap, 'ALL', SE_UID);

 foreach($chats as $key => $value) {
     //$structure = imap_fetchstructure($imap, $value);
     //echo "--------------<br />".$structure."<br />";
     $headers = imap_headerinfo($imap, $value);
     if(isset($headers->subject) && stristr(strtolower($headers->subject), $needle) == true) {
        $body = imap_fetchbody($imap, $value, "2");
        echo "--------------<br />".$body."<br />";
     }
 }

//for($m = 1; $m <= $message_count; $ms++) {
//for($m = 1; $m <= 10; $m++) {
//    $headers = imap_headerinfo($imap, $m);
//    if(isset($headers->subject) && stristr(strtolower($headers->subject), $needle) == true) {
    //if(isset($headers->subject)) {
        //var_dump($headers);
        //echo $headers->subject."<br />";
//    }
//
//}

// $jesse_chats = imap_search($imap, 'SUBJECT Jesse', SE_UID);

// echo imap_fetchbody($imap, 3442, "1.1");

// var_dump($jesse_chats);

// foreach($jesse_chats as $key => $value) {
//     $body = imap_fetchbody($imap, $value, "1");
//     echo "--------------<br />".$body."<br />";
// }

        //var_dump($body);
        //$header = imap_header($imap, $i);
       
        //DEBUGGING ONLY
        //print_r($header);

        /*foreach($jesse_chats as $key => $value) {

        }
        $body = imap_fetchbody($imap, $i, "1.1");
       
        if ($body == ""):
            $body = imap_fetchbody($imap, $i, "1");
        endif;
       
        $body = trim(substr(quoted_printable_decode($body), 0, 100));
       
        //GET THE VARIABLES WE NEED
       
        $email[$i]['from'] = $header->from[0]->mailbox.'@'.$header->from[0]->host;
        $email[$i]['fromaddress'] = $header->from[0]->personal;
        $email[$i]['to'] = $header->to[0]->mailbox;
        $email[$i]['subject'] = $header->subject;
        $email[$i]['reply_to'] = $header->reply_to[0]->mailbox.'@'.$header->reply_to[0]->host;
        $email[$i]['message_id'] = $header->message_id;
        $email[$i]['date'] = $header->udate;
        $email[$i]['body'] = $body;
       
        $from = $email[$i]['fromaddress'];
        $from_email = $email[$i]['from'];
               
                //DO WHATEVER YOU NEED TO PROCESS THE MESSAGE HERE
                //ADVUST THIS FOR YOUR OWN USAGE --$message->save() probably wont mean anything to you
                if($message->save()):
           
            imap_delete($imap, $i);
           
        endif;
 */
    imap_expunge($imap);
    imap_close($imap);