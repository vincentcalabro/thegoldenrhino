<?php
require_once('/Users/vinny/projects/thegoldenrhino/setup/configuration.php');

class Email {
    private $server = "{imap.gmail.com:993/ssl}";
    private $mailbox = "[Gmail]/Chats";
    private $user;
    Private $password;
    private $imap;
    private $db;

    public function __construct($user, $password) {
        $this->user = $user;
        $this->password = $password;
        $this->imap = imap_open($this->server.$this->mailbox, $this->user, $this->password);  // get imap connection
    }

    public static function connectDB() {
        $db = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
        return $db;
    }

    public function getMailboxNames() {
        $imap = $this->imap;
        $server = $this->server;

        $mailboxes = imap_list($imap, $server, '*');
        foreach($mailboxes as $mailbox) {
            $shortname = str_replace($server, '', $mailbox);
            echo "$shortname\n";
        }
    }

    public function getChatsFromJesse() {
        $imap = $this->imap;
        $chats = imap_search($imap, 'ALL', SE_UID);
        $chats_arr = array();

        $needle = "chat with jesse goodenough";     // search for this subject
        $to_blank = array("display:block;","padding-left:6em","text-indent:-1em","color:#888","&nbsp;");   // styles to replace with empty string

        foreach($chats as $value) {
            if ($headers = imap_headerinfo($imap, $value)) {
                if (isset($headers->subject) && stristr(strtolower($headers->subject), $needle) == true) {
                    $body = imap_fetchbody($imap, $value, "2");
                    $body = str_replace($to_blank,"",$body);
                    $body = preg_replace("/(0?\d|1[0-2]):(0\d|[0-5]\d) (AM|PM)/i","<span style='color:#777;padding-right:5px;'>$1:$2 $3</span>",$body);
                    //$body = str_replace("style=float:left;color:#888","style='color:#777;padding-right:5px;'",$body);
                    $body = "<div class='conversation'>".$body."</div>";
                    array_push($chats_arr, $body);
                }
            }
        }
        return $chats_arr;
    }

    public function insertChats() {
        $db = self::connectDB();
        $chats_arr = $this->getChatsFromJesse();
        foreach($chats_arr as $value) {
            $sql = 'insert into email.chats (body) values ("'.mysql_real_escape_string($value).'")';
            mysql_query($sql,$db) or die(mysql_error());
        }
    }

    public function closeImapConnection() {
        imap_close($this->imap);
    }
}

//$email = new Email(USER,PASSWORD);
//$email->insertChats();
//$email->closeImapConnection();