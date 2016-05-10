<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include("config/inc.php");
require_once("config/auth.php");
require_once("config/turn_page.php");
?>
<title>机器节点监控项编缉</title>
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
#form select{width:103px;}
#form #error_type{width:auto;}
#form td input{height:18px; line-height:18px;width:250px;border:1px solid #ddd;}
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
extract($_GET);
extract($_POST);
$currdate=date("Y-m-d H:i:s");

switch($action) 
{
	case "monitem":
	     //保证至少有一个监控项
		 if (!empty($checkbox)){
			 $monitem = implode(',',$checkbox);
		 }else{
			 echo "<script>alert('至少添加一个监控项！');location.href='$_SERVER[PHP_SELF]?nodename=$nodename'</script>"; 
			 exit();
		 }
		 //对节点下所有的监控项进行更新
		 if ( $recurs == 'yes' ){
			 $sql = "update infop_machine set type = '".$monitem."' where nodename= '".$nodename."'";	 
			 mysql_query($sql) or die (mysql_error());
		 }
		 //只对节点的监控项进行更新
			 $sql = "update infop_nodename set type = '".$monitem."' where nodename= '".$nodename."'";	 
			 mysql_query($sql) or die (mysql_error());
			 echo "<script>alert('监控项修改成功');location.href='infop_nodemain.php';</script>"; 
	     break; 
			
}//end case
?>
<script language="javascript">
function checkdata()
{
  <!--全选-->
function select_all()
{ 
  for(var i=0;i<document.form.elements.length;i++)
  {
     if(document.form.elements[i].name=="checkbox[]")
     {
        if(document.form.elements[i].checked==false)
             document.form.elements[i].checked=true;
        else document.form.elements[i].checked=false;
     }
  }
}
</script>

<form id="form" name="form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=monitem&nodename=<? echo $nodename?>" onsubmit="return checkdata()">
  <table width="640" height="188" border="1" align="center">
    <tr>
      <th colspan="2" scope="col"><span class="errorP">机器节点监控项编缉</span></th>
    </tr>
    <tr>
      <td width="125" align="center">节点名字 ：</td>
      <td width="499"><label>
        <input name="nodename" type="text" id="nodename" value="<?php echo $nodename?>"/>
      </label></td>
    </tr>
    <tr>
      <td align="center">是否递归：</td>
      <td><label>
        <input name="recurs" type="radio" value="yes" />
        是
        <input name="recurs" type="radio" value="no" checked="checked" />
        否 </label></td>
    </tr>
    <tr>
      <td  class="noborder" align="center">监控项：</td>
      <td  align="left" class="firstLine">
<?php
	$sql = "select * from infop_nodename where nodename='".$nodename."'";
	$query = mysql_query($sql) or die(mysql_error());
	while($result = mysql_fetch_array($query)){ 
	$items = explode(',',$result[items]);
	$type = explode(',',$result[type]);
	for($i=0;$i<count($items);$i++)
	{
?>
          <input type='checkbox' name='checkbox[]' value='<?=$items[$i]?>' 
<?php
		for($j=0;$j<count($type);$j++)
		{
			if( $type[$j] == $items[$i]) echo 'checked';
		}  	
?>
		  
		   />
<?php
		   echo $items[$i];
	}
}    
?>     <input type="checkbox" name="checkbox" value="checkbox" onclick="select_all()" />全选
	</td>
    </tr>
    <tr>
      <td align="center">说明：</td>
      <td><label>如果选择递归，则此节点下所有机器的监控项更改为所选 监控项</label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" class="subtime"><input type="submit" name="submit" value="提交" /><input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
function loca(a){
	loca_action = document.getElementById('form')
	loca_action.action = a;
//	window.location.reload();
}
</script>

</body>
</html>
