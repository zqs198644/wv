<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include("config/inc.php");
require_once("config/auth.php");
require_once("config/turn_page.php");
?>
<title>故障机器录入</title>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
table {border-collapse: collapse;border-spacing: 0;}
#form {font-size:12px;}
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
#form .noborder input, #form .noborder input{ border:none;}
.errorP{ text-align:center;padding:5px 0;font-weight:bold;color:#454545;}
#form .firstLine input, #form1 .firstLine input{width:30px; border:none;}
#form .bottomtd input, #form1 .bottomtd input{width:90px;padding:0;height:24px;line-height:24px;}
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
	case "mahinedit":

		//修改单个机器
		$sql = "update infop_machine set hostname='".$hostname."' ,idc='".$idc."',model='".$model."',cpu='".$cpu."',mem='".$mem."',memtype='".$memtype."',disk='".$disk."',disktype='".$disktype."',power='".$power."',raid='".$raid."',thread='".$thread."',node='".$node."',nodename='".$nodename."',product='".$product."',package='".$package."',comment='".$comment."',currdate='".$currdate."' where id='".$id."'";
		echo $sql;
		$query = mysql_query($sql) or die(mysql_error());
		if($query)
		{
				echo "<script>alert('机器信修改加成功！');history.go(-2);</script>"; 
		}else{
				echo "<script>alert('机器信修改失败！');history.go(-2);</script>";
		}//end if

	        break;
}//end case
$query = mysql_query("select * from infop_machine where id = '".$id."'") or die(mysql_error());
$result = mysql_fetch_array($query);
?>
<script language="javascript">
function checkdata()
{
if (document.form1.hostname.value=="") {
alert ("请填写机器名字 ！")
return false
}
if (document.form1.idc.value=="") {
alert ("请填写所在机房 ！")
return false
}
if (document.form1.model.value=="") {
alert ("请填写机器型号 ！")
return false
}
if (document.form1.cpu.value=="") {
alert ("请填写机器CPU信息 ！")
return false
}
if (document.form1.mem.value=="") {
alert ("请填写机器内存容量 ！")
return false
}
if (document.form1.memtype.value=="") {
alert ("请填写机器内存型号 ！")
return false
}
if (document.form1.disk.value=="") {
alert ("请填写磁盘容量 ！")
return false
}
if (document.form1.disktype.value=="") {
alert ("请填写磁盘型号 ！")
return false
}
if (document.form1.power.value=="") {
alert ("请填写电源型号 ！")
return false
}
if (document.form1.comment.value=="") {
alert ("请填写机器说明 ！")
return false
}
return true
}
  <!--全选-->
function select_all()
{ 
  for(var i=0;i<document.form2.elements.length;i++)
  {
     if(document.form2.elements[i].name=="checkbox[]")
     {
        if(document.form2.elements[i].checked==false)
             document.form2.elements[i].checked=true;
        else document.form2.elements[i].checked=false;
     }
  }
}
</script>

<form id="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=mahinedit&id=<? echo $result[id]?>" onsubmit="return checkdata()">
  <table width="640" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">节点机器编缉</th>
    </tr>
    <tr>
      <td width="125" align="center">机器名字 ：</td>
      <td width="499"><label>
        <input name="hostname" type="text" id="hostname" value="<?php echo $result["hostname"]?>"/>
      <span class="STYLE1">      *支持正则，例：szwg-public-z[00-10].szwg01</span></label></td>
    </tr>
    <tr>
      <td width="125" align="center">所在机房 ：<br /></td>
      <td><input name="idc" type="text" id="idc" value="<?php echo $result["idc"]?>" />
      <span class="STYLE1">*例：szwg</span></td>
    </tr>
    <tr>
      <td align="center">机器型号 ：</td>
      <td><span class="STYLE1"> 
        <input name="model" type="text" id="model" value="<?php echo $result["model"]?>" />
      *例：IBM X3650M3</span></td>
    </tr>
    <tr>
      <td align="center">机器CPU ：</td>
      <td><label><span class="STYLE1">
        <input name="cpu" type="text" id="cpu" value="<?php echo $result["cpu"]?>" />
        *例：Intel(R) Xeon(R) CPU  E5620  @ 2.40GHz (两颗四核)</span></label></td>
    </tr>
    <tr>
      <td align="center">内存容量 ：</td>
      <td><span class="STYLE1">
        <input name="mem" type="text" id="mem" value="<?php echo $result["mem"]?>" />
        *例：8G*8</span></td>
    </tr>
    <tr>
      <td align="center">内存型号 ：</td>
      <td><span class="STYLE1">
        <input name="memtype" type="text" id="memtype" value="<?php echo $result["memtype"]?>" />
      *例：Hynix　HMT31GR7BFR4A</span></td>
    </tr>
    <tr>
      <td align="center">硬盘容量 ：</td>
      <td><span class="STYLE1">
        <input name="disk" type="text" id="disk" value="<?php echo $result["disk"]?>" />
      </span><span class="STYLE1"> *例：200T*11</span></td>
    </tr>
    <tr>
      <td align="center">硬盘型号：</td>
      <td><span class="STYLE1">
        <input name="disktype" type="text" id="disktype" value="<?php echo $result["disktype"]?>" />
      </span><span class="STYLE1"> *例：希捷ST9300603SS</span></td>
    </tr>
    <tr>
      <td align="center">电源型号：</td>
      <td><span class="STYLE1">
        <input name="power" type="text" id="power" value="<?php echo $result["power"]?>" />
      *例：Liteon 460W</span></td>
    </tr>
    <tr>
      <td class="noborder" align="center">RAID卡：</td>
      <td><label>
        <input name="raid" type="radio" value="关闭" <?php if($result[raid]=='关闭')echo 'checked="checked"'?> />
        关闭
        <input type="radio" name="raid" value="开启" <?php if($result[raid]=='开启')echo 'checked="checked"'?>/>
      开启</label></td>
    </tr>
    <tr>
      <td  class="noborder" align="center">超线程：</td>
      <td><label>
        <input name="thread" type="radio" value="关闭" <?php if($result[thread]=='关闭')echo 'checked="checked"'?> />
        关闭
        <input type="radio" name="thread" value="开启" <?php if($result[thread]=='开启')echo 'checked="checked"'?>/>
        开启</label></td>
    </tr>
    <tr>
      <td align="center">节点路径 ： </td>
      <td><span class="STYLE1">
        <input name="node" type="text" id="node" value="<?php echo $result["node"]?>" size="20" />
*        </span></td>
    </tr>
    <tr>
      <td align="center">节点名字：</td>
      <td><span class="STYLE1">
        <input name="nodename" type="text" id="nodename" value="<?php echo $result["nodename"]?>" size="15" />
* </span></td>
    </tr>
    <tr>
      <td align="center">产品线 ： </td>
      <td><span class="STYLE1">
        <input name="product" type="text" id="product" value="<?php echo $result["product"]?>" size="10" />
      *</span></td>
    </tr>
    <tr>
      <td align="center">机型套餐： </td>
      <td><select name="package" id="package">
        <option value="KW1"  <?php if($result[package]=='KW1')echo ' selected="selected"'?>>KW1</option>
        <option value="KY1" <?php if($result[package]=='KY1')echo ' selected="selected"'?>>KY1</option>
        <option value="KZ1" <?php if($result[package]=='KZ1')echo ' selected="selected"'?>>KZ1</option>
        <option value="ZF" <?php if($result[package]=='ZF')echo ' selected="selected"'?>>ZF</option>
        <option value="ZD" <?php if($result[package]=='ZD')echo ' selected="selected"'?>>ZD</option>
        <option value="PA" <?php if($result[package]=='PA')echo ' selected="selected"'?>>PA</option>
        <option value="TR1" <?php if($result[package]=='TR1')echo ' selected="selected"'?>>TR1</option>
        <option value="TR2" <?php if($result[package]=='TR2')echo ' selected="selected"'?>>TR2</option>
        <option value="TR3" <?php if($result[package]=='TR3')echo ' selected="selected"'?>>TR3</option>
        <option value="磁带库I2000">磁带库I2000</option>
      </select></td>
    </tr>
    <tr>
      <td align="center">机器描述：</td>
      <td><label>
        <textarea name="comment " cols="40" rows="4" id="comment "><?php echo $result["comment"]?></textarea>
        <span class="STYLE1"> *</span>号为必填项</label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="提交" /><input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>

<script type="text/javascript">
function loca(a){
	loca_action = document.getElementById('form1')
	loca_action.action = a;
//	window.location.reload();
}
</script>
</body>
</html>
