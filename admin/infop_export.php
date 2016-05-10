<?php
require_once("config/inc.php");
header("Content-type:text/html;charset=utf-8");
extract($_GET);
extract($_POST);
$currdate = date("Y-m-d H:i:s");
$name = "infop_mola_".$currdate;
header("Content-type:application/vnd-ms-execl");
header("Content-Disposition:filename=$name.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

  <table width="890" border="1" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <th>日期</th>
      <th>集群名</th>
      <th>总存储空间</th>
      <th>已存储空间</th>
      <th>剩余空间</th>
      <th>可用空间</th>
      <th>变化率</th>
    </tr>
<?php
	$query = mysql_query($sql) or die(mysql_error());
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td align="center" class="firstLine"><?php echo $result["datetime"] ?> </td>
      <td align="center"><?php echo $result["cluster"]?></td>
      <td align="center"><?php echo $result["total"]?></td>
      <td align="center"><?php echo $result["used"]?></td>
      <td align="center"><?php echo $result["free"]?></td>
      <td align="center"><?php echo $result["avail"]?></td>
      <td align="center"><?php echo $result["avail"]?></td>
    </tr>
<?php
}

?>
</table>

