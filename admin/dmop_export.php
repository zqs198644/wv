<?php
require_once("config/inc.php");
header("Content-type:text/html;charset=utf-8");
extract($_GET);
extract($_POST);
$currdate = date("Y-m-d H:i:s");
$name = "Server_List-".$currdate;
header("Content-type:application/vnd-ms-execl");
header("Content-Disposition:filename=$name.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

  <table width="890" border="1" align="center" cellpadding="1" cellspacing="1">
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
	$query = mysql_query($sql) or die(mysql_error());
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td height="20"  align="center" class="firstLine"><?php echo $result["id"] ?> </td>
      <td align="center"><?php echo $result["machine_name"]?></td>
      <td align="center"><?php echo $result["error_disk"]?></td>
      <td align="center"><?php echo $result["idc"]?></td>
      <td align="center"><?php echo $result["status"]?></td>
      <td align="center"><?php echo $result["department"]?></td>
      <td align="center"><?php echo $result["reporter"]?></td>
      <td align="center"><?php echo $result["report_date"]?></td>
    </tr>
<?php
}

?>
</table>

