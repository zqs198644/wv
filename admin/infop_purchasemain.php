<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<title>故障报修统计</title>
<style>
*{margin:0;padding:0;}
#table1, #table2, #tongji{margin:10px 10px 10px 9px;font-size:13px;}
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
#form1 #form2 .fline input{width:20px;}

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
require_once("config/turn_page.php");
$week = time() - (7 * 24 * 60 * 60); 
$start=date("Y-m-d",$week);
$end = date("Y-m-d");
extract($_GET);
extract($_POST);
switch($action) 
{
			case "delete":
					$sql = "delete from purchase where id = '".$id."'";
					$query = mysql_query($sql) or die(mysql_error());
					if($query){
						echo "<script>alert('信息删除成功！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					}else{
						echo "<script>alert('信息删除失败！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					}
					break;
}
?>
<body>
<div class="clear"></div>
<hr>
<blockquote>
  <form action="<?php echo $_SERVER['PHP_SELF']?>?action=search" method="POST">
    <table border="0" id="tongji">
      <tr>
        <th width="68" scope="col">进货查询:</th>
	    <td width="199" scope="col">从：
        <input name="start" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)" value="<?php echo $start?>" /></td>
        <td width="217" scope="col">至：
        <input name="end" type="text" class="firstLine" id="endTime" onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)"  value="<?php echo $end?>" /></td>
        <td width="112" align="center" valign="middle" class="bottomtd" scope="col">
          <input name="search" type="submit" id="search" value="查询" />        </td>
      </tr>
    </table>
 </form>
<form id="form2" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=export"> 
  <table width="823"  align="left" id="table1">
    <tr>
      <th width="86" class="fline" scope="col">日期</th>
      <th width="114"  scope="col">品类</th>
      <th width="62" scope="col">只数</th>
      <th width="50"  scope="col">箱数</th>
      <th width="75" scope="col">斤数</th>
      <th width="75"  scope="col">总额</th>
      <th width="227" scope="col">说明</th>
      <th width="45" scope="col">编缉</th>
      <th width="49" scope="col">删除</th>
    </tr>
    <?php
	if( $action == 'search' ){
		$sql = "select * from purchase where datetime between '".$start."' and '".$end."' order by datetime";
	}else{
		$sql = "select * from purchase order by datetime";
	}
	//总采购金额
	$money_query = mysql_query("select sum(money) money from purchase");
	$total_money = mysql_fetch_array($money_query);
	//区间采购金额
	$qujian_query = mysql_query("select sum(money) money from purchase where datetime between '".$start."' and '".$end."'");
	$qujian_money = mysql_fetch_array($qujian_query);
	//分页功能
	$pg = & new turn_page();
	$query= mysql_query($sql);
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '35';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sqllimit = $sql ." limit ".$limit;
	$query = mysql_query($sqllimit) or die(mysql_error());
	
	while($result = mysql_fetch_array($query))
	{
		//区间采购金额
//		$money += $result[money]; 
//		echo date("z",strtotime($result[datetime]))."-----".$result[datetime];
		$datenum=date("z",strtotime($result[datetime]));
//		$total_money +=$result[money];
		if ($datenum%2 == '0'){
			echo "<tr bgcolor=#F4F5BB>";
		}else{
			echo "<tr>";
		}
?>
      <td align="center" class="fline" scope="col"><?php echo $result[datetime]?></td>
      <td align="center" scope="col"><?php echo $result[category]?></td>
      <td align="center" scope="col"><?php echo $result[number]?></td>
      <td align="center" scope="col"><?php echo $result[box]?></td>
      <td align="center" scope="col"><?php echo $result[pounds]?> 斤</td>
      <td align="center" scope="col"><?php echo $result[money]?> 元</td>
      <td align="right" scope="col"><?php echo $result[comment]?> </td>
      <td align="center" scope="col"><a href="infop_purchaseedit.php?id=<?php echo  $result["id"]?>">编缉</a></td>
      <td align="center" scope="col" onClick="javascript:return window.confirm('确定要删除信息吗？')"><a href="<?php echo $_SERVER['PHP_SELF']."?action=delete&id=".$result[id]?>">删除</a></td>
    </tr>
    <?php
}
?>
    <tr>
      <td height="1" colspan="10" align="right" class="bottomtd" scope="col">【 采购总金额：<font color=red><?php echo $total_money[money]?></font> 元，区间采购金额：<font color="red"><?php echo $qujian_money[money]?></font> 元 】<? echo $page_num.'条/页 共<font color=red>'.$num.'</font>条 '.$pg->output(1);?></td>
    </tr>
    <tr>
      <td height="2" colspan="10" align="right" scope="col" class="bottomtd"><input type="submit" onclick="javascript:loca('infop_export.php?action=purchase&sql=<?php echo urlencode($sql);?>')" name="export" value="导出信息列表" /></td>
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
