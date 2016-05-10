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
	
	case "deluser":
			if(empty($_POST[checkbox])){
				echo "<script>alert('请选择要删除的会员！');</script>";
			}else{
				$delete_id=implode(",",$_POST['checkbox']);
				$sql = "delete from members where id in ($delete_id)"; 
				$query = mysql_query($sql) or die(mysql_error());
				if($query){
				   echo "<script>alert('删除会员成功！');</script>";
				}
			}
			break;
}
?>

<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=deluser">
  <table width="820" height="54" border="1" align="center">
    <tr>
      <th width="51" height="10" class="fline" scope="col">&nbsp;</th>
      <th  scope="col">会员ID</th>
      <th scope="col">真实姓名</th>
      <th scope="col">手机</th>
      <th scope="col">微信</th>
      <th width="150" scope="col">注册日期</th>
      <th width="73" scope="col">在线</th>
    </tr>
    <?php
	$pg = & new turn_page();
    $query=mysql_query("select * from members  order by regdate,status desc");
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '15';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
	$query=mysql_query("select * from members order by isadmin,regdate  limit ".$limit."");
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td height="4" align="center" class="fline" scope="col"><label>
        <input type="checkbox" name="checkbox[]" value="<?php echo $result["id"]?>">
      </label></td>
      <td width="120" align="center" scope="col"><?php echo $result["userid"]?></td>
      <td width="162" align="center" scope="col"><?php echo $result["username"]?></td>
      <td width="112" align="center" scope="col"><?php echo $result["mobile"]?></td>
      <td width="106" align="center" scope="col"><?php echo $result["wechat"]?></td>
      <td align="center" scope="col"><?php echo $result["regdate"]?></td>
      <td align="center" scope="col"><?php if( $result['status'] == '1' ){ echo "<font color='red'>在线";}else{ echo '离线';}?></td>
    </tr>
<?php
}
?>
    <tr>
      <td height="5" colspan="8" align="center" scope="col" class="bottomtd"><input type="submit" name="Submit3"  onClick="javascript:return window.confirm('确定要删除此信息吗？')" value="删除用户" /> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $page_num.'人/页  共有<font color=red> '.$num.'</font> 个用户 '.$pg->output(1);?></td>
    </tr>
  </table>
</form>


</body>
</html>
