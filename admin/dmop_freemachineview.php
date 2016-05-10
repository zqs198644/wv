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

<p class="errorP"><strong>空闲机器历史详情</strong></p>

<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=deluser">
  <table width="942" align="center">
    <tr>
      <th width="52" >id</th>
      <th width="156">机器名字</th>
      <th width="63">IDC</th>
      <th width="78">机器厂商</th>
      <th width="79">机器内存</th>
      <th width="72">机器磁盘</th>
      <th width="72">机器状态</th>
      <th width="44">机型</th>
      <th width="61">联系人</th>
      <th width="67">借用时间</th>
      <th width="78">归还时间</th>
      <th width="68">上线时间</th>
    </tr>
    <?php
	$pg = & new turn_page();
	$sql = "select * from  dmop_freemachine  where pid ='".$id."' order by idc,status,borrow_time desc" ;
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
      <td colspan="12"  align="center" class="firstLine">目前没有机器状态的历史记录
        <input name="error_num" type="hidden" id="error_num" value="<?php echo  $error_num?>" /></td>
    </tr>
<?php	
	}
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td  align="center" ><?php echo $result["id"]?></td>
      <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["machine_name"]?></a><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"></a></td>
      <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["idc"]?></a><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"></a><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"></a></td>
      <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["factory"]?></a><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"></a></td>
      <td align="center"><?php echo $result["mem"]?></td>
      <td align="center"><?php echo $result["disk"]?></td>
      <td align="center"><?php echo $result["status"]?></td>
      <td align="center"><?php echo $result["machine_type"]?></td>
      <td align="center"><a href="baidu://message/?sid=&amp;id=<?php echo $result["hiname"]?>"><?php echo $result["contact"]?></a></td>
      <td align="center"><?php echo $result["borrow_time"]?></td>
      <td align="center"><?php echo $result["return_time"]?></td>
      <td align="center"><?php echo $result["online_time"]?></td>
    </tr>
    <?php
}
?>
    <tr>
      <td height="25" align="center" valign="middle"></td>
      <td class="bottomtd1" colspan="11" align="right"><? echo $page_num.'块/次 共<font color=red>'.$num.'</font>次 '.$pg->output(1);?></td>
    </tr>
  </table>
</form>


</body>
</html>
