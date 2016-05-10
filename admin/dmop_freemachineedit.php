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
#form select{width:103px;height:18px; line-height:18px;}
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
$currdate=date("Y-m-d H:i:s");
switch($action) 
{
	case "addfreehost":
				$query = mysql_query("select * from dmop_freemachine where id = '".$id."'") or die(mysql_error());
				$result = mysql_fetch_array($query);

				if($status == '空闲'){
					 $str = "return_time = '".$currdate."' where id = '".$id."'";
					 $insert = "insert into dmop_freemachine values('','".$machine_name."' ,'".$idc."','".$factory."','".$mem."','".$disk."','".$cpu."','".$machine_type."','".$contact."','".$hiname."','".$status."','".$comment."','".$result["input_time"]."','".$result["borrow_time"]."','".$currdate."','".$result["online_time"]."','".$id."')";
				}elseif($status == '已借用'){
					 $str = "borrow_time = '".$currdate."',return_time = '".$return_time."' where id = '".$id."'";
					 $insert = "insert into dmop_freemachine values('','".$machine_name."' ,'".$idc."','".$factory."','".$mem."','".$disk."','".$cpu."','".$machine_type."','".$contact."','".$hiname."','".$status."','".$comment."','".$result["input_time"]."','".$currdate."','".$return_time."','".$result["online_time"]."','".$id."')";
				}else{
					 $str = "online_time = '".$online_time."' where id = '".$id."'";
					 $insert = "insert into dmop_freemachine values('','".$machine_name."' ,'".$idc."','".$factory."','".$mem."','".$disk."','".$cpu."','".$machine_type."','".$contact."','".$hiname."','".$status."','".$comment."','".$result["input_time"]."','".$result["borrow_time"]."','".$result["return_time"]."','".$currdate."','".$id."')";
				}
				$sql = "update dmop_freemachine set machine_name = '".$machine_name."', idc = '".$idc."',factory = '".$factory."',mem ='".$mem."',disk = '".$disk."',cpu = '".$cpu."', machine_type = '".$machine_type."',contact = '".$contact."',hiname = '".$hiname."', status = '".$status."',comment = '".$comment."',".$str;
				$query = mysql_query($sql) or die(mysql_error());
				if($query){
					echo "<script>alert('机器信息编辑成功！');location.href='dmop_freemachinemain.php';</script>"; 
				}else{
					echo "<script>alert('机器信息编辑失败！');location.href='dmop_freemachinemain.php';</script>";
				}
				mysql_query($insert) or die(mysql_error());
	        	break;
}

$query = mysql_query("select * from dmop_freemachine where id = '".$id."'") or die(mysql_error());
$result = mysql_fetch_array($query);
?>
<script language="javascript">
function checkdata()
{
if (document.form1.machine_name.value=="") {
alert ("请填写机器名字 ！")
return false
}
if (document.form1.idc.value=="") {
alert ("请填写所在机房 ！")
return false
}
if (document.form1.factory.value=="") {
alert ("请填写机器厂商 ！")
return false
}
if (document.form1.mem.value=="") {
alert ("请填写机器内存 ！")
return false
}
if (document.form1.disk.value=="") {
alert ("请填写磁盘大小 ！")
return false
}
if (document.form1.cpu.value=="") {
alert ("请填写机器CPU信息 ！")
return false
}
if (document.form1.comment.value=="") {
alert ("请填写机器说明 ！")
return false
}
return true
}
</script>

<form id="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=addfreehost" onsubmit="return checkdata()">
  <table width="640" height="188" border="1" align="center">
    <tr>
      <th colspan="3" scope="col">空闲机器编缉</th>
    </tr>
    <tr>
      <td width="136" align="center">机器名字 ：</td>
      <td colspan="2"><label>
        <input name="machine_name" type="text" id="machine_name" value="<?php echo $result["machine_name"]?>"/>
      <span class="STYLE1">      *支持正则，例：zwg-public-z[0-100].szwg01</span></label></td>
    </tr>
    <tr>
      <td width="136" align="center">所在机房 ：<br /></td>
      <td colspan="2"><input name="idc" type="text" id="idc" value="<?php echo $result["idc"]?>" />
      <span class="STYLE1">*例：szwg</span></td>
    </tr>
    <tr>
      <td align="center">机器厂商 ：</td>
      <td colspan="2"><span class="STYLE1"> 
        <input name="factory" type="text" id="factory" value="<?php echo $result["factory"]?>" />
      *例：IBM</span></td>
    </tr>
    <tr>
      <td align="center">机器内存 ：</td>
      <td colspan="2"><span class="STYLE1">
        <input name="mem" type="text" id="mem" value="<?php echo $result["mem"]?>" />
      *例：8G*8</span></td>
    </tr>
    <tr>
      <td align="center">机器磁盘 ：</td>
      <td colspan="2"><span class="STYLE1">
        <input name="disk" type="text" id="disk" value="<?php echo $result["disk"]?>" />
      </span><span class="STYLE1"> *例：200T*11</span></td>
    </tr>
    <tr>
      <td align="center">机器CPU ：</td>
      <td colspan="2"><label><span class="STYLE1">
      <input name="cpu" type="text" id="cpu" value="<?php echo $result["cpu"]?>" />
*例：Intel(R) Xeon(R) CPU  E5620  @ 2.40GHz (两颗四核)</span></label></td>
    </tr>
    <tr>
      <td align="center">机器联系 ： </td>
      <td width="202"><span class="STYLE1">
        <input name="contact" type="text" id="contact" value="<?php echo $result["contact"]?>" size="10" />
*</span></td>
      <td width="280"><span class="STYLE1"> </span>HI账号： <span class="STYLE1">
      <input name="hiname" type="text" id="hiname" value="<?php echo $result["hiname"]?>" />
* </span></td>
    </tr>
    <tr>
      <td align="center">机器机型：</td>
      <td colspan="2"><select name="machine_type" id="machine_type">
        <option value="稳定"  <?php if($result["machine_type"] == '稳定')echo 'selected="selected"';?>>稳定</option>
        <option value="slave" <?php if($result["machine_type"] == 'slave')echo 'selected="selected"';?>>slave</option>
                        </select></td>
    </tr>
    <tr>
      <td align="center">机器状态 ： </td>
      <td colspan="2"><select name="status" id="status">
        <option value="空闲"   <?php if($result["status"] == '空闲') 	 echo 'selected="selected"';?>>空闲</option>
        <option value="已借用" <?php if($result["status"] == '已借用') echo 'selected="selected"';?>>已借用</option>
        <option value="已上线" <?php if($result["status"] == '已上线') echo 'selected="selected"';?>>已上线</option>
      </select></td>
    </tr>
    <tr>
      <td align="center">归还时间：</td>
      <td colspan="2"><input name="return_time" class="firstLine" id="return_time"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss',0,0)" value="<?php  if($result["status"] == '已借用'){ echo $result["return_time"];}else{ echo $currdate;}?>" /></td>
    </tr>
    <tr>
      <td align="center">机器描述：</td>
      <td colspan="2"><label>
        <textarea name="comment" cols="40" rows="4" id="comment" value="<?php echo $result["comment"]?>"><?php echo $result["comment"]?></textarea>
        <span class="STYLE1"> *</span>号为必填项
        <input name="id" type="hidden" id="id" value="<?php echo $id?>" />
      </label></td>
    </tr>
    <tr>
      <td colspan="3" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="提交" /><input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
</body>
</html>
