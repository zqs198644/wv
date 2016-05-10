<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<title>集群图监控展示</title>
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

<body>

<?php
require_once("config/inc.php");
require_once("config/auth.php");
require_once("rrd_options.php");
$currdate = date("Y-m-d H:i:s");
extract($_GET);
extract($_POST);
if( "$action" == 'update' )
{
	$start = strtotime($startTime);
	$end = strtotime($endTime);
}
?>
<hr>

<form action="<? $_SERVER['PHP_SELF']?>?action=update&nodename=<?php echo $nodename?>" method="POST">
<table border="0" id="tongji">
<tr>
	<td><a href="<? $_SERVER['PHP_SELF']?>?start=now-1h&end=-300&nodename=<?php echo $nodename?>">1小时</a></td>
	<td><a href="<? $_SERVER['PHP_SELF']?>?start=now-1d&end=-300&nodename=<?php echo $nodename?>">1天</a></td>
	<td><a href="<? $_SERVER['PHP_SELF']?>?start=now-3d&end=-300&nodename=<?php echo $nodename?>">3天</a></td>
	<td><a href="<? $_SERVER['PHP_SELF']?>?start=now-7d&end=-300&nodename=<?php echo $nodename?>">7天</a></td>
	<td><a href="<? $_SERVER['PHP_SELF']?>?start=now-30d&end=-300&nodename=<?php echo $nodename?>">1月</a></td>
	<td><a href="<? $_SERVER['PHP_SELF']?>?start=now-365d&end=-300&nodename=<?php echo $nodename?>">1年</a></td>
	<td scope="col">从：
	  <input name="startTime" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss',0,0)" value="<?php echo $currdate?>" /></td>
    <td scope="col">至：
      <input name="endTime" type="text" class="firstLine" id="endTime" onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss',0,0)"  value="<?php echo $currdate?>" /></td>
    <td align="center" valign="middle" class="bottomtd" scope="col">
      <input type="submit" name="Submit" value="更新" />    </td>
  </tr>
</table>
集群模式：
<select name="select" onchange="getNodeName(this.options[this.selectedIndex].value)">
<?php
	$query = mysql_query("select * from infop_nodename") or die(mysql_error());
	while($result = mysql_fetch_array($query)){
		if( $_GET[nodename] == $result[nodename] )
		{
			$selected = 'selected';
		}else{
			$selected = '';
		}
	 	echo " <option value=$result[nodename] $selected>". $result[nodename] ."</option>";
	}

?>
</select>
</form>
<hr>
<script type="text/javascript">
function getNodeName(nodename){
location.href='?nodename='+nodename;
}
</script>
<?php
		if( $start == '' && $end == ''){
			$start="now-1d";
			$end="-300";
		}
		if( $nodename == ''){
			$sql = "select * from infop_nodename limit 1";
		}else{
			$sql = "select * from infop_nodename where nodename='".$nodename."'";
		}
		$query = mysql_query($sql) or die(mysql_error());
		$result = mysql_fetch_array($query);
		$type = explode(',',"$result[type]");
		for($i=0;$i<count($type);$i++){
			echo "<table align='center'><td  border='0'><img src='graph.php?start=$start&end=$end&type=$type[$i]&hostname=$result[nodename]' alt='Graph Source $result[nodename]/Properties'></td></table>";
		}
?>

</body>
</html>
