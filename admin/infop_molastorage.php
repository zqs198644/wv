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
#form1 .fline input{width:20px;}

</style>
</head>

<script type="text/javascript">
function getType(cluster){
location.href='?cluster='+cluster;
}
</script>
<?php 
require_once("config/inc.php");
require_once("config/auth.php");
$currdate = date("Y-m-d H:i:s");
extract($_GET);
extract($_POST);

$query_s = mysql_query("select distinct cluster from infop_mola_storage limit 1");
$result_s =  mysql_fetch_array($query_s);
if ( $cluster == ''){
	$cluster = $result_s[cluster];
}
if( $action == 'search' ){
	$sql = "select * from infop_mola_storage where cluster = '".$cluster."' and datetime between '".$startTime."' and '".$endTime."'";
}elseif( $cluster != ''){
	$sql = "select * from infop_mola_storage where cluster = '".$cluster."' order by id limit 7";
}else{
	$sql = "select * from infop_mola_storage order by cluster limit 7";
}
	 $query_s = mysql_query("select distinct cluster from infop_mola_storage limit 1");
	 $result_s =  mysql_fetch_array($query_s);
?>
<body>
<div class="clear"></div>
<hr>
<blockquote>
  <form action="<?php echo $_SERVER['PHP_SELF']?>?action=search&cluster=<? echo $_GET[cluster]?>" method="POST">
    <table border="0" id="tongji">
      <tr>
        <th width="68" scope="col">报表查询:</th>
	    <td width="199" scope="col">从：
        <input name="startTime" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss',0,0)" value="<?php echo $currdate?>" /></td>
        <td width="217" scope="col">至：
        <input name="endTime" type="text" class="firstLine" id="endTime" onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss',0,0)"  value="<?php echo $currdate?>" /></td>
        <td width="112" align="center" valign="middle" class="bottomtd" scope="col">
          <input type="submit" name="Submit" value="查询" />        </td>
      </tr>
    </table>
 </form>
<form id="form2" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=export"> 
  <p>&nbsp;</p>
  <table width="844" height="54" border="1" align="left">
    <tr>
      <th width="197" class="fline" scope="col">日期</th>
      <th  scope="col"><select name="select" size="1" id="select" onChange="getType(this.options[this.selectedIndex].value)"> 
	 <?php
	 $query = mysql_query("select distinct cluster from infop_mola_storage");
	 while($result = mysql_fetch_array($query))
	 {
	 ?>
          <option value="<?=$result[cluster]?>" <? if($_GET[cluster]=="$result[cluster]") echo 'selected'?>>
            <?=$result[cluster]?>
          </option>
	<? }?>
		  </select></th>
      <th scope="col">总存储空间</th>
      <th scope="col">已用存储空间</th>
      <th scope="col">剩余空间</th>
      <th width="87"  scope="col">可用空间</th>
      <th width="64"  scope="col">变化率</th>
    </tr>
<?php
	$query = mysql_query($sql) or die(mysql_error());
	while($result = mysql_fetch_array($query))
	{
	  $yesterday = date("Y-m-d H:i:s",strtotime("$result[datetime]")-3600*24);
	  $query_y = mysql_query("select * from infop_mola_storage where datetime = '".$yesterday."'");
	  $result_y = mysql_fetch_array($query_y);
	  $rchange =($result[used] - $result_y[used])/100;
?>
    <tr>
      <td height="4" align="center" class="fline" scope="col"><?php echo $result[datetime]?></td>
      <td width="138" align="center" scope="col"><?php echo $result[cluster]?></td>
      <td width="104" align="center" scope="col"><?php echo $result[total]?></td>
      <td width="118" align="center" scope="col"><?php echo $result[used]?></td>
      <td width="90" align="center" scope="col"><?php echo $result[free]?></td>
      <td align="center" scope="col"><?php echo $result[avail]?></td>
      <td colspan="2" align="center" scope="col"><?php echo $rchange?></td>
    </tr>
<?php
}
?>
    <tr>
      <td height="5" colspan="8" align="right" scope="col" class="bottomtd">       
	   <input type="submit" onClick="javascript:loca('infop_export.php?sql=<?php echo urlencode($sql);?>')" name="export" value="导出信息列表" />
</td>
    </tr>
  </table>
</form>
<blockquote>
<script type="text/javascript">
function loca(a){
	loca_action = document.getElementById('form2')
	loca_action.action = a;
//	window.location.reload();
}
</script>
</body>
</html>
