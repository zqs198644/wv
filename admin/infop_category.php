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
<title>品类添加</title>
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
#form select{width:70px;}
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
$sysdate=date("Y-m-d H:i:s");
switch($action) 
{
	case "insert":
				$sql = "insert into category values('','".$category."' ,'".$price."','".$cost."','','".$groupid."','".$comment."')";
				$query = mysql_query($sql) or die(mysql_error());
				if($query){
					echo "<script>alert('品类信息添加成功！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					mysql_close();
				}
	        break;
}
?>
<script language="javascript">
function checkdata()
{
if (document.form1.category.value=="") {
alert ("请添写品类名称 ！")
return false
}
if (document.form1.price.value=="") {
alert ("请添写销售单价 ！")
return false
}
if (document.form1.cost.value=="") {
alert ("请添写品类成本 ！")
return false
}
return true
}
</script>

<form id="form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=insert" onsubmit="return checkdata()">
  <table width="555" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">品类添加</th>
    </tr>
    <tr>
      <td align="center">品类类型：</td>
      <td><span class="STYLE1">
        <select name="groupid" id="category">
          <option value="0" selected="selected">海鲜</option>
		  <option value="1" >蔬菜</option>
		  <option value="2" >烧烤</option>
		  <option value="3" >原料</option>
        </select>
      </span></td>
    </tr>
    <tr>
      <td width="88"  align="center">品类名称：</td>
      <td ><label><span class="STYLE1">
        <input name="category" type="text" id="pounds3" />
        *
        <input type="hidden" name="typeid"  value="<?php echo $result[id]?>"/>
      </span></label></td>
    </tr>
    <tr>
      <td align="center">售货单价 ：</td>
      <td><input name="price" type="text" id="price" value="0" />
      斤/元<span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">品类成本 ：</td>
      <td><input name="cost" type="text" id="pounds2" value="0" />
      斤/元<span class="STYLE1"> *</span></td>
    </tr>
    <tr>
      <td align="center">品类说明：</td>
      <td><label>
        <textarea name="comment" cols="40" rows="4" id="comment"></textarea>
        <span class="STYLE1">*</span>号为必填项</label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="提交" /><input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
