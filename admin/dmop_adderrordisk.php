<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include("config/inc.php");
require_once("config/auth.php");
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
#form select{width:103px;}
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
      <th colspan="2" scope="col">故障信息录入</th>
    </tr>
    <tr>
      <td width="88" align="center">机器名字 ：</td>
      <td width="366"><label>
        <input name="machine_name" type="text" id="machine_name"/>
      <span class="STYLE1">      *</span></label></td>
    </tr>
    <tr>
      <td width="88" align="center"> 故障硬盘 ：<br /></td>
      <td><input name="error_disk" type="text" id="error_disk" />
      <span class="STYLE1">*</span></td>
    </tr>
    <tr>
      <td align="center">故障类型 ：</td>
      <td><select  name="error_type" id="error_type">
        <option value="硬盘故障:I/O error, dev sd*, sector">硬盘故障:I/O error, dev sd*, sector</option>
        <option value="硬盘故障:rejecting I/O to dead device">硬盘故障:rejecting I/O to dead device</option>
        <option value="硬盘故障:rejecting I/O to offline device">硬盘故障:rejecting I/O to offline device</option>
        <option value="硬盘故障:other">硬盘故障:other</option>
        <option value="内存故障">内存故障</option>
        <option value="死机">死机</option>
        <option value="ILO不通">ILO不通</option>
        <option value="其它">其它</option>
            </select>
        <span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">故障信息 ：</td>
      <td><textarea name="error_log" cols="30" rows="4" id="error_log"></textarea></td>
    </tr>
    <tr>
      <td align="center">状态 ：</td>
      <td><select name="status" id="status">
        <option value="报修">报修</option>
        <option value="接口人已受理">接口人已受理</option>
        <option value="等待SA处理">等待SA处理</option>
        <option value="等待加入集群">等待加入集群</option>
        <option value="处理完成">处理完成</option>
      </select>
      <span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">所属集群 ：</td>
      <td><label>
        <select name="cluster" id="cluster">
          <option value="STON" selected="selected">STON</option>
          <option value="STOFF">STOFF</option>
          <option value="ECOMON">ECOMON</option>
          <option value="ECOMOFF">ECOMOFF</option>
          <option value="ECOMRT">ECOMRT</option>
          <option value="CH">CH</option>
        </select>
        <span class="STYLE1"> *</span>      </label></td>
    </tr>
    <tr>
      <td align="center">所属部门 ： </td>
      <td><select name="department">
        <option value="DMOP" selected="selected">DMOP</option>
        </select>
        <span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">所在机房 ： </td>
      <td><select name="idc" id="idc">
        <option value="sz">sz</option>
        <option value="yf">yf</option>
        <option value="jx">jx</option>
        <option value="db">db</option>
        <option value="tc">tc</option>
            </select></td>
    </tr>
    <tr>
      <td align="center">报修人 ： </td>
      <td>
        <input name="reporter" type="text" id="reporter" value="<?php echo $_SESSION['username']?>" />       </td>
    </tr>
    <tr>
      <td align="center">描 述：</td>
      <td><label>
        <textarea name="comment " cols="40" rows="4" id="comment "></textarea>
        <span class="STYLE1"> *</span>号为必填项</label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="提交" /><input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
