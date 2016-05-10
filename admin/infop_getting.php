<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<?php 
include("config/inc.php");
require_once("config/auth.php");
$currdate = date("Y-m-d H:i:s");
?>
<title>故障机器录入</title>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
table {border-collapse: collapse;border-spacing: 0;}
#form {margin:10px 10px 10px 9px;font-size:12px;}
#form td, #form th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form input{vertical-align:middle;}
#form th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form .red{color:#F00;}
#form .bgblue{background:#0CF;}
#form .bold{font-weight:bold;}
#form select{width:80px;}
#form #error_type{width:auto;}
#form td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form .subtime{height:30px;padding:5px 0;}
#form .subtime input{width:80px;margin:0 20px;height:24px;line-height:24px;}
-->
</style>
</head>
<body>
<hr>
<?php
extract($_GET);
extract($_POST);
$sysdate=date("Y-m-d H:i:s");
switch($action) 
{
	case "adderrordisk":
			$query = mysql_query("select * from dmop_error_disk where machine_name = '$machine_name' and error_disk = '$error_disk' and status = '报修'") or die(mysql_error());
			$error_num = mysql_num_rows($query);
			if (  $error_num == '0' ){
				$sql = "insert into dmop_error_disk values('','".$machine_name."' ,'".$idc."','".$error_disk."','".$error_type."','".$error_log."','".$status."','".$reporter."','".$cluster."','".$sysdate."','".$comment."','','','','".$department."')";
				$query = mysql_query($sql) or die(mysql_error());
				if($query){
					echo "<script>alert('故障信息添加成功！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					mysql_close();
				}
			}else{
					echo "<script>alert('故障信息不可重复添加！');location.href='$_SERVER[PHP_SELF]';</script>";
			}
	        break;
}
?>
<script language="javascript">
function checkdata()
{
if (document.form1.machine_name.value=="") {
alert ("请添写故障机器名 ！")
return false
}
if (document.form1.error_disk.value=="") {
alert ("请添写故障机硬盘信息 ！")
return false
}
return true
}
</script>

<form id="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=adderrordisk" onsubmit="return checkdata()">
  <table width="674" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">进货录入</th>
    </tr>
    <tr>
      <td  align="center">进货品类：</td>
      <td ><label><span class="STYLE1">      
<select name="category" id="category">
<?php 
	$query= mysql_query("select * from category order by id desc");
	while($result = mysql_fetch_array($query)){
?>
  <option value="<?php echo $result[category]?>" selected="selected"><?php echo $result[category]?></option>
<?php
}
?>
</select>
*</span></label></td>
    </tr>
    <tr>
      <td width="88" align="center"> 进货个数： <br /></td>
      <td><input name="number" type="text" id="number" />
        只</td>
    </tr>
    <tr>
      <td align="center">进货斤数 ：</td>
      <td><input name="pounds" type="text" id="pounds" />
      斤<span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">进货箱数 ：</td>
      <td><input name="pounds2" type="text" id="pounds2" />
        箱</td>
    </tr>
    <tr>
      <td align="center">进货金额 ：</td>
      <td><input name="money" type="text" id="money" />
       元<span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">录入人名 ： </td>
      <td>
        <input name="reporter" type="text" id="reporter" value="<?php echo $_SESSION['username']?>" />       </td>
    </tr>
    <tr>
      <td align="center">进货说明：</td>
      <td><label>
        <textarea name="comment " cols="40" rows="4" id="comment "></textarea>
        <span class="STYLE1"> *</span>号为必填项</label></td>
    </tr>
    <tr>
      <td align="center">进货时间：</td>
      <td><input name="dateTime" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss',0,0)" value="<?php echo $currdate?>" />
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="提交" /><input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
