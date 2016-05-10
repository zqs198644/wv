<?php
require_once("config/inc.php");
header("Content-type:text/html;charset=utf-8");
extract($_GET);
extract($_POST);
$currdate = date("Y-m-d H:i:s");
$name = "进货说细".$currdate;
$name=iconv('UTF-8','GB2312', $name); 
header("Content-type:application/vnd-ms-execl");
header("Content-Disposition:filename=$name.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

  <table width="890" border="1" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <th>日期</th>
      <th>品类</th>
      <th>只数</th>
      <th>箱数</th>
      <th>斤数</th>
      <th>总额</th>
      <th>说明</th>
    </tr>
<?php
	$query = mysql_query($sql) or die(mysql_error());
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td align="center" class="firstLine"><?php echo $result["datetime"] ?> </td>
      <td align="center"><?php echo $result["category"]?></td>
      <td align="center"><?php echo $result["number"]?></td>
      <td align="center"><?php echo $result["pounds"]?></td>
      <td align="center"><?php echo $result["box"]?></td>
      <td align="center"><?php echo $result["money"]?> 元</td>
      <td align="center"><?php echo $result["comment"]?></td>
    </tr>
<?php
}

?>
</table>

