<?php
require_once("config/inc.php");
extract($_GET);
extract($_POST);
$currdate = date("Y-m-d H:i:s");
$name = '故障机器列表'.$currdate;
header("Content-type:application/vnd-ms.excel");
header("Content-Disposition attachment;filename=$names.xls");
header("Pragma: no-cache");
header("Expires: 0");


  echo "<table width=890 align=center>";
    echo "<tr>";
      echo "<th >id</th>";
      echo "<th>机器名</th>";
      echo "<th>故障硬盘</th>";
      echo "<th>IDC</th>";
      echo "<th>状态</th>";
      echo "<th>所属部门</th>";
      echo "<th>报修人</th>";
      echo "<th>报修时间详细</th>";
    echo "</tr>

	$sql = "select * from dmop_error_disk where machine_name like '%db%' and status = '报修'";
	$query = mysql_query($sql) or die(mysql_error());
    while($result = mysql_fetch_array($query))
    {

    echo "<tr>";
      echo "<td height=20 align=center >$result["id"]</td>";
      echo "<td align=center>$result["machine_name"]</td>";
      echo "<td align=center>$result["error_disk"]</td>";
      echo "<td align=center>$result["idc"]</td>";
      echo "<td align=center>$result["status"]</td>";
      echo "<td align=center>$result["department"]</td>";
      echo "<td align=center>$result["reporter"]</td>";
      echo "<td align=center>$result["report_date"]</td>";
    echo "</tr>";

}


echo "</table>";

?>