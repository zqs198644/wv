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
	case "addmachine":

				//判断是否批量增加机器列表
				$str = $hostname;
				$start = strpos($str,"[");
				if($start != '0')
				{
						$end = strpos($str,"]");
						$length = $end - $start;
						$mid_str= substr($str,$start+1,$length-1);
						$start_str = substr($str,0,$start);
						$end_str = substr($str,$end+1);
						
						$str = explode("-",$mid_str);
						$mid_length = strlen($str[0]);
						
						for($i=$str[0];$i<=$str[1];$i++)
						{
							//添充0补位
							if($mid_length > strlen($i))
							{
								for($j=0;$j<($mid_length-strlen($i));$j++)
								{
									  $append_str .= "0";  
								}          
							}//end if
								$hostname = $start_str.$append_str.$i.$end_str;
								
								$append_str ="";

								//查询是否重复添加
								$query = mysql_query("select * from infop_machine where hostname = '$hostname'") or die(mysql_error());
								$error_num = mysql_num_rows($query);
								if (  $error_num == '0' )
								{
									$sql = "insert into infop_machine values('','".$hostname."' ,'".$idc."','".$model."','".$cpu."','".$mem."','".$memtype."','".$disk."','".$disktype."','".$power."','".$raid."','".$thread."','".$node."','".$nodename."','".$product."','".$package."','".$comment."','cpu,mem,traffic','".$currdate."')";
									$query = mysql_query($sql) or die(mysql_error());
									$m++;
								}else{
									$n++;
									continue;
								}

						}//end for
						
								if( $n == '')
								{
									echo "<script>alert('成功添加".$m."台机器列表信息！');location.href='$_SERVER[PHP_SELF]';</script>"; 
								}else{
									echo "<script>alert('成功添加".$m."台机器列表信息县，其中有".$n."台重复未添加！');location.href='$_SERVER[PHP_SELF]';</script>"; 
								}
						

				}else{
								//正常添加单个机器
								$query = mysql_query("select * from infop_machine where  hostname = '$hostname'") or die(mysql_error());
								$error_num = mysql_num_rows($query);
								if (  $error_num == '0' )
								{
									$sql = "insert into infop_machine values('','".$hostname."' ,'".$idc."','".$model."','".$cpu."','".$mem."','".$memtype."','".$disk."','".$disktype."','".$power."','".$raid."','".$thread."','".$node."','".$nodename."','".$product."','".$package."','".$comment."','cpu,mem,traffic','".$currdate."')";
									$query = mysql_query($sql) or die(mysql_error());
									if($query)
									{
										echo "<script>alert('机器列表信息添加成功！');location.href='$_SERVER[PHP_SELF]';</script>"; 
									}
								}else{
										echo "<script>alert('机器信息不可重复添加！');location.href='$_SERVER[PHP_SELF]';</script>";
								}//end if

				}// end if
	        break;
}//end case
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

<form id="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=addmachine" onsubmit="return checkdata()">
  <table width="640" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">节点机器录入</th>
    </tr>
    <tr>
      <td width="125" align="center">机器名字 ：</td>
      <td width="499"><label>
        <input name="hostname" type="text" id="hostname"/>
      <span class="STYLE1">      *支持正则，例：szwg-public-z[00-10].szwg01</span></label></td>
    </tr>
    <tr>
      <td width="125" align="center">所在机房 ：<br /></td>
      <td><input name="idc" type="text" id="idc" />
      <span class="STYLE1">*例：szwg</span></td>
    </tr>
    <tr>
      <td align="center">机器型号 ：</td>
      <td><span class="STYLE1"> 
        <input name="model" type="text" id="model" />
      *例：IBM X3650M3</span></td>
    </tr>
    <tr>
      <td align="center">机器CPU ：</td>
      <td><label><span class="STYLE1">
        <input name="cpu" type="text" id="cpu" />
        *例：Intel(R) Xeon(R) CPU  E5620  @ 2.40GHz (两颗四核)</span></label></td>
    </tr>
    <tr>
      <td align="center">内存容量 ：</td>
      <td><span class="STYLE1">
        <input name="mem" type="text" id="mem" />
        *例：8G*8</span></td>
    </tr>
    <tr>
      <td align="center">内存型号 ：</td>
      <td><span class="STYLE1">
        <input name="memtype" type="text" id="memtype" />
      *例：Hynix　HMT31GR7BFR4A</span></td>
    </tr>
    <tr>
      <td align="center">硬盘容量 ：</td>
      <td><span class="STYLE1">
        <input name="disk" type="text" id="disk" />
      </span><span class="STYLE1"> *例：200T*11</span></td>
    </tr>
    <tr>
      <td align="center">硬盘型号：</td>
      <td><span class="STYLE1">
        <input name="disktype" type="text" id="disktype" />
      </span><span class="STYLE1"> *例：希捷ST9300603SS</span></td>
    </tr>
    <tr>
      <td align="center">电源型号：</td>
      <td><span class="STYLE1">
        <input name="power" type="text" id="power" />
      *例：Liteon 460W</span></td>
    </tr>
    <tr>
      <td class="noborder" align="center">RAID卡：</td>
      <td><label>
        <input name="raid" type="radio" value="关闭" checked="checked" />
        关闭
        <input type="radio" name="raid" value="开启" />
      开启</label></td>
    </tr>
    <tr>
      <td  class="noborder" align="center">超线程：</td>
      <td><label>
        <input name="thread" type="radio" value="关闭" checked="checked" />
        关闭
        <input type="radio" name="thread" value="开启" />
        开启</label></td>
    </tr>
    <tr>
      <td align="center">节点路径 ： </td>
      <td><span class="STYLE1">
        <input name="node" type="text" id="node" size="20" />
*        </span></td>
    </tr>
    <tr>
      <td align="center">节点名字：</td>
      <td><span class="STYLE1">
        <input name="nodename" type="text" id="nodename" size="15" />
* </span></td>
    </tr>
    <tr>
      <td align="center">产品线 ： </td>
      <td><span class="STYLE1">
        <input name="product" type="text" id="product" size="10" />
      *</span></td>
    </tr>
    <tr>
      <td align="center">机型套餐： </td>
      <td><select name="package" id="package">
        <option value="KW1" selected="selected">KW1</option>
        <option value="KY1">KY1</option>
        <option value="KZ1">KZ1</option>
        <option value="ZF">ZF</option>
        <option value="ZD">ZD</option>
        <option value="PA">PA</option>
        <option value="TR1">TR1</option>
        <option value="TR2">TR2</option>
        <option value="TR3">TR3</option>
        <option value="磁带库I2000">磁带库I2000</option>
                  </select></td>
    </tr>
    <tr>
      <td align="center">机器描述：</td>
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

<script type="text/javascript">
function loca(a){
	loca_action = document.getElementById('form1')
	loca_action.action = a;
//	window.location.reload();
}
</script>
</body>
</html>
