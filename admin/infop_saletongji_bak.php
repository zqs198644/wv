<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<title>销售统计</title>
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
.table1 th, .table td{padding-right:20px;}
.table1{border:1px solid #ddd;}
table input{ vertical-align:middle;}
.table2, .table3{ float:left;}
.clear{ clear:both;height:10px;}

#table1 {margin:10px 10px 10px 9px;font-size:13px;}
#table2 {margin:10px 10px 10px 9px;font-size:13px;}
</style>
</head>
<?php 
require_once("config/inc.php");
require_once("config/auth.php");
require_once("config/turn_page.php");
require_once("amchart/api/amchart_line_function.php");
$currdate = time();
$month = time() - (30 * 24 * 60 * 60); 
$startTime=date("Y-m-d",$month);
$endTime = date("Y-m-d");
extract($_GET);
extract($_POST);
if ( $action == 'search'){
		$start = $start;
		$end = $end;
}else{
		$start = $startTime;
		$end = $endTime;
}

		$profit_sql = "select s.category as category, sum(money) as money,sum(money-(money/price)*cost) as profit,(profit/money) as percent from sale s, category c where s.category = c.category and datetime between '".$start."' and  '".$end."' group by s.category order by profit desc limit 15";
		$fav_sql = "select s.category as category,sum( money ) as money,sum(money/price) as pound from sale s,category c where s.category=c.category  and  datetime between '".$start."' and  '".$end."' group by s.category order by pound desc limit 15 ";
		$money_sql = "select datetime,sum(money) as money from sale where  datetime  between '".$start."' and  '".$end."' group by datetime ";

/*		//销售总量统计
		$total_money = mysql_fetch_array(mysql_query("select sum(money) as money from sale where  datetime between '".$start."' and  '".$end."'")) or die(mysql_error());
	    $total_cost = mysql_fetch_array(mysql_query("select sum((money/price)*cost) as cost from category c , sale s where s.category=c.category and datetime between '".$start."' and  '".$end."'")) or die(mysql_error());
	    $total_profit = mysql_fetch_array(mysql_query("select sum(money-(money/price)*cost) as profit from category c , sale s where s.category=c.category and datetime between '".$start."' and  '".$end."'")) or die(mysql_error());



   	    $profit_sql = "select * from sale s, category c where s.category = c.category and datetime between '".$start."' and  '".$end."' group by s.category order by profit desc limit 15";
		$fav_sql = "select * from sale s,category c where s.category=c.category  and datetime between '".$start."' and  '".$end."' group by s.category order by pound desc limit 15 ";
		$money_sql = "select datetime,sum(money) as money from sale where  datetime between '".$start."' and  '".$end."' group by datetime ";
*/		
		//销售总量统计
		$query = mysql_query("select c.category,money,price,cost,number from sale s, category c where c.category=s.category and datetime between '".$start."' and  '".$end."'") or die(mysql_error());
	    while($result = mysql_fetch_array($query)){
				if($result[category] == "瓦罐鸡" ||  $result[category] == "荷叶鸡" ){
					$profit = $result[money] -round($result[cost]*$result[number],2);
					$cost = round($result[cost]*$result[number],2);
				}else{
					$profit =  $result[money] - ($result[money]/$result[price])*$result[cost];
					$cost = ($result[money]/$result[price])*$result[cost];
			    }
			    $total_profit +=$profit;
				$total_cost +=$cost;
				$total_money +=$result[money];
		}	
?>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']?>?action=search" method="POST">
<table width="716" border="0" id="tongji">
<tr>
	<th width="36" scope="col"><a href="<? $_SERVER['PHP_SELF']?>?action=search&start=<?php echo date("Y-m-d",$currdate-24*3600);?>&end=<?php echo date("Y-m-d","$currdate");?>">1天</a></th>
	<th width="39" scope="col"><a href="<? $_SERVER['PHP_SELF']?>?action=search&start=<?php echo date("Y-m-d",$currdate-7*24*3600);?>&end=<?php echo date("Y-m-d","$currdate");?>">7天</a></th>
	<th width="34" scope="col"><a href="<? $_SERVER['PHP_SELF']?>?action=search&start=<?php echo date("Y-m-d",$currdate-30*24*3600);?>&end=<?php echo date("Y-m-d","$currdate");?>">1月</a></th>
	<th width="41" scope="col"><a href="<? $_SERVER['PHP_SELF']?>?action=search&start=<?php echo date("Y-m-d",$currdate-365*24*3600);?>&end=<?php echo date("Y-m-d","$currdate");?>">1年</a></th>
	<td width="206" scope="col">从：
	  <input name="start" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)" value="<?php echo $startTime?>" /></td>
    <td width="203" scope="col">至：
      <input name="end" type="text" class="firstLine" id="endTime" onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)"  value="<?php echo $endTime?>" /></td>
    <td width="127" align="center" valign="middle" class="bottomtd" scope="col">
      <input type="submit" name="Submit" value="查询" />    </td>
  </tr>
</table>
</form>
<div class="clear"></div>
<hr>
<table border="2" class="table1">
  <tr>
  	<th colspan="10"><?php echo "从  " .$start."  至  ".$end; ?></th>
  <tr>
  <tr>
    <th>总流水金额：</th>
    <th><font color="red"><?php echo $total_money?></font> 元</th>
    <th>总销售成本：</th>
    <th><font color="red"><?php echo round("$total_cost",0)?></font> 元</th>
    <th>总销售利润:</th>
    <th><font color="red"><?php echo round("$total_profit",0)?></font> 元</th>
    <th>利润/流水（百分比）</th>
    <th><font color="red"><?php echo round(($total_profit/$total_money)*100,0)?></font>%</th>
    <th>流水扣点：</th>
    <th><font color="red"><?php echo round(($total_money*0.08),0)?></font> 元</th>
  </tr>
</table>
<div class="clear"></div>
<table width="384" border="1" class="table2">
  <tr>
    <th width="220" bgcolor="#CCCCCC" scope="col">利润最高TOP10<br /></th>
    <th width="62" bgcolor="#CCCCCC" scope="col">金额</th>
    <th width="80" bgcolor="#CCCCCC" scope="col">利润</th>
  </tr>
<?php
	$query = mysql_query($profit_sql) or die(mysql_error());
	while($result = mysql_fetch_array($query)){
?>
	<tr>
    <td align="center"><?php echo $result[category]?></td>
    <td align="center"><?php echo $result[money]?> 元</td>
    <td align="center"><?php echo round("$result[profit]",2)?> 元 </td>
	</tr>
<?php
}
?> 
<!--<tr>
    <td colspan="3" align="center"><?php echo $start."  至  ".$end; ?></td>
    </tr>
!-->
</table>
<table width="384" border="1" class="table3">
  <tr>
    <th width="213" bgcolor="#CCCCCC" scope="col">最受欢迎 TOP10<br /></th>
    <th width="64" bgcolor="#CCCCCC" scope="col">金额</th>
    <th width="85" bgcolor="#CCCCCC" scope="col">斤数</th>
  </tr>
<?php
if ( $action == 'search'){
}else{
}
	$query = mysql_query($fav_sql) or die(mysql_error());
	while($result = mysql_fetch_array($query)){
?>
	<tr>
    <td align="center"><?php echo $result["category"]?></td>
    <td align="center"><?php echo $result["money"]?> 元</td>
    <td align="center"><?php echo round("$result[pound]",2);?> 斤</td>
	</tr>
<?php
}
?> 
<!-- <tr>
    <td colspan="3" align="center"><?php echo $start."  至  ".$end; ?></td>
   </tr> !-->
</table>
<div class="clear"></div>
<hr>
<?php
$query = mysql_query($money_sql) or die(mysql_error());
$data=array();
while($result = mysql_fetch_array($query)){
//    echo $result[datetime]."-----------".$result[money]."<br>";
	  $datetime = $result[datetime];
	  $money = $result[money];
      $data = array_merge($data,array($datetime=>$money));
}

$graph = array("name"=>"每日流水金额","data"=>$data);
$res = array("title"=>"流水金额: ".$start." 至 ".$end,"graph"=>array($graph));
//echo "<table align='center'><td  border='0'>".amchart_line_function($res)."</td></table>";
amchart_line_function($res);			
?>
<div class="clear"></div>
<hr>
<table width="840"  align="left" id="table1">
  <tr>
    <th width="62" class="fline" scope="col">日期</th>
    <th width="73"  scope="col">星期</th>
    <th width="102"  scope="col">流水金额</th>
    <th width="136" scope="col">成本(/斤)</th>
    <th width="118" scope="col">利润</th>
    <th width="137" scope="col">利润/流水(百分比)</th>
    <th width="76" scope="col">查看详细</th>
  </tr>
  <?php
  	$money = mysql_query("select sum(money) money from sale") or die(mysql_error());
	$money = mysql_fetch_array($money);
	if( $action == 'search' ){
		$sql = "select * from sale where datetime between '".$start."' and '".$end."' group by datetime";
	}else{
		$sql = "select * from sale group by datetime order by datetime desc";
	}	
		$query= mysql_query($sql)or die(mysql_error());
	//分页功能
	$pg = & new turn_page();	
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '15';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sqllimit = $sql ." limit ".$limit;
	$query = mysql_query($sqllimit) or die(mysql_error());
	
	while($result = mysql_fetch_array($query))
	{
		$week = date("w",strtotime($result[datetime]));
		$q = mysql_query("select * from category c,sale s where s.category=c.category and datetime = '".$result[datetime]."'") or die(mysql_error());
		$t_money = 0;
		$t_cost = 0;
		$t_profit = 0;
		while($res = mysql_fetch_array($q)){
				if($res[category] == "瓦罐鸡" ||  $res[category] == "荷叶鸡" ){
					$profit = $res[money] - $res[cost]*$res[number];
					$cost = $res[cost]*$res[number];
				}else{
					$profit =  $res[money] - ($res[money]/$res[price])*$res[cost];
					$cost = ($res[money]/$res[price])*$res[cost];
			    }
			    $t_profit +=$profit;
				$t_cost +=$cost;
				$t_money +=$res[money];
		}
		//区间求值
		$q_profit +=$t_profit;
		$q_profit +=$t_profit;
		$q_money +=$t_profit;
?>
  <tr>
    <td align="center" class="fline" scope="col"><?php echo $result[datetime]?></td>
    <td align="center" scope="col">星期 <?php echo $week ;echo $res[category] ;?></td>
    <td align="center" scope="col"><?php echo round($t_money,2)?> 元 </td>
    <td align="center" scope="col"><?php echo round($t_cost,2);?> 元</td>
    <td align="center" scope="col"><?php echo round($t_profit,2);?> 元</td>
    <td align="center" scope="col"><font color="red"><?php echo round(($t_profit/$t_money)*100,2);?></font> %</td>
    <td align="center" scope="col"><a href="infop_salemain.php?action=search&startTime=<?php echo $result[datetime]?>&endTime=<?php echo $result[datetime]?>">查看详细</a></td>
  </tr>
  <?php
}
?>
  <tr>
    <td height="1" colspan="8" align="right" scope="col" class="bottomtd">【销售流水金额：<font color="red"><?php echo $money[money]?></font> 元,（区间总流水：<font color="red"><?php echo $total_money;?></font> 元,区间成本：<font color="red"><?php echo round($total_cost,2);?></font> 元, 区间利润：<font color="red"><?php echo round($total_profit,2);?></font> 元,利润/流水：<font color="red"><?php echo round(($total_profit/$total_money)*100,2);?></font>%）】<? echo $page_num.'条/页 共<font color=red>'.$num.'</font>条 '.$pg->output(1);?></td>
  </tr>
  <tr>
    <td height="2" colspan="8" align="right" scope="col" class="bottomtd"><input type="submit" onclick="javascript:loca('infop_export.php?action=purchase&amp;sql=<?php echo urlencode($sql);?>')" name="export" value="导出信息列表" /></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
