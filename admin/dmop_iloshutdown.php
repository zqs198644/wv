<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include("config/inc.php");
require_once("config/auth.php");
require_once("config/turn_page.php");
?>
<title>用户管理</title>
<style type="text/css">
<!--
*{margin:0;padding:0;}
.STYLE1 {color: #FF0000}
.STYLE4 {font-size: 12px}
table{margin-top:20px;border-collapse: collapse;border-spacing: 0;margin:0 auto;}
#form2{margin:10px 10px 10px 9px;font-size:12px;color:#454545;}
#form2 input{vertical-align:middle;}
#form2 td, #form2 th{ line-height:18px;border:1px solid #CCC;padding:4px 5px;}
#form2 th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form2  .red{color:#F00;}
#form2  .bgblue{background:#0CF;}
#form2  .bold{font-weight:bold;}
#form2  td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form2 .check input{width:80px;height:24px;line-height:24px;}
#form2 .fline input{width:20px;}
.bottomtd{padding:5px 0;}
#form2 .fline input{ border:none;}
-->
</style>
</head>
<body>
<hr>

<?php
extract($_GET);
extract($_POST);

switch($action) 
{
	case "adduser":

	        break;

	case "deluser":

			break;
}
?>
<script language="javascript">
function checkdata()
{

if (document.form2.password.value=="") {
alert ("请填写操作密码 ！")
return false
}
if (document.form2.serverlist.value=="") {
alert ("请填写服务器列表 ！")
return false
}
return true
}
</script>

<form id="form2" name="form2" method="post" onsubmit="return checkdata()" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=adduser" >
  <table width="458" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">ILO批量关机接口</th>
    </tr>
    <tr>
      <td width="73" >操作人：</td>
      <td width="334"><?php echo $_SESSION['username']?></td>
    </tr>
    <tr>
      <td width="73" >命令：</td>
      <td class="fline"><input name="level" type="radio" value="1" checked="checked" />
        关机
        <input type="radio" name="level" value="0" />
          开机</td>
    </tr>
    <tr>
      <td  >密码：</td>
      <td><input name="password" type="password" id="password" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>机器列表:</td>
      <td><textarea name="serverlist" cols="26" rows="6" id="serverlist"></textarea>
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>描述：</td>
      <td><label>
        <textarea name="comment " cols="26" rows="6" id="comment "></textarea>
        <span class="STYLE4">(<span class="STYLE1">* </span>星号为必填项)</span></label></td>
    </tr>
    <tr>
      <td colspan="2" class="bottomtd check" align="center" valign="middle"><input type="submit" name="submit" value="提交" />
           <input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
</body>
</html>
