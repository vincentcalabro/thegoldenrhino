<?

/**
*   This will eventually populate a database with chat logs
*   This will come in handy: http://www.php.net/manual/en/function.imap-search.php
*
**/
$imap = imap_open("{MYSITE.COM:143/notls}INBOX", "USERNAME", "PASSWORD")):
 
$message_count = imap_num_msg($imap);
 
for ($i = 1; $i <= $message_count; ++$i):
       
        $header = imap_header($imap, $i);
       
        //DEBUGGING ONLY
        //print_r($header);
       
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
 
    endfor;
   
    imap_expunge($imap);
    imap_close($imap);