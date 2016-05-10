<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户管理</title>
<style>
#form1 {margin:10px 10px 10px 9px;font-size:12px;color:#454545;}
#form1 td, #form2 th{line-height:18px; border:1px solid #CCC;padding:2px 5px;}
#form1 th{background:#F4F5EB;color:#454545;font-weight:bold;}
table {border-collapse: collapse;border-spacing: 0; border:1px solid #CCC;}
#form1 .red{color:#F00;}
#form1 .bgblue{background:#0CF;}
#form1 .bold{font-weight:bold;}
#form1 select{width:103px;height:18px; line-height:18px;}
#form1 td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form1 .bottomtd{height:30px;padding:5px 10px;}
#form1 .check input{width:80px;height:24px;line-height:24px;}
</style>
</head>
<body>
<?php 
include("config/inc.php");
require_once("config/auth.php");
extract($_GET);
extract($_POST);
$passwd_one=trim($passwd_one);
$passwd_two=trim($passwd_two);
switch($action) 
{
	case "change":
			if( $passwd_one == $passwd_two){
				 mysql_query("update dmop_members set password = '".md5($passwd_one)."' where username = '".$_SESSION[username]."'") or die(mysql_error());
				 echo "<script>alert('密码修改成功！');</script>";
			}else{
				 echo "<script>alert('两次输入密码不一致!!!!!!！');</script>";
			}
			break;
}
?>
<hr>
<script language="javascript">
function checkdata()
{
if (document.form1.passwd_one.value=="") {
alert ("请添写密码 ！")
return false
}
if (document.form1.passwd_two.value=="") {
alert ("请添写确认密码 ！")
return false
}
return true
}
</script>
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=change" onsubmit="return checkdata()">
  <table width="352" height="154" align='center' class='table_style' ellpadding='0' >
    <tr>
      <th height="28" colspan="2" align="center" scope="col" ><strong>修改密码</strong></th>
    </tr>
    <tr>
      <td width="118" height="24" align="center">用户名：</td>
      <td width="230" align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION["username"]?></td>
    </tr>
    <tr>
      <td height="28" align="center">输入密码：</td>
      <td align="left"><input name="passwd_one" type="password" id="passwd_one" size="15" />
      </td>
    </tr>
    <tr>
      <td height="28" align="center">确认密码：</td>
      <td align="left"><input name="passwd_two" type="password" id="passwd_two" size="15" /></td>
    </tr>
    <tr>
    <td height="26"  colspan="2" align="center" class="check"><label></label>
          <input type="submit" name="Submit" value="修改">
 	</td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
