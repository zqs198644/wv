<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="js/Main.js"></script>
<script language="javascript" type="text/javascript" src="js/WebCalendar.js"></script>
<title>发布套餐转让信息</title>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
table {border-collapse: collapse;border-spacing: 0;}
#form {font-size:12px;}
#form td, #form th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form input{vertical-align:middle;}
#form th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form .red{color:#F00;}
#form .bgblue{background:#0CF;}
#form .bold{font-weight:bold;}
#form select{width:auto;}
#form #error_type{width:auto;}
#form td input{height:18px; line-height:18px;width:auto;border:1px solid #ddd;}
#form .subtime{height:30px;padding:5px 0;}
#form .subtime input{width:80px;margin:0 20px;height:24px;line-height:24px;}
#form .noborder input, #form .noborder input{ border:none;}
.errorP{ text-align:center;padding:5px 0;font-weight:bold;color:#454545;}
#form .firstLine input, #form1 .firstLine input{width:30px; border:none;}
#form .bottomtd input, #form1 .bottomtd input{width:90px;padding:0;height:24px;line-height:24px;}
-->
</style>
</head>
<body>
<hr>
<?php
include("config/inc.php");
require_once("config/auth.php");
extract($_GET);
extract($_POST);
$currdate=date("Y-m-d H:i:s");
$datetime=date("Y-m-d");

$query = mysql_query("select * from members where userid = '".$_SESSION[userid]."'") or die(mysql_error());
$result=mysql_fetch_array($query);
$username = $result[username];
$mobile   = $result[mobile];
$wechat   = $result[wechat];

if ($username =="" || $mobile == "" || $wechat == "" ){
	  echo "<script>alert('请先完善个人信息，姓名、手机、微信，以方便其它会员联系您！才有权限发布信息！');location.href='infop_userinfo.php';</script>";
}

switch($action) 
{
	case "update":

			$query=mysql_query("insert into packageneed values('','".$startdate."','".$enddate."','".$country."','".$destinations."','".$num."','".$day."','".$night."','".$userid."','".$username."','".$mobile."','".$wechat."','".$datetime."')") or die(mysql_error());
			if($query){
				   echo "<script>alert('套餐需求发布成功！');location.href='infop_packagemain.php?action=packageneed';</script>";
				}else{
				   echo "<script>alert('套餐需求发布失败！');location.href='infop_packagemain.php';</script>";
				}
	        break;
	}//end case
?>
<script language="javascript">
function checkdata()
{
if (document.form1.country.value=="") {
alert ("请填写套餐所在国家 ！")
return false
}
if (document.form1.destinations.value=="") {
alert ("请填写套餐旅游地点 ！")
return false
}
return true
}
 
</script>

<form  name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=update" onsubmit="return checkdata()">
  <table id="form" width="579" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col">发布套餐需求信息</th>
    </tr>
    <tr>
      <td width="117" align="center">旅游日期：</td>
      <td width="446"><input name="startdate" id="startdate"  onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)" value="<?php echo $datetime?>" />
        至
      <input name="enddate" type="text" class="firstLine" id="enddate" onchange="time_check()" onclick="SelectDate(this,'yyyy-MM-dd',0,0)"  value="<?php echo $datetime?>" /></td>
    </tr>
    <tr>
      <td width="117" align="center">所属国家 ：<br /></td>
      <td><input name="country" type="text" id="country" />
      <span class="STYLE1">*</span></td>
    </tr>
    <tr>
      <td align="center">旅游地点 ：</td>
      <td><span class="STYLE1"> 
        <input name="destinations" type="text" id="destinations"/>
      *</span></td>
    </tr>
    <tr>
      <td align="center">套餐人数：</td>
      <td><select name="num" class="bold" id="select">
        <option value="1">1</option>
        <option value="2" selected="selected">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
      </select>
        <span class="STYLE1">人*</span></td>
    </tr>
    <tr>
      <td align="center">几天几夜 ：</td>
      <td><label>
      <select name="day" class="bold" id="day">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4" selected="selected">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
                  </select>
      天
      <select name="night" class="bold" id="night">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3" selected="selected">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
                                    </select>
      夜</label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="发布" />
      <input name="userid" type="hidden" value="<?php echo $_SESSION['userid'] ?>" />
	  <input name="username" type="hidden" value="<?php echo $username ?>" />
	  <input name="mobile" type="hidden" value="<?php echo $mobile ?>" />
	  <input name="wechat" type="hidden" value="<?php echo $wechat ?>" />	  </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>

<script type="text/javascript">
function loca(a){
	loca_action = document.getElementById('form1')
	loca_action.action = a;
//	window.location.reload();
}
</script>
</body>
</html>
