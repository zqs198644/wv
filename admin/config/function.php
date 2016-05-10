<?php

function my_connect() {
    global $cfg;
    $connect = mysql_connect("$cfg->host","$cfg->username","$cfg->password");
    $db = mysql_select_db("$cfg->dbname",$connect);
    mysql_query('SET NAMES UTF8');
}

function my_query($sql) {
    my_connect();
    $query = mysql_query($query);
    return $query;
    mysql_close(); 
}
function my_while($sql) {
    my_connect();
    $query = mysql_query($sql);
    while($result = mysql_fetch_array($query)) 
    return $result;
    mysql_close(); 
}

function sendmail($email,$title,$message)
{
	$title = iconv("UTF-8","GBK",$title);
	$reply_email="dpf-op@baidu.com";
	$headers = 'From: DMOP_EMA <'.$reply_email.'>' . "\r\n" . 'Reply-To: ServMon <'.$reply_email.'>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	mail($email,$title,$message,$headers);
}
?>
