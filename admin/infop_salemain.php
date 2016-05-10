<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<title>销售管理</title>
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
$currdate = date("Y-m-d");
extract($_GET);
extract($_POST);
switch($action) 
{
			case "delete":
					$sql = "delete from sale where id = '".$id."'";
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
        <th width="68" scope="col">销售查询:</th>
	    <td width="199" scope="col">从：
        <input name="startTime" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)" value="<?php echo $currdate?>" /></td>
        <td width="217" scope="col">至：
        <input name="endTime" type="text" class="firstLine" id="endTime" onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)"  value="<?php echo $currdate?>" /></td>
        <td width="112" align="center" valign="middle" class="bottomtd" scope="col">
          <input name="search" type="submit" id="search" value="查询" />        </td>
      </tr>
    </table>
 </form>
<form id="form2" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=export"> 
  <table width="900"  align="left" id="table1">
    <tr>
      <th width="70" class="fline" scope="col">日期</th>
      <th width="59"  scope="col">品类</th>
      <th width="40" scope="col">只数</th>
      <th width="68"  scope="col">售出斤数</th>
      <th width="108"  scope="col">实际每只（斤）</th>
      <th width="64" scope="col">消耗(/斤)</th>
      <th width="155" scope="col">成本(/斤)</th>
      <th width="67" scope="col">单价(/斤)</th>
      <th width="49" scope="col">利润</th>
      <th width="68" scope="col">销售额</th>
      <th width="51" scope="col">编缉</th>
      <th width="49" scope="col">删除</th>
    </tr>
    <?php
	if( $action == 'search' ){
		$sql = "select * from category c,sale s where s.category=c.category and datetime between '".$startTime."' and '".$endTime."' order by datetime";
	}else{
		$sql = "select * from category c,sale s where s.category=c.category order by datetime";
	}
	$money = mysql_query("select sum(money) money from sale") or die(mysql_error());
	$total_money = mysql_fetch_array($money);
	
	//分页功能
	$pg = & new turn_page();
	
	$query= mysql_query($sql)or die(mysql_error());
	
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '30';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sqllimit = $sql ." limit ".$limit;
	$query = mysql_query($sqllimit) or die(mysql_error());
	
	while($result = mysql_fetch_array($query))
	{
		$pounds = round($result[money]/$result[price],2);


//		echo date("z",strtotime($result[datetime]))."-----".$result[datetime];
		$datenum=date("z",strtotime($result[datetime]));
		if ($datenum%2 == '0'){
			echo "<tr bgcolor=#F4F5BB>";
		}else{
			echo "<tr>";
		}
?>
      <td align="center" class="fline" scope="col"><?php echo $result[datetime]?></td>
      <td align="center" scope="col"><?php echo $result[category]?></td>
      <td align="center" scope="col"><?php echo $result[number]?></td>
      <td align="center" scope="col"><?php echo $pounds?> 斤</td>
      <td align="center" scope="col"><?php if($result[number] == ''){echo 0;}else{echo round($pounds/$result[number],2);}?> 斤</td>
      <td align="center" scope="col"><?php echo $result[consume]?> 斤 </td>
      <td align="left" scope="col"><?php if($result[category] == "瓦罐鸡" || $result[category] == "荷叶鸡" )
	  										{
													$cost = round($result[cost]*$result[number],2);
													echo "($result[cost]元*$result[number]只)= ".$cost;
											}else{
													$cost = round($result[cost]*$pounds,2);
													echo "($result[cost]元*$pounds 斤)= ".$cost;
												 }
										 $profit =round($result[money]-$cost,2);
										 $total_profit +=$profit;
										 $meney +=$result[money];
										 $percent = round(($total_profit/$meney)*100,2);
								   ?> 元</td>
      <td align="center" scope="col"><?php echo $result[price];?> 元</td>
      <td align="center" scope="col"><?php echo $profit;?> 元</td>
      <td align="center" scope="col"><?php echo $result[money]?> 元</td>
      <td align="center" scope="col"><a href="infop_saleedit.php?id=<?php echo  $result[id]?>">编缉</a></td>
      <td align="center" scope="col onClick="javascript:return window.confirm('确定要删除信息吗？')"><a href="<?php echo $_SERVER['PHP_SELF']."?action=delete&id=".$result[id]?>">删除</a></td>
    </tr>
    <?php
}
?>
    <tr>
      <td height="1" colspan="13" align="right" scope="col" class="bottomtd">【销售总流水金额：<font color="red"><?php echo $total_money[money]?></font> 元， （区间总流水：<font color="red"><?php echo $meney;?></font> 元 区间利润：<font color="red"><?php echo $total_profit;?></font> 元，利润/流水：<font color="red"><?php echo $percent;?></font>%）】<? echo $page_num.'条/页 共<font color=red>'.$num.'</font>条 '.$pg->output(1);?></td>
    </tr>
    <tr>
      <td height="2" colspan="13" align="right" scope="col" class="bottomtd"><input type="submit" onclick="javascript:loca('infop_export.php?action=purchase&sql=<?php echo urlencode($sql);?>')" name="export" value="导出信息列表" /></td>
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
