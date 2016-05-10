<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require_once("config/inc.php");
require_once("config/turn_page.php");
require_once("config/auth.php");
?>
<title></title>
<style>
*{margin:0;padding:0;}
table {border-collapse: collapse;border-spacing: 0;}
#form2 {font-size:12px;}
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
#form2 .firstLine input{width:15px; border:none;}

</style>
</head>
<body>

<hr />
<p class="errorP">Mola应用核心数据表</p>

<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=batchdel">

  <table width="1216" align="center">
    <tr>
      <th width="82" >集群类别</th>
      <th width="89">产品线名称</th>
      <th width="66">服务名称</th>
      <th width="76">子表个数</th>
      <th width="67">引擎类型</th>
      <th width="78">Group数目</th>
      <th width="98">单个Group容量</th>
      <th width="101">Group最大容量</th>
      <th width="86"><span class="noborder">Group使用%</span></th>
      <th width="58"><span class="noborder">表容量</span></th>
      <th width="91">子表item数目</th>
      <th width="87">item最大条目</th>
      <th width="82">item使用%</th>
      <th width="95">最大数据长度</th>
    </tr>
<?php
	$pg = & new turn_page();
	$sql = "select * from  infop_mola_application order by id desc" ;
    $query=mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '25';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sqllimit = $sql ." limit ".$limit;
	$query = mysql_query($sqllimit) or die(mysql_error());
	$error_num = mysql_num_rows($query);
	if( $error_num == '0' ){
?>
    <tr>
      <td colspan="14"  align="center" class="firstLine">目前没有空闲机器
        <input name="error_num" type="hidden" id="error_num" value="<?php echo  $error_num?>" /></td>
    </tr>
<?php	
	}
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td  align="center" class="firstLine"><?php echo $result["cluster"]?></td>
      <td align="center"><?php echo $result["product"]?></td>
      <td align="center"><?php echo $result["servername"]?></td>
      <td align="center"><?php echo $result["ctablenum"]?></td>
      <td align="center"><?php echo $result["engine"]?></td>
      <td align="center"><?php echo $result["groupnum"]?></td>
      <td align="center"><?php echo $result["sgroupcapacity"]?></td>
      <td align="center"><?php echo $result["mgroupcapacity"]?></td>
      <td align="center"><?php echo $result["grouprate"]?></td>
      <td align="center"><?php echo $result["sgroupcapacity"]?></td>
      <td align="center"><?php echo $result["citemnum"]?></td>
      <td align="center"><?php echo $result["mitemnum"]?></td>
      <td align="center" ><?php echo $result["itemrate"]?></td>
      <td align="center" ><?php echo $result["mitemlength"]?></td>
    </tr>
<?php
}
?>
    <tr>
      <td class="bottomtd" align="center" valign="middle">&nbsp;</td>
      <td class="bottomtd1" colspan="13" align="right">
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
