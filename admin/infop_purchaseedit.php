<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<?php 
include("config/inc.php");
require_once("config/auth.php");
$currdate = date("Y-m-d H:i:s");
?>
<title>进货录入</title>
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
#form select{width:90px;}
#form #error_type{width:auto;}
#form td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form .subtime{height:30px;padding:5px 0;}
#form .subtime input{width:80px;margin:0 20px;height:24px;line-height:24px;}
-->
</style>
</head>
<body>
<hr>
<?php
extract($_GET);
extract($_POST);

$query = mysql_query("select * from purchase where id='".$id."'") or die(mysql_error());
$result = mysql_fetch_array($query);
$currdate = date("Y-m-d H:i:s");

switch($action) 
{
	case "update":
		$sql = "update purchase set category='".$category."' ,number='".$number."',pounds='".$pounds."',box='".$box."',money='".$money."',reporter='".$reporter."',comment='".$comment."',datetime='".$datetime."',groupid='".$groupid."' where id='".$id."'";
		$query = mysql_query($sql) or die(mysql_error());
		if($query)
		{
				echo "<script>alert('品类信息修改成功！');history.go(-2);</script>"; 
		}else{
				echo "<script>alert('品类信息修改失败！');history.go(-2);</script>";
		}//end if
	        break;
}
?>

<script language="javascript">
function checkdata()
{
if (document.form1.pounds.value=="") {
alert ("请添写进货斤数 ！")
return false
}
if (document.form1.money.value=="") {
alert ("请添写进货金额 ！")
return false
}
return true
}
</script>

<form id="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=update&id=<?php echo $result[id]?>" onsubmit="return checkdata()">
  <table width="555" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">进货编缉</th>
    </tr>
    <tr>
      <td  align="center">进货品类：</td>
      <td ><label><span class="STYLE1">
      <select name="groupid" id="select">
          <option value="0" <?php if($result[groupid] == '0'){echo 'selected=selected';}?>>熟食</option>
          <option value="1" <?php if($result[groupid] == '1'){echo 'selected=selected';}?>>原料</option>
      </select>
      <select name="category" id="category">
        <?php 
	$query_category= mysql_query("select * from category order by id desc");
	while($result_category = mysql_fetch_array($query_category)){
?>
        <option value="<?php echo $result_category[category]?>" <?php if($result_category[category] == $result[category]){echo 'selected=selected';}?>><?php echo $result_category[category]?></option>
        <?php
}
?>
      </select>
*      </span></label></td>
    </tr>
    <tr>
      <td width="88" align="center"> 进货个数： <br /></td>
      <td><input name="number" type="text" id="number" value="<?php echo $result[number]?>" />
        只</td>
    </tr>
    <tr>
      <td align="center">进货斤数 ：</td>
      <td><input name="pounds" type="text" id="pounds" value="<?php echo $result[pounds]?>" />
      斤<span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">进货箱数 ：</td>
      <td><input name="box" type="text" id="pounds2" value="<?php echo $result[box]?>" />
        箱</td>
    </tr>
    <tr>
      <td align="center">进货金额 ：</td>
      <td><input name="money" type="text" id="money" value="<?php echo $result[money]?>" />
       元<span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">录入人名 ： </td>
      <td>
        <input name="reporter" type="text" id="reporter" value="<?php echo $_SESSION['username']?>" />       </td>
    </tr>
    <tr>
      <td align="center">进货说明：</td>
      <td><label>
        <textarea name="comment" cols="40" rows="4" id="comment"><?php echo $result[comment]?></textarea>
        <span class="STYLE1"> *</span>号为必填项</label></td>
    </tr>
    <tr>
      <td align="center">进货时间：</td>
      <td><input name="datetime" id="startTime"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)" value="<?php echo $result[datetime]?>" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="提交" /><input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
