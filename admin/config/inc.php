<?php
$cfg->host = "localhost";
$cfg->username = "wv";
$cfg->password = "wvwvwv2015";
$cfg->dbname = "wv";

$connect = mysql_connect("$cfg->host","$cfg->username","$cfg->password");
$db = mysql_select_db("$cfg->dbname",$connect);
mysql_query('SET NAMES UTF8');
?>
