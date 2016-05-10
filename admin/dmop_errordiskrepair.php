<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require_once("config/inc.php");
require_once("config/turn_page.php");
require_once("config/auth.php");
extract($_GET);
extract($_POST);
?>
<title>DMOP故障管理</title>
<style>
#form2 {margin:10px 10px 10px 9px;font-size:12px;}
#form2 td, #form2 th{line-height:18px; border:1px solid #CCC;padding:2px 5px;}
#form2 th{background:#F4F5EB;color:#454545;font-weight:bold;}
table {border-collapse: collapse;border-spacing: 0;}
#form2 .red{color:#F00;}
#form2 .bgblue{background:#0CF;}
#form2 .bold{font-weight:bold;}
#form2 select{width:103px;height:18px; line-height:18px;}
#form2 td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form2 .bottomtd{height:30px;padding:5px 10px;}
#form2 .bottomtd input{width:80px;height:24px;line-height:24px;}
#form2 .check{width:80px;}
.errorP{ text-align:center;border:2px solid #ddd;border-width:2px 0;padding:8px 0;color:#4545;}
</style>
</head>
<body>

<p class="errorP"><strong>故障机器报修情况</strong></p>

<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=deluser">
  <table width="890" align="center">
    <tr>
      <th class="check">id</th>
      <th>机器名</th>
      <th>IDC</th>
      <th>故障硬盘</th>
      <th>状态</th>
      <th>所属部门</th>
      <th>报修人</th>
      <th>报修时间</th>
    </tr>
    <?php
	$pg = & new turn_page();
	
    $query_num = mysql_query("select * from dmop_error_disk where machine_name = '".$machine."'");
	$num = mysql_num_rows($query_num);
    $repair = mysql_query("select * from dmop_error_disk where machine_name = '".$machine."' and status = '报修'");
  	$repair_num = mysql_num_rows($repair);
	
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '20';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
	$sql = "select * from dmop_error_disk where machine_name = '".$machine."' order by status,report_date limit ".$limit."";
	$query = mysql_query($sql) or die(mysql_error());
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td  align="center"><?php echo $result["id"] ?> </td>
      <td align="center"><?php echo $result["machine_name"]?></td>
      <td align="center"><?php echo $result["idc"]?></td>
      <td align="center"><?php echo $result["error_disk"]?></td>
      <td align="center"><?php echo $result["status"]?></td>
      <td align="center"><?php echo $result["department"]?></td>
      <td align="center"><?php echo $result["reporter"]?></td>
      <td align="center"><?php echo $result["report_date"]?></td>
    </tr>
<?php
}
?>
    <tr>
      <td colspan="8" align="right" valign="middle" class="bottomtd">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;<? echo $page_num.'块/页  报修状态 <font color=red>'.$repair_num.'</font> 块, 共<font color=red> '.$num.'</font> 块 '.$pg->output(1);?></td>
    </tr>
  </table>
</form>


</body>
</html>
