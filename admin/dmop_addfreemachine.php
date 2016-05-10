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

				//判断是否批量增加机器列表
				$str = $machine_name;
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
								$machine_name = $start_str.$append_str.$i.$end_str;
								
								$append_str ="";

								//查询是否重复添加
								$query = mysql_query("select * from dmop_freemachine where pid = '0' and machine_name = '$machine_name'") or die(mysql_error());
								$error_num = mysql_num_rows($query);
								if (  $error_num == '0' )
								{
									$sql = "insert into dmop_freemachine values('','".$machine_name."' ,'".$idc."','".$factory."','".$mem."','".$disk."','".$cpu."','".$machine_type."','".$contact."','".$hiname."','".$status."','".$comment."','".$currdate."','','','','0')";
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
								$query = mysql_query("select * from dmop_freemachine where pid = '0' and machine_name = '$machine_name'") or die(mysql_error());
								$error_num = mysql_num_rows($query);
								if (  $error_num == '0' )
								{
									$sql = "insert into dmop_freemachine values('','".$machine_name."' ,'".$idc."','".$factory."','".$mem."','".$disk."','".$cpu."','".$machine_type."','".$contact."','".$hiname."','".$status."','".$comment."','".$currdate."','','','','0')";
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
if (document.form1.contact.value=="") {
alert ("请填写联系人姓名 ！")
return false
}
if (document.form1.hiname.value=="") {
alert ("请填写HI账号,有助于联系 ！")
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
      <th colspan="2" scope="col">空闲机器录入</th>
    </tr>
    <tr>
      <td width="135" align="center">机器名字 ：</td>
      <td width="489"><label>
        <input name="machine_name" type="text" id="machine_name"/>
      <span class="STYLE1">      *支持正则，例：szwg-public-z[00-10].szwg01</span></label></td>
    </tr>
    <tr>
      <td width="135" align="center">所在机房 ：<br /></td>
      <td><input name="idc" type="text" id="idc" />
      <span class="STYLE1">*例：szwg</span></td>
    </tr>
    <tr>
      <td align="center">机器厂商 ：</td>
      <td><span class="STYLE1"> 
        <input name="factory" type="text" id="factory" />
      *例：IBM</span></td>
    </tr>
    <tr>
      <td align="center">机器内存 ：</td>
      <td><span class="STYLE1">
        <input name="mem" type="text" id="mem" />
      *例：8G*8</span></td>
    </tr>
    <tr>
      <td align="center">机器磁盘 ：</td>
      <td><span class="STYLE1">
        <input name="disk" type="text" id="disk" />
      </span><span class="STYLE1"> *例：200T*11</span></td>
    </tr>
    <tr>
      <td align="center">机器CPU ：</td>
      <td><label><span class="STYLE1">
      <input name="cpu" type="text" id="cpu" />
*例：Intel(R) Xeon(R) CPU  E5620  @ 2.40GHz (两颗四核)</span></label></td>
    </tr>
    <tr>
      <td align="center">机器联系 ： </td>
      <td><span class="STYLE1">
        <input name="contact" type="text" id="contact" size="10" />
*        </span>HI账号：      <span class="STYLE1"> 
      <input name="hiname" type="text" id="hiname" />
      *
      </span></td>
    </tr>
    <tr>
      <td align="center">机器状态 ： </td>
      <td><select name="status" id="status">
        <option value="空闲" >空闲</option>
        <option value="已借用">已借用</option>
        <option value="已上线">已上线</option>
            </select></td>
    </tr>
    <tr>
      <td align="center"> 机器机型： </td>
      <td><select name="machine_type" id="machine_type">
        <option value="稳定" selected="selected">稳定</option>
        <option value="slave">slave</option>
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
</body>
</html>
