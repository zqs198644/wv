<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<title>支出查询</title>
<style>
*{margin:0;padding:0;}
#table1, #table2, #tongji,#detail{text-align:center;margin:10px 10px 10px 9px;font-size:13px;}
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

.STYLE1 {color: #FF0000}
.STYLE2 {color: #000000}
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
$currdate = date("Y-m-d");
extract($_GET);
extract($_POST);
?>
<body>
<div class="clear"></div>
<hr>
<blockquote>
  <form action="<?php echo $_SERVER['PHP_SELF']?>?action=search" method="POST">
    <table border="0" id="tongji">
      <tr>
        <th width="68" scope="col">报表查询:</th>
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
  <p>&nbsp;</p>
  <table width="873" height="116"  align="left" id="table1">
    <tr>
      <th width="121"  class="fline" scope="col">日期</th>
      <th  width="230" scope="col"> 物品名称 </th>
      <th  width="93" scope="col">单价</th>
      <th  width="73" scope="col">件数</th>
      <th  width="101" scope="col">支出类型</th>
      <th width="98" scope="col">支出金额</th>
      <th width="80"  scope="col">编缉|删除</th>
      <th width="41"  scope="col">详细</th>
    </tr>
    <?php
	if( $action == 'delete' ){
		$sql = "delete from expenses where id = '".$id."'";
		$query = mysql_query("$sql") or die(mysql_error());
		if($query){
			echo "<script>alert('删除成功！');location.href='$_SERVER[PHP_SELF]';</script>"; 
			mysql_close();
		}
	}
	
	//按日期查询
	if( $action == 'search' ){
		$sql = "select * from expenses where datetime between '".$startTime."' and '".$endTime."' order by datetime";
	}else{
		$sql = "select * from expenses order by datetime limit 30";
	}
	$query= mysql_query($sql);
	while($result = mysql_fetch_array($query))
	{
	    $total = $result[price] * $result[number];
		$total_money += $total;
?>
    <tr>
      <td height="4" align="center" class="fline" scope="col"><?php echo $result[datetime]?></td>
      <td width="230" align="center" scope="col"><?php echo $result[name]?></td>
      <td width="93" align="center" scope="col"><?php echo $result[price]?> 元 </td>
      <td width="73" align="center" scope="col"><?php echo $result[number]?></td>
      <td width="101" align="center" scope="col"><?php echo $result[type]?></td>
      <td align="center" scope="col"><?php echo $total?> 元 </td>
      <td align="center" scope="col">
	  <a href="infop_expensesedit.php?action=edit&id=<?=$result[id]?>">编缉</a>|<a href="<?php echo $_SERVER['PHP_SELF']?>?action=delete&id=<?=$result[id]?>">删除</a></td>
      <td align="center" scope="col"><a href="<?php echo $_SERVER['PHP_SELF']?>?action=detail&id=<?=$result[id]?>">详细</a></td>
    </tr>
    <?php
}
?>
    <tr>
      <td height="1" colspan="9" align="right" scope="col" class="bottomtd">总支出金额： <font color=red><?php echo $total_money?></font> 元</td>
    </tr>
    <tr>
      <td height="2" colspan="9" align="right" scope="col" class="bottomtd"><input type="submit" onclick="javascript:loca('infop_export.php?sql=<?php echo urlencode($sql);?>')" name="export" value="导出信息列表" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
<blockquote>
<script type="text/javascript">
function loca(a){
	loca_action = document.getElementById('form2')
	loca_action.action = a;
//	window.location.reload();
}
</script>

<?php
if( $action == 'detail' ){
	$query= mysql_query("select * from expenses where id = '$id'");
	$result = mysql_fetch_array($query);
?>
  <table id=detail width="464" height="209" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">支出金额明细</th>
    </tr>
    <tr>
      <td width="141"  align="center">物品名称：</td>
      <td width="307" align="left"><label><span class="STYLE1"><span class="STYLE2"><?php echo $result[name]?></span></span></label></td>
    </tr>
    <tr>
      <td  align="center">物品单价：</td>
      <td align="left"><label><span class="STYLE1"><span class="STYLE2"><?php echo $result[price]?> 元 </span></span></label></td>
    </tr>
    <tr>
      <td  align="center">物品数量：</td>
      <td width="307" align="left"><?php echo $result[number]?>         件</td>
    </tr>
    <tr>
      <td align="center">录入人名： </td>
      <td align="left"><?php echo $result[name]?></td>
    </tr>
    <tr>
      <td align="center">说明：</td>
      <td><label>
        <textarea name="comment" cols="40" rows="4" id="comment"><?php echo $result[comment]?></textarea>
      </label></td>
    </tr>
    <tr>
      <td align="center">支出日期：</td>
      <td align="left"><?php echo $result[datetime]?></td>
    </tr>
</table>
<?php }?>
</body>
</html>
