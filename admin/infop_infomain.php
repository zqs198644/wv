<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require_once("config/inc.php");
require_once("config/turn_page.php");
require_once("config/auth.php");
?>
<title>已发布信息管理</title>
<style>
*{margin:0;padding:0;}
table {border-collapse: collapse;border-spacing: 0;}
#form2 {font-size:12px;}
#form2  td, #form2, th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form2 input{vertical-align:middle;}
#form2 th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form2 th input{height:18px;}
#form2 .red{color:#F00;}
#form2 .bgblue{background:#0CF;}
#form2 .bold{font-weight:bold;}
#form2 select{width:103px;height:18px; line-height:18px;}
#form2 td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form2 .bottomtd input{width:60px;height:24px;line-height:24px;}
#form2 .bottomtd1 input{width:85px;height:24px;line-height:24px;}
#form2 .check{width:60px;}
.errorP{ text-align:center;padding:5px 0;font-weight:bold;color:#454545;}
#form2 .firstLine input{width:15px; border:none;}

#form1 {font-size:12px;}
#form1  td, #form1, th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form1 input{vertical-align:middle;}
#form1 th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form1 th input{height:18px;}
#form1 .red{color:#F00;}
#form1 .bgblue{background:#0CF;}
#form1 .bold{font-weight:bold;}
#form1 select{width:103px;height:18px; line-height:18px;}
#form1 td input{height:18px; line-height:18px;width:172px;border:1px solid #ddd;}
#form1 .bottomtd input{width:60px;height:24px;line-height:24px;}
#form1 .bottomtd1 input{width:85px;height:24px;line-height:24px;}
#form1 .check{width:60px;}
.errorP{ text-align:center;padding:5px 0;font-weight:bold;color:#454545;}
#form1 .firstLine input{width:15px; border:none;}
.STYLE13 {color: #454545; font-size: 12px;}
.STYLE1 {font-size: 12px}
.STYLE11 {font-size: 12px; color: #454545; font-weight: bold; }
</style>
</head>
<body>
<?php
extract($_GET);
extract($_POST);
if("$action" == 'transferdel'){

					if(empty($_POST[checkbox])){
						echo "<script>alert('请选择要删除的信息！');</script>";
					}else{
						$delete_id=implode(",",$_POST['checkbox']);
						$sql = "delete from package where id in ($delete_id)"; 
						$query = mysql_query($sql) or die(mysql_error());
						if($query){
						   echo "<script>alert('信息删除成功！');</script>";
						}
					}
}elseif("$action" == 'needdel'){
					if(empty($_POST[checkbox])){
						echo "<script>alert('请选择要删除的信息！');</script>";
					}else{
						$delete_id=implode(",",$_POST['checkbox']);
						$sql = "delete from packageneed where id in ($delete_id)"; 
						$query = mysql_query($sql) or die(mysql_error());
						if($query){
						   echo "<script>alert('信息删除成功！');</script>";
						}
					}
}
?>
<hr />
<p class="errorP">套餐转让信息</p>
  <!--全选-->
<script language="javascript">
function select_all_need()
{ 
  for(var i=0;i<document.form1.elements.length;i++)
  {
     if(document.form1.elements[i].name=="checkbox[]")
     {
        if(document.form1.elements[i].checked==false)
             document.form1.elements[i].checked=true;
        else document.form1.elements[i].checked=false;
     }
  }
}

function select_all_transfer()
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

<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=transferdel">

  <table width="902" align="center">
    <tr>
      <th width="72" class="check firstLine"><input type="checkbox" name="checkbox" value="checkbox" onclick="select_all_transfer()" />
      全选</th>
      <th width="132"><span class="STYLE13">套餐日期</span></th>
      <th width="41"><span class="STYLE1">国家</span></th>
      <th width="67"><span class="STYLE1">旅游地点</span></th>
      <th width="45"><span class="STYLE1">天数</span></th>
      <th width="66"><span class="STYLE1">会员价格</span></th>
      <th width="65"><span class="STYLE1">抵扣积分</span></th>
      <th width="51"><span class="STYLE1">改名费</span></th>
      <th width="57"><span class="STYLE11"><span class="STYLE1">联系人</span></span></th>
      <th width="50"><span class="STYLE1">手机</span></th>
      <th width="47"><span class="STYLE1">微信</span></th>
      <th width="66"><span class="STYLE1">发布时间</span></th>
      <th width="79">套餐链接</th>
    </tr>
<?php
	$pg = & new turn_page();
	$sql = "select * from package  where userid = '".$_SESSION['userid']."' order by id desc" ;
    $query=mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '15';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sqllimit = $sql ." limit ".$limit;
	$query = mysql_query($sqllimit) or die(mysql_error());
	$error_num = mysql_num_rows($query);
	if( $error_num == '0' ){
?>
    <tr>
      <td colspan="13"  align="center" class="firstLine">目前没有发布信息
        <input name="error_num" type="hidden" id="error_num" value="<?php echo  $error_num?>" /></td>
    </tr>
<?php	
	}
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td  align="center" class="firstLine">
        <input type="checkbox" name="checkbox[]" value="<?php echo $result["id"]?>">      </td>
      <td align="center"><span class="STYLE1"><?php echo $result["startdate"]."至".$result["enddate"]?></span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["country"]?></span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["destinations"]?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["day"]."天".$result["night"]."夜"?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["mprice"]."美元"?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["points"]."美元"?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1">
        <?php  if($result["rename"]=="1"){echo "你付";}else{echo "我付";}?>
      </span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["username"]?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["mobile"]?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["wechat"]?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["currdate"]?></span></td>
      <td align="center" bordercolor="#999999"><a href="<?php echo $result['link']?>" class="STYLE1">查看</a></td>
    </tr>
<?php
}
?>
    <tr>
      <td class="bottomtd" align="center" valign="middle"><input name="Submit3" type="submit" class="bottomtd"  onClick="javascript:return window.confirm('确定要删除所选信息吗？')" value="删除" /></td>
      <td class="bottomtd1" colspan="12" align="right">
      
      <? echo $page_num.'条/页 共<font color=red>'.$num.'</font>条 '.$pg->output(1);?></td>
    </tr>
  </table>
</form>
<br>

<p class="errorP">套餐需求信息</p>

<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=needdel">

  <table width="900" align="center">
    <tr>
      <th width="82" class="check firstLine"><input type="checkbox" name="checkbox" value="checkbox" onclick="select_all_need()" />全选</th>
      <th width="123" height="26" align="center" bordercolor="#999999" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">套餐日期</span></th>
      <th width="73" align="center" bordercolor="#999999" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">国家</span></th>
      <th width="123" align="center" bordercolor="#999999" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">旅游地点</span></th>
      <th width="73" align="center" bordercolor="#999999" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">天数</span></th>
      <th width="98" align="center" bordercolor="#999999" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE1">联系人</span></th>
      <th width="73" align="center" bordercolor="#999999" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">手机</span></th>
      <th width="73" align="center" bordercolor="#999999" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">微信</span></th>
      <th width="136" align="center" bordercolor="#999999" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">发布时间</span></th>
    </tr>
<?php
	$pg = & new turn_page();
	$sql = "select * from packageneed  where userid = '".$_SESSION['userid']."' order by id desc" ;
    $query=mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '15';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sqllimit = $sql ." limit ".$limit;
	$query = mysql_query($sqllimit) or die(mysql_error());
	$error_num = mysql_num_rows($query);
	if( $error_num == '0' ){
?>
    <tr>
      <td colspan="9"  align="center" class="firstLine">目前没有发布信息
        <input name="error_num" type="hidden" id="error_num" value="<?php echo  $error_num?>" /></td>
    </tr>
<?php	
	}
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td  align="center" class="firstLine">
        <input type="checkbox" name="checkbox[]" value="<?php echo $result["id"]?>">      </td>
      <td align="center"><span class="STYLE1"><?php echo $result["startdate"]."至".$result["enddate"]?></span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["country"]?></span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["destinations"]?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["day"]."天".$result["night"]."夜"?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["username"]?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["mobile"]?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["wechat"]?></span></td>
      <td align="center" bordercolor="#999999"><span class="STYLE1"><?php echo $result["currdate"]?></span></td>
    </tr>
<?php
}
?>
    <tr>
      <td class="bottomtd" align="center" valign="middle"><input type="submit" name="Submit3"  onClick="javascript:return window.confirm('确定要删除所选信息吗？')" value="删除" /></td>
      <td class="bottomtd1" colspan="8" align="right">
      
      <? echo $page_num.'条/页 共<font color=red>'.$num.'</font>条 '.$pg->output(1);?></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
function loca(a){
	loca_action = document.getElementById('form2')
	loca_action.action = a;
//	window.location.reload();
}
</script>
</body>
</html>
