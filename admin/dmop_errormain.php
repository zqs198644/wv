<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require_once("config/inc.php");
require_once("config/turn_page.php");
require_once("config/auth.php");
?>
<title>DMOP故障管理</title>
<style>
*{margin:0;padding:0;}
table {border-collapse: collapse;border-spacing: 0;}
#form2 {margin:10px 10px 10px 9px;font-size:12px;}
#form2 td, #form2 th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form2 input{vertical-align:middle;}
#form2 th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form2 th input{height:18px;}
#form2 .red{color:#F00;}
#form2 .bgblue{background:#0CF;}
#form2 .bold{font-weight:bold;}
#form2 select{width:103px;height:18px; line-height:18px;}
#form2 td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form2 .bottomtd input{width:60px;height:24px;line-height:24px;}
#form2 .bottomtd1 input{width:85px;height:24px;line-height:24px;}
#form2 .check{width:60px;}
.errorP{ text-align:center;padding:5px 0;font-weight:bold;color:#454545;}
#form2 .firstLine input{width:15px;}
#form2 .noborder input{ border:none;}
</style>
</head>
<body>
<?php
extract($_GET);
extract($_POST);
if ( $error_num != '0' ){
switch($action) 
{
			case "repair":
					$sql = "update dmop_error_disk set status = '接口人已处理' where machine_name in (select machine_name from (select machine_name,count(*) as a from dmop_error_disk where status='报修'  group by machine_name order by report_date) as b where a <= 3 ) and status='报修' ";
					$query = mysql_query($sql) or die(mysql_error());
					mysql_query("update dmop_stat set status_values = '2'") or die(mysql_error());
					if($query){
						echo "<script>alert('接口人已处理！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					}else{
						echo "<script>alert('状态处理有误！');location.href='$_SERVER[PHP_SELF]';</script>";
					}
					break;
			case "oper":
					$sql = "update dmop_error_disk set status = '等待SA处理'  where machine_name in (select machine_name from (select machine_name,count(*) as a from dmop_error_disk where status='接口人已处理'  group by machine_name order by report_date) as b where a <= 3 ) and status = '接口人已处理' ";
					$query = mysql_query($sql) or die(mysql_error());
					mysql_query("update dmop_stat set status_values = '3'") or die(mysql_error());
					if($query){
						echo "<script>alert('等待SA处理！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					}else{
						echo "<script>alert('状态处理有误！');location.href='$_SERVER[PHP_SELF]';</script>";
					}
					break;
			case "tosa":
					$sql = "update dmop_error_disk set status = '等待加入集群' where machine_name in (select machine_name from (select machine_name,count(*) as a from dmop_error_disk where status='等待SA处理'  group by machine_name order by report_date) as b where a <= 3 ) and status = '等待SA处理'";
					$query = mysql_query($sql) or die(mysql_error());
					mysql_query("update dmop_stat set status_values = '4'") or die(mysql_error());
					if($query){
						echo "<script>alert('等待加入集群！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					}else{
						echo "<script>alert('状态处理有误！');location.href='$_SERVER[PHP_SELF]';</script>";
					}
					break;
			case "finish":
					$sql = "update dmop_error_disk set status = '处理完成' where machine_name in (select machine_name from (select machine_name,count(*) as a from dmop_error_disk where status='等待加入集群'  group by machine_name order by report_date) as b where a <= 3 ) and status = '等待加入集群'";
					$query = mysql_query($sql) or die(mysql_error());
					mysql_query("update dmop_stat set status_values = '1'") or die(mysql_error());
					if($query){
						echo "<script>alert('处理完成！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					}else{
						echo "<script>alert('状态处理有误！');location.href='$_SERVER[PHP_SELF]';</script>";
					}
					break;
		}
}else{
					echo "<script>alert('没有机器可报修，请不要误点击！');location.href='$_SERVER[PHP_SELF]';</script>";
}
?>
<hr />
<p class="errorP">故障机器单磁盘报修</p>
  <!--全选-->
<script language="javascript">
function select_all()
{ 
  for(var i=0;i<document.form2.elements.length;i++)
  {
     if(document.form2.elements[i].name=="checkbox[]")
     {
        if(document.form2.elements[i].checked==false)
             document.form2.elements[i].checked=true;
        else document.form2.elements[i].checked=false;
     }
  }
}

  </script>

<?php
$query = mysql_query("select * from dmop_stat");
$result = mysql_fetch_array($query) or die(mysql_error());
if( $result[status_values] == '1' ){
		echo "<form id=form2 name=form2 method=post action=".$_SERVER['PHP_SELF']."?action=repair>";
		$status = '报修';
		$onclick = "报修";
 }elseif( $result[status_values] == '2' ){
 		echo "<form id=form2 name=form2 method=post action=".$_SERVER['PHP_SELF']."?action=oper>";
		$status = '接口人已处理';
		$onclick = "SA处理";
 }elseif( $result[status_values] == '3' ){
 		echo "<form id=form2 name=form2 method=post action=".$_SERVER['PHP_SELF']."?action=tosa>";
		$status = '等待SA处理';
		$onclick = "上线";
 }elseif( $result[status_values] == '4' ){
 		echo "<form id=form2 name=form2 method=post action=".$_SERVER['PHP_SELF']."?action=finish>";
		$status = '等待加入集群';
		$onclick = "完成";
 }

?>
  <table width="890" align="center">
    <tr>
      <th class="check firstLine"><input type="checkbox" name="checkbox" value="checkbox" onclick="select_all()" />全选</th>
      <th width="60">id</th>
      <th>机器名</th>
      <th>故障硬盘</th>
      <th>IDC</th>
      <th>状态</th>
      <th>所属部门</th>
      <th>报修人</th>
      <th>报修时间</th>
      <th>详细</th>
    </tr>
<?php
	$pg = & new turn_page();
	$sql = "select * from  dmop_error_disk where machine_name in (select machine_name from (select machine_name,count(*) as a from dmop_error_disk where status='".$status."'  group by machine_name order by report_date) as b where a <= 3 ) and status='".$status."'  order by idc,report_date desc" ;
    $query=mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '20';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sqllimit = $sql ." limit ".$limit;
	$query = mysql_query($sqllimit) or die(mysql_error());
	$error_num = mysql_num_rows($query);
	if( $error_num == '0' ){
?>
    <tr>
      <td colspan="10"  align="center" class="firstLine">目前没有状态的历史记录
      <input name="error_num" type="hidden" id="error_num" value="<?php echo  $error_num?>" /></td>
    </tr>
<?php	
	}
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td  align="center" class="firstLine noborder"><label>
        <input type="checkbox" name="checkbox[]" value="<?php echo $result["id"]?>">
      </label></td>
      <td align="center"><?php echo $result["id"] ?> </td>
      <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["machine_name"]?></a><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"></a></td>
      <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["error_disk"]?></a><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"></a></td>
      <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["idc"]?></a></td>
      <td align="center"><?php echo $result["status"]?></td>
      <td align="center"><?php echo $result["department"]?></td>
      <td align="center"><?php echo $result["reporter"]?></td>
      <td align="center"><?php echo $result["report_date"]?></td>
      <td align="center"><a href="dmop_errordiskview.php?id=<?php echo $result["id"]?>">详细</a></td>
    </tr>
<?php
}
?>
    <tr>
      <td class="bottomtd" align="center" valign="middle"><input type="submit" name="Submit3"  onClick="javascript:return window.confirm('确定要<?php echo $onclick?>此批机器吗？')" value="<?php echo $onclick;?>" /></td>
      <td class="bottomtd1" colspan="9" align="right">
        <input type="submit" onClick="javascript:loca('dmop_export.php?sql=<?php echo urlencode($sql);?>')" name="export" value="导出机器列表" />
      
      <? echo $page_num.'块/页 共<font color=red>'.$num.'</font>台 '.$pg->output(1);?></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
function loca(a){
	loca_action = document.getElementById('form2')
	loca_action.action = a;
//	window.location.reload();
}
</script>
</body>
</html>
