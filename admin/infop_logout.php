<?php
	require_once("config/inc.php");
	session_start();
	mysql_query("update members set status='0'  where userid='".$_SESSION['userid']."'") or die(mysql_error());
	unset($_SESSION['userid']);
	echo "<html><head>";
	echo "<META http-equiv=\"refresh\" content=\"0;URL=../index.html\">";
	echo "</head>";
	echo "<body>";
	echo "</body>";
	echo "</html>";
?>   
