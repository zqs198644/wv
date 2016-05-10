<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include("config/inc.php");
require_once("config/auth.php");
require_once("config/turn_page.php");
?>
<title>用户管理</title>
<style type="text/css">
<!--
*{margin:0;padding:0;}
.STYLE1 {color: #FF0000}
.STYLE4 {font-size: 12px}
table{margin-top:20px;}
table {border-collapse: collapse;border-spacing: 0;margin:0 auto;}
#form2, form, form3 {margin:10px 10px 10px 9px;font-size:12px;color:#454545;}
#form1 input, #form2 input{vertical-align:middle;}
#form2 td, #form1 td, #form1 th,#form2 th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form2 th, #form1 th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form2  .red, form  .red, form3 .red{color:#F00;}
#form2  .bgblue, form  .bgblue, form3 .bgblue{background:#0CF;}
#form2  .bold, form  .bold, form3 .bold{font-weight:bold;}
#form2  select, form  select, form3 select{width:103px;height:18px; line-height:18px;}
#form2  td input, form  td input, form3 td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form2  .bottomtd, #form  .bottomtd, #form3 .bottomtd{height:24px;padding:5px 0;}
#form2 .bottomtd input, #form .bottomtd input, #form3 .bottomtd input{width:80px;height:24px;line-height:24px;}
#form1 .fline input, #form2 .fline input{width:20px;}
-->
</style>
</head>
<body>
<hr>

<?php
extract($_GET);
extract($_POST);
$username=trim($username);
$password=trim($password);
$query = mysql_query("select * from dmop_members where id = '".$id."'") or die(mysql_error());
$result = mysql_fetch_array($query);

switch($action) 
{
	case "edit":
			$sql = "update dmop_members set chinese_name = '".$chinese_name."',username = '".$username."', email = '".$email."', hiname = '".$hiname."', level = '".$level."', department = '".$department."', comment = '".$comment."' where id = '".$id."'";
			$query = mysql_query($sql) or die(mysql_error());
			if($query){
				echo "<script>alert('用户编缉成功！');location.href='dmop_usermain.php';</script>";
			}else{
				echo "<script>alert('用户编缉失败！');location.href='$_SERVER[PHP_SELF]';</script>";
			}
	        break;
}
?>
<script language="javascript">
function checkdata()
{
if (document.form2.chinese_name.value=="") {
alert ("请填写中文名 ！")
return false
}
if (document.form2.username.value=="") {
alert ("请填写登陆名 ！")
return false
}
if (document.form2.password.value=="") {
alert ("请填写密码 ！")
return false
}
if (document.form2.email.value=="") {
alert ("请填写邮件地址 ！")
return false
}
if (document.form2.hiname.value=="") {
alert ("请填写HI账号 ！")
return false
}
if (document.form2.comment.value=="") {
alert ("请填写描述信息 ！")
return false
}
return true
}
</script>

<form id="form2" name="form2" method="post" onsubmit="return checkdata()" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=edit" >
  <table width="454" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">编缉用户</th>
    </tr>
    <tr>
      <td width="80">中文名：</td>
      <td width="392"><label>
        <input name="chinese_name" type="text" id="chinese_name" value="<?php echo $result[chinese_name]?>" size="20" />
        <span class="STYLE1">        *        </span></label></td>
    </tr>
    <tr>
      <td width="80">登陆名：</td>
      <td><input name="username" type="text" id="username" value="<?php echo $result[username]?>" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>密码：</td>
      <td><input name="password" type="password" id="password" value="<?php echo $result[password]?>" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>EMAIL：</td>
      <td><input name="email" type="text" id="email" value="<?php echo $result[email]?>" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>hi账号：</td>
      <td><input name="hiname" type="text" id="hiname" value="<?php echo $result[hiname]?>" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>管理员：</td>
      <td  class="fline"><label>
        <input name="level" type="radio" value="1" <?php if($result[level] == '1') {echo "checked=checked";} ?>/>
        否
        <input type="radio" name="level" value="0" <?php if($result[level] == '0') {echo "checked=checked";} ?>/>
        是 </label></td>
    </tr>
    <tr>
      <td>所属部门:</td>
      <td><select name="department">
        <option value="DMOP" selected="selected">DMOP</option>
        </select>      </td>
    </tr>
    <tr>
      <td>描述：</td>
      <td>
        <textarea name="comment" cols="30" rows="6" id="comment"><?php echo $result[comment]?></textarea>
        <span class="STYLE4">(<span class="STYLE1">* </span>星号为必填项)
        <input name="id" type="hidden" id="id" value="<?php echo $id?>" />
        </span></td>
    </tr>
    <tr>
      <td>注册时间：:</td>
      <td><?php echo $result[datetime]?></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="bottomtd"><input type="submit" name="submit" value="提交" />
        <input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
</body>
</html>
