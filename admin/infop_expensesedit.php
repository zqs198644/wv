<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<?php 
include("config/inc.php");
require_once("config/auth.php");
$currdate = date("Y-m-d");
?>
<title>编缉支出金额</title>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
table {border-collapse: collapse;border-spacing: 0;}
#form {margin:10px 10px 10px 9px;font-size:12px;}
#form td, #form th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form input{vertical-align:middle;}
#form th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form .red{color:#F00;}
#form .bgblue{background:#0CF;}
#form .bold{font-weight:bold;}
#form select{width:100px;}
#form #error_type{width:auto;}
#form td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form .subtime{height:30px;padding:5px 0;}
#form .subtime input{width:80px;margin:0 20px;height:24px;line-height:24px;}
.STYLE2 {color: #000000}
-->
</style>
</head>
<body>
<hr>
<?php
extract($_GET);
extract($_POST);

$query = mysql_query("select * from expenses where id='".$id."'") or die(mysql_error());
$result = mysql_fetch_array($query);

switch($action) 
{
	case "update":
		$sql = "update expenses set name='".$name."' ,price='".$price."',number='".$number."',type='".$type."',comment='".$comment."',datetime='".$dateTime."' where id='".$id."'";
		$query = mysql_query($sql) or die(mysql_error());
		if($query)
		{
				echo "<script>alert('编缉成功！');history.go(-2);</script>"; 
		}else{
				echo "<script>alert('编缉失败！');history.go(-2);</script>";
		}//end if
	        break;
}
?>
<script language="javascript">
function checkdata()
{
if (document.form1.name.value=="") {
alert ("请添写物品名称 ！")
return false
}
if (document.form1.price.value=="") {
alert ("请添写物品单价 ！")
return false
}
if (document.form1.number.value=="") {
alert ("请添写物品数量 ！")
return false
}
if (document.form1.comment.value=="") {
alert ("请添写支出说明 ！")
return false
}
return true
}
</script>

<form id="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=update&id=<?php echo $result[id]?>" onsubmit="return checkdata()">
  <table width="576" height="209" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">编缉支出金额</th>
    </tr>
    <tr>
      <td width="141"  align="center">物品名称：</td>
      <td width="419"><label>
        <input name="name" type="text" id="name" value="<?php echo $result[name]?>"/>
        <span class="STYLE1">*</span></label></td>
    </tr>
    <tr>
      <td  align="center">物品单价：</td>
      <td><label>
        <input name="price" type="text" id="price" value="<?php echo $result[price]?>"/>
        <span class="STYLE1"><span class="STYLE2">元 </span>*</span></label></td>
    </tr>
    <tr>
      <td  align="center">物品数量：</td>
      <td width="419"><input name="number" type="text" id="number" value="<?php echo $result[number]?>"/>
        件<span class="STYLE1">*</span></td>
    </tr>
    <tr>
      <td align="center">支出类型： </td>
      <td><label>
        <select name="type" id="type">
          <option value="物件支出" <?php if( $result[type] == '物件支出') {echo 'selected=selected';}?>>物件支出</option>
          <option value="事务支出"  <?php if( $result[type] == '事务支出') {echo 'selected=selected';}?>>事务支出</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="center">录入人名： </td>
      <td><?php echo $result[record]?></td>
    </tr>
    <tr>
      <td align="center">说明：</td>
      <td><label>
        <textarea name="comment" cols="40" rows="4" id="comment"><?php echo $result[comment]?></textarea>
        <span class="STYLE1"> *</span>号必填项</label></td>
    </tr>
    <tr>
      <td align="center">支出日期：</td>
      <td><input name="dateTime" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)" value="<?php echo $result[datetime]?>" />
      </td>
    </tr>
    <tr>
      <td height="42" colspan="2" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="提交" />
          <input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
