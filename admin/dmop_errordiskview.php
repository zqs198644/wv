<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include("config/inc.php");
require_once("config/auth.php");
extract($_GET);
$query = mysql_query("select * from dmop_error_disk where id ='$id'") or die(mysql_error());
$result = mysql_fetch_array($query);
?>
<title>故障机器录入</title>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
#form {margin:10px 10px 10px 9px;font-size:12px;}
#form td, #form th{line-height:18px; border:1px solid #CCC;padding:2px 5px;}
#form th{background:#F4F5EB;color:#454545;font-weight:bold;}
table {border-collapse: collapse;border-spacing: 0;}
#form .red{color:#F00;}
#form .bgblue{background:#0CF;}
#form .bold{font-weight:bold;}
#form select{width:103px;height:18px; line-height:18px;}
#form td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form .subtime{height:30px;padding:5px 0;}
#form .subtime input{width:80px;margin:0 20px;height:24px;line-height:24px;}
-->
</style>
</head>
<body>
<hr>

<form id="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=adderrordisk" onsubmit="return checkdata()">
  <table width="553" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">故障信息详细</th>
    </tr>
    <tr>
      <td align="center" width="88">机器名 ：</td>
      <td width="366"><?php echo $result['machine_name']?></td>
    </tr>
    <tr>
      <td align="center"  width="88"> 故障硬盘 ： </td>
      <td><?php echo $result['error_disk']?></td>
    </tr>
    <tr>
      <td align="center" >故障类型 ：</td>
      <td><?php echo $result['error_type']?></td>
    </tr>
    <tr>
      <td align="center" >故障信息 ：</td>
      <td><textarea name="error_log" cols="30" rows="4" id="error_log"><?php echo $result['error_log']?></textarea></td>
    </tr>
    <tr>
      <td align="center" >状 态 ：</td>
      <td><?php echo $result['status']?></td>
    </tr>
    <tr>
      <td align="center" >所属集群 ：</td>
      <td><?php echo $result['reporter']?></td>
    </tr>
    <tr>
      <td align="center" >所属部门 ： </td>
      <td><?php echo $result['department']?></td>
    </tr>
    <tr>
      <td align="center" >所在机房 ： </td>
      <td><?php echo $result['department']?></td>
    </tr>
    <tr>
      <td align="center" >报修人 ： </td>
      <td><?php echo $result['idc']?></td>
    </tr>
    <tr>
      <td align="center" >描述：</td>
      <td><label>
        <textarea name="comment" cols="40" rows="4" id="comment "><?php echo $result['comment']?></textarea>
      </label></td>
    </tr>
    <tr>
      <td  align="center" >报修时间：</td>
      <td><?php echo $result['report_date']?></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
