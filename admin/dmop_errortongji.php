<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<title>故障报修统计</title>
<style>
*{margin:0;padding:0;}
.table1, .table2, .table3, #tongji{margin:10px 10px 10px 9px;font-size:12px;}
table td, table th{line-height:18px; border:1px solid #CCC;padding:2px 5px;}
table th, table th{background:#F4F5EB;color:#454545;font-weight:bold;}
table {border-collapse: collapse;border-spacing: 0;}
table .red{color:#F00;}
table .bold{font-weight:bold;}
table td input{border:1px solid #ddd;}
table .bottomtd input{width:90px;padding:0;height:24px;line-height:24px;}
table .check{width:60px;}
.errorP{ text-align:center;border:2px solid #ddd;border-width:2px 0;padding:8px 0;color:#4545;}
table .firstLine input{width:130px;}
.table1 th, .table td{border:none;padding-right:20px;}
.table1{border:1px solid #ddd;}
table input{ vertical-align:middle;}
.table2, .table3{ float:left;}
.clear{ clear:both;height:10px;}

</style>
</head>
<?php 
require_once("config/inc.php");
require_once("config/auth.php");
//$all = mysql_query("select * from dmop_error_disk") or die(mysql_error());
//$all_num = mysql_num_rows($all);
$repair = mysql_query("select * from dmop_error_disk where status = '报修'") or die(mysql_error());
$repair_num = mysql_num_rows($repair);
$finish = mysql_query("select * from dmop_error_disk where status = '处理完成'") or die(mysql_error());
$finish_num = mysql_num_rows($finish);
$current = mysql_query("select * from dmop_error_disk where status = '等待SA处理' or status = '接口人已处理' ") or die(mysql_error());
$current_num = mysql_num_rows($current);
$currdate = date("Y-m-d H:i:s");

?>
<body>
<hr>
<table border="1" class="table1">
  <tr>
    <th scope="col">等待处理的故障机器数：</th>
    <th scope="col"><font color="red"><?php echo $repair_num?></font></th>
    <th>正在处理的故障机器数：</th>
    <th><font color="red"><?php echo $current_num?></font></th>
    <th>已报修的故障机器总数：</th>
    <th><font color="red"><?php echo $finish_num?></font></th>
  </tr>
</table>
<div class="clear"></div>
<table width="384" border="1" class="table2">
  <tr>
    <th width="261" bgcolor="#CCCCCC" scope="col">故障类型 TOP10<br /></th>
    <th width="76" bgcolor="#CCCCCC" scope="col"><strong>故障次数</strong></th>
  </tr>
<?php
	$sql = "select error_type,count(*) as error_num from dmop_error_disk group by error_type order by error_num desc limit 10";
	$query = mysql_query($sql) or die(mysql_error());
	while($result = mysql_fetch_array($query)){
?>
	<tr>
    <td align="center"><?php echo $result["error_type"]?></td>
    <td align="center"><?php echo $result["error_num"]?></td>
	</tr>
<?php
}
?> 

</table>
<table width="384" border="1" class="table3">
  <tr>
    <th width="261" bgcolor="#CCCCCC" scope="col">故障机器 TOP10<br /></th>
    <th width="76" bgcolor="#CCCCCC" scope="col"><strong>故障次数</strong></th>
  </tr>
<?php
	$sql = "select machine_name,count(*) as machine_num from dmop_error_disk group by machine_name order by machine_num desc limit 10";
	$query = mysql_query($sql) or die(mysql_error());
	while($result = mysql_fetch_array($query)){
?>
	<tr>
    <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["machine_name"]?></a></td>
    <td align="center"><?php echo $result["machine_num"]?></td>
	</tr>
<?php
}
?> 

</table>
<div class="clear"></div>
<hr>
<form action="" method="get">
<table border="0" id="tongji">
<tr>
	<th scope="col">统计查询:</th>
	<td scope="col">从：
	  <input name="startTime" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss',0,0)" value="<?php echo $currdate?>" /></td>
    <td scope="col">至：
      <input name="endTime" type="text" class="firstLine" id="endTime" onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss',0,0)"  value="<?php echo $currdate?>" /></td>
    <td align="center" valign="middle" class="bottomtd" scope="col">
      <input type="submit" name="Submit" value="查询" />
    </td>
  </tr>
</table>
</form>

			

</body>
</html>
