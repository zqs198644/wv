<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require_once("config/inc.php");
require_once("config/turn_page.php");
require_once("config/auth.php");
?>
<title>DMOP故障管理</title>
<style>
*{margin:0;padding:0;}
#form2 {margin:10px 10px 10px 9px;font-size:12px;}
#form2 td, #form2 th{line-height:18px; border:1px solid #CCC;padding:2px 5px;}
#form2 th{background:#F4F5EB;color:#454545;font-weight:bold;}
table {border-collapse: collapse;border-spacing: 0;}
#form2 .red{color:#F00;}
#form2 .bgblue{background:#0CF;}
#form2 .bold{font-weight:bold;}
#form2 select{width:103px;height:18px; line-height:18px;}
#form2 td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form2 .bottomtd input{width:60px;height:24px;line-height:24px;}
#form2 .check{width:60px;}
.errorP{ text-align:center;padding:5px 0;font-weight:bold;color:#454545;}
#form2 .fristLine input{width:15px;}
</style>
</head>
<body>
<?php
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
				$sql = "insert into dmop_members values('','$chinese_name','$username','".md5($password)."','$email','$hiname','$level','$department','$comment')";
				$query = mysql_query($sql) or die(mysql_error());
				if($query){
				echo "<script>alert('用户添加成功！');location.href='$_SERVER[PHP_SELF]';</script>"; }
				mysql_close();
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

	case "change":
			if( $passwd_one == $passwd_two){
				 mysql_query("update dmop_members set password = '".md5($passwd_one)."' where username = '".$_SESSION[username]."'") or die(mysql_error());
				 echo "<script>alert('密码修改成功！');</script>";
			}else{
				 echo "<script>alert('两次输入密码不一致!!!!!!！');</script>";
			}
			break;
}
?>
<hr />
<p class="errorP">故障机器整机报修</p>
  <!--全选-->
<script language="javascript">
function select_all()
{ 
  for(var i=0;i<document.form2.elements.length;i++)
  {
     if(document.form2.elements[i].name=="checkbox[]")
     {
        if(document.form2.elements[i].checked==false)
             document.form2.elements[i].checked=true;
        else document.form2.elements[i].checked=false;
     }
  }
}

  </script>

<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=deluser">
  <table align="center" width="880">
    <tr>
      <th class="check fristLine"><input type="checkbox" name="checkbox" value="checkbox" onclick="select_all()" />全选</th>
      <th>id</th>
      <th>机器名</th>
      <th>故障硬盘</th>
      <th>IDC</th>
      <th>状态</th>
      <th>所属部门</th>
      <th>报修人</th>
      <th>报修时间</th>
      <th>块数</th>
      <th>详细</th>
    </tr>
    <?php
	$pg = & new turn_page();
    $sql = "select *,machine_name,count(*) as num from dmop_error_disk where status='报修' group by machine_name having count(machine_name) > 3 order by idc,report_date desc";
	$query = mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '10';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sql = $sql ." limit ".$limit;
	$query=mysql_query($sql) or die(mysql_error());
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td  align="center" class="fristLine"><label>
        <input type="checkbox" name="checkbox[]" value="<?php echo $result["id"]?>">
      </label></td>
      <td align="center"><?php echo $result["id"] ?> </td>
      <td align="center"><a href="dmop_errordiskrepair.php?machine=<?php echo $result["machine_name"]?>"><?php echo $result["machine_name"]?></a></td>
      <td align="center"><?php echo $result["error_disk"]?></td>
      <td align="center"><?php echo $result["idc"]?></td>
      <td align="center"><?php echo $result["status"]?></td>
      <td align="center"><?php echo $result["department"]?></td>
      <td align="center"><?php echo $result["reporter"]?></td>
      <td align="center"><?php echo $result["report_date"]?></td>
      <td align="center"><font color="red"><?php echo $result["num"]?></font></td>
      <td align="center"><a href="dmop_errordiskview.php?id=<?php echo $result["id"]?>">详细</a></td>
    </tr>
<?php
}
?>
    <tr>
      <td class="bottomtd" align="center" valign="middle"><input type="submit" name="Submit3"  onClick="javascript:return window.confirm('确定要报修此批机器吗？')" value="报修" /></td>
      <td class="bottomtd" colspan="10" align="right"><? echo $page_num.'台/页 共<font color=red>'.$num.'</font>台 '.$pg->output(1);?></td>
    </tr>
  </table>
</form>


</body>
</html>
