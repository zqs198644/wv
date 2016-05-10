<?php
header("Content-type: text/html; charset=utf-8"); 
require_once("config/inc.php");
extract($_POST);
extract($_GET);

$sql = "select * from members where userid = '".trim($user_id)."' and password = '".md5(trim($user_pass))."'";
$query=mysql_query($sql)  or die(mysql_error());
while($array=mysql_fetch_array($query)){
$userid = $array[userid];
$password = $array[password];
$isadmin = $array[isadmin];
$regdate = $array[regdate];

}

if($userid == "$user_id" && $password == md5($user_pass)){
        session_start();
        $_SESSION['userid'] = $userid;
        $_SESSION['password'] = $user_pass;
        $_SESSION['isadmin'] = $isadmin;
        $_SESSION['regdate'] = $regdate;
		mysql_query("update members set status='1'  where userid='".$userid."'") or die(mysql_error());
        header("location:infop_main.php");
        //echo "<script>window.location.href('infop_main.php');</script>";
}else{
        echo "<script language=\"javascript\">\n";
        echo "window.open(\"../index.html\",\"_self\");\n";
        echo "alert(\"用户名或密码错误,请重新登陆！\")\n";
        echo "</script>\n";
}

?>
