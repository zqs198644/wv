<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>空闲机器查询</title>
<style>
*{margin:0;padding:0;}
table {border-collapse: collapse;border-spacing: 0;}
#form2, #form1 {margin:10px 10px 10px 9px;font-size:12px;}
#form2 td, #form2 th, #form1 td, #form1 th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form2 th, #form1 th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form2 .red, #form1 .red{color:#F00;}
#form2 .bgblue, #form1 .bgblue{background:#0CF;}
#form2 .bold, #form1 .bold{font-weight:bold;}
#form2 select, .#form1 select{width:103px;}
#form2 td input, #form1 td input{height:18px;line-height:18px;width:15px;border:1px solid #ddd;vertical-align:middle;}
#form2 .bottomtd input, #form1 .bottomtd input{width:90px;padding:0;height:24px;line-height:24px;}
#form2 .check, #form1 .check{width:60px;}
.errorP{ text-align:center;border:2px solid #ddd;border-width:2px 0;padding:8px 0;color:#4545;}
#form2 .firstLine input, #form1 .firstLine input{width:30px; border:none;}
.submit1{height:20px;line-height:20px;margin:0 5px;width:80px;border:1px solid #DDDDDD;vertical-align:middle;}
.text1{width:280px;line-height:18px; height:18px; border:1px solid #CCC;vertical-align:middle; vertical-align:middle;}
#form2 .th1{ height:24px; line-height:24px;padding:2px 5px 3px 5px;}
</style>
</head>

<body>
<hr>
<script language="javascript">
function checkdata()
{
if (document.form2.query.value=="") {
alert ("请输入查询的关键字 ！")
return false
}
return true
}
</script>
<form id="form2" name="form2" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>"  onsubmit="return checkdata()">
  <table width="561" border="0" align="center">
    <tr>
      <th width="546" align="left" scope="col" class="th1">
      <label>
        <input name="query" type="text" id="query" size="40" class= "text1" />
        <input type="submit" name="Submit" value="搜索" class="submit1" />
      </label></th>
    </tr>
    <tr>
      <td class="noborder">搜索分类：
        <input name="search" type="radio" value="machine_name" checked="checked" />机器名&nbsp;&nbsp;
        <input value="idc" type="radio" name="search" />
        机房
        <input value="factory" type="radio" name="search" />
        厂商
        <input value="mem" type="radio" name="search" />
        内存大小
        &nbsp;&nbsp;
        <input value="disk" type="radio" name="search" />
        硬盘大小
        <input value="machine_type" type="radio" name="search" /> 
        机型
        <input value="contact" type="radio" name="search" />
        联系人</td>
    </tr>
    <tr>
      <td  class="noborder">机器状态：
        <input value="all" type="radio" name="status" />全部&nbsp;&nbsp;
        <input value="free" type="radio" name="status" />
        空闲
        &nbsp;
        <input value="borrow" type="radio" name="status" />
        已借用
        &nbsp;&nbsp;
        <input value="online" type="radio" name="status" />
        已上线
      &nbsp;</td>
    </tr>
  </table>
</form>
<?php

require_once("config/inc.php");
require_once("config/turn_page.php");
require_once("config/auth.php");

extract($_POST);
extract($_GET);
if($query){
		switch($_REQUEST["search"]) 
		{
			case "machine_name":
					$sql = "select * from dmop_freemachine where pid = '0' and machine_name like '%".$query."%'";
					break;
			case "idc":
					$sql = "select * from dmop_freemachine where pid = '0' and idc like '%".$query."%'";
					break;
			case "factory":
					$sql = "select * from dmop_freemachine where pid = '0' and factory like '%".$query."%'";
					break;
			case "mem":
					$sql = "select * from dmop_freemachine where pid = '0' and mem like '%".$query."%'";
					break;
			case "disk":
					$sql = "select * from dmop_freemachine where pid = '0' and disk like '%".$query."%'";
					break;
			case "machine_type":
					$sql = "select * from dmop_freemachine where pid = '0' and machine_type like '%".$query."%'";
					break;
			case "contact":
					$sql = "select * from dmop_freemachine where pid = '0' and contact like '%".$query."%'";
					break;
		}
		switch($_REQUEST["status"]) 
		{
			case "all":
					$str = "";
					break;
			case "free":
					$str = " and status = '空闲' order by idc desc";
					break;
			case "borrow":
					$str = " and status = '已借用' order by idc desc";
					break;
			case "online":
					$str = " and status = '已上线' order by idc desc";
					break;	
		}
	
	$pg = & new turn_page();
	$sql = $sql.$str;
	$query = mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query);
	if( $num == '0' ){ echo "<script>alert('搜索的内容不存在！');location.href='$_SERVER[PHP_SELF]';</script>";exit(); }

?>
<form id="form1" name="form1" method="POST" action="dmop_export.php?action=freemachine&sql=<?php echo urlencode($sql) ?>" >

<table width="890" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC">
    <tr>
      <th colspan="2" bgcolor="#CCCCCC" class="check firstLine">id</th>
      <th bgcolor="#CCCCCC">机器名</th>
      <th bgcolor="#CCCCCC">IDC</th>
      <th bgcolor="#CCCCCC">机器厂商</th>
      <th bgcolor="#CCCCCC">机器内存</th>
      <th bgcolor="#CCCCCC">机器磁盘</th>
      <th bgcolor="#CCCCCC">机器状态</th>
      <th bgcolor="#CCCCCC">机型</th>
      <th bgcolor="#CCCCCC">联系人</th>
      <th bgcolor="#CCCCCC">编缉</th>
    </tr>
<?php
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '20';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
	$sql = $sql." limit ".$limit."" ;
	$query = mysql_query($sql) or die(mysql_error());
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td colspan="2"  align="center" class="firstLine"><?php echo $result["id"] ?> </td>
      <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["machine_name"]?></a></td>
      <td align="center"><?php echo $result["idc"]?></td>
      <td align="center"><?php echo $result["factory"]?></td>
      <td align="center"><?php echo $result["mem"]?></td>
      <td align="center"><?php echo $result["disk"]?></td>
      <td align="center"><?php echo $result["status"]?></td>
      <td align="center"><?php echo $result["machine_type"]?></td>
      <td align="center"><?php echo $result["contact"]?></td>
      <td align="center"><a href="dmop_freemachineedit.php?id=<?php echo $result["id"]?>">编缉</a></td>
    </tr>
<?php
}
?>
    <tr>
      <td class="bottomtd" align="center" valign="middle"><input name="exprot" type="submit" id="exprot"  onClick="javascript:return window.confirm('确定导出此批机器吗？')" value="导出机器列表" /></td>
      <td class="bottomtd" colspan="10" align="right"><? echo $page_num.'块/页 共<font color=red>'.$num.'</font>台 '.$pg->output(1);?></td>
    </tr>
<?php
}
?>
  </table>
</form>
</body>
</html>
