<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
include("config/inc.php");
require_once("config/auth.php");
require_once("config/turn_page.php");
require_once("config/function.php");
$currdate = date("Y-m-d H:i:s");

extract($_GET);
extract($_POST);
$username=trim($username);
$password=trim($password);
switch($action) 
{
	case "adduser":
			if("$pssword_one" != "$password_two")
			{
				echo "<script>alert('两次输入的密码不一致！');location.href='$_SERVER[PHP_SELF]';</script>";
				exit ;
			}
			$sql = "select username from dmop_members where username = '".$username."'";
			$query = mysql_query($sql) or die(mysql_error());
			$num = mysql_num_rows($query);
			if( $num == 0){
				$sql = "insert into dmop_members values('','$chinese_name','$username','".md5($password)."','$email','$hiname','$level','$department','$comment','$currdate')";
				$query = mysql_query($sql) or die(mysql_error());
				if($query){
					
					echo "<script>alert('用户添加成功！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					
					// 发送用户邮件用户名及密码
					$title = "DMOP故障机系统用户名与初始密码,请及时修改";
					$message = $chinese_name."您好：\n\n   您现在的登陆名为：".$username.", 密码为： ".$password.", 请修改或保管好，\n\n修改密码请登陆http://errormachine.dmop.baidu.com:8080 ,谢谢！";
					sendmail($email,$title,$message);
					
				}
			}else{
				echo "<script>alert('用户已存在！');location.href='$_SERVER[PHP_SELF]';</script>";
			}
	        break;

	case "deluser":
			if(empty($_POST[checkbox])){
				echo "<script>alert('请选择要删除的用户！');</script>";
			}else{
				$delete_id=implode(",",$_POST['checkbox']);
				$sql = "delete from dmop_members where id in ($delete_id)"; 
				$query = mysql_query($sql) or die(mysql_error());
				if($query){
				   echo "<script>alert('删除用户成功！');</script>";
				}
			}
			break;
}
?>

<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=deluser">
  <table width="820" height="54" border="1" align="center">
    <tr>
      <th width="44" height="10" class="fline" scope="col">&nbsp;</th>
      <th width="34" scope="col">id</th>
      <th  scope="col">中文名</th>
      <th scope="col">登陆名</th>
      <th scope="col">邮箱</th>
      <th scope="col">HI账号</th>
      <th width="56" scope="col">所属组</th>
      <th width="77" scope="col">权限</th>
      <th width="38" scope="col">编缉</th>
    </tr>
    <?php
	$pg = & new turn_page();
    $query=mysql_query("select * from dmop_members order by level");
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '8';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
	$query=mysql_query("select * from dmop_members order by level limit ".$limit."");
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td height="4" align="center" scope="col" class="fline"><label>
        <input type="checkbox" name="checkbox[]" value="<?php echo $result["id"]?>">
      </label></td>
      <td height="4" align="center" scope="col"><?php echo $result["id"] ?> </td>
      <td width="115" align="center" scope="col"><?php echo $result["chinese_name"]?></td>
      <td width="141" align="center" scope="col"><?php echo $result["username"]?></td>
      <td width="141" align="center" scope="col"><a href="mailto:<?php echo $result["email"]?>"><?php echo $result["email"]?></a></td>
      <td width="116" align="center" scope="col"><a href="baidu://message/?sid=&id=<?php echo $result["hiname"]?>"><?php echo $result["hiname"]?></a></td>
      <td align="center" scope="col"><?php echo $result["department"]?></td>
      <td align="center" scope="col"><?php if( $result['level'] == '0' ){ echo "<font color='red'>管理员";}else{ echo '普通用户';}?></td>
      <td align="center" scope="col"><a href="dmop_useredit.php?id=<?php echo $result["id"]?>">编缉</a></td>
    </tr>
<?php
}
?>
    <tr>
      <td height="5" colspan="9" align="center" scope="col" class="bottomtd"><input type="submit" name="Submit3"  onClick="javascript:return window.confirm('确定要删除此信息吗？')" value="删除用户" /> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $page_num.'人/页  共有<font color=red> '.$num.'</font> 个用户 '.$pg->output(1);?></td>
    </tr>
  </table>
</form>
<p>
<div style="border-bottom:1px dotted #666;height:10px;"></div>
<p>
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

<form id="form2" name="form2" method="post" onsubmit="return checkdata()" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=adduser" >
  <table width="454" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">添加用户</th>
    </tr>
    <tr>
      <td width="80">中文名：</td>
      <td width="392"><label>
        <input name="chinese_name" type="text" id="chinese_name" size="20" />
        <span class="STYLE1">        *        </span></label></td>
    </tr>
    <tr>
      <td width="80">登陆名：</td>
      <td><input name="username" type="text" id="username" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>密码：</td>
      <td><input name="password" type="password" id="password" value="<?php echo rand(100000,mktime());?>" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>EMAIL:</td>
      <td><input name="email" type="text" id="email" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>hi账号：</td>
      <td><input name="hiname" type="text" id="hiname" size="20" />
      <span class="STYLE1">* </span></td>
    </tr>
    <tr>
      <td>管理员：</td>
      <td  class="fline"><label>
        <input name="level" type="radio" value="1" checked="checked" />
        否
        <input type="radio" name="level" value="0" />
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
      <td><label>
        <textarea name="comment " cols="30" rows="6" id="comment "></textarea>
        <span class="STYLE4">(<span class="STYLE1">* </span>星号为必填项)</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="bottomtd"><input type="submit" name="submit" value="提交" />
          <input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
</body>
</html>
