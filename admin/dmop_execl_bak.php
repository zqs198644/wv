<?php
require_once("config/inc.php");
extract($_GET);
extract($_POST);
$currdate = date("Y-m-d H:i:s");
$name = '故障机器列表'.$currdate;
header("Content-type:application/vnd-ms.excel");
header("Content-Disposition attachment;filename=$names.xls");
//header("Content-type:application/ms-execl");
//header("Content-Disposition:filename=$names.xls");
header("Pragma: no-cache");
header("Expires: 0");
ob_start();
?>

  <table width="890" align="center">
    <tr>
      <th class="check firstLine">id</th>
      <th>机器名</th>
      <th>故障硬盘</th>
      <th>IDC</th>
      <th>状态</th>
      <th>所属部门</th>
      <th>报修人</th>
      <th>报修时间详细</th>
    </tr>
<?php
	$sql = "select * from dmop_error_disk where machine_name like '%db%' and status = '报修'";
	$query = mysql_query($sql) or die(mysql_error());
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td height="20"  align="center" class="firstLine"><?php echo $result["id"] ?> </td>
      <td align="center"><?php echo $result["machine_name"]?><</td>
      <td align="center"><?php echo $result["error_disk"]?></td>
      <td align="center"><?php echo $result["idc"]?></td>
      <td align="center"><?php echo $result["status"]?></td>
      <td align="center"><?php echo $result["department"]?></td>
      <td align="center"><?php echo $result["reporter"]?></td>
      <td align="center"><?php echo $result["report_date"]?></td>
    </tr>
<?php
}
ob_get_contents();
ob_end_flush();
?>
</table>

