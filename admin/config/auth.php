<?php
session_start();
if (!isset($_SESSION['userid'])) {	
	echo "<script language=\"javascript\">\n";
	echo "window.open(\"\/admin/infop_logout.php\",\"_parent\");\n";
 	echo "alert(\"会员注册或登陆系统后，才有权限发布套餐信息!\")\n";
	//echo "alert(\"会员未登陆系统!\")\n";
	echo "</script>\n"; 
	echo "</body>";
	echo "</html>";
	exit(); 
}

	
?>
