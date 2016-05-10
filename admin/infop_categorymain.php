<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require_once("config/inc.php");
require_once("config/turn_page.php");
require_once("config/auth.php");
?>
<title>品类管理</title>
<style>
*{margin:0;padding:0;}
table {border-collapse: collapse;border-spacing: 0;}
#form2 {font-size:12px;}
#form2 td, #form2 th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
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

</style>
</head>
<body>
<?php
extract($_GET);
extract($_POST);
switch($action) 
{
			case "delete":
					$sql = "delete from category where id = '".$id."'";
					$query = mysql_query($sql) or die(mysql_error());
					if($query){
						echo "<script>alert('品类信息删除成功！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					}else{
						echo "<script>alert('品类信息删除失败！');location.href='$_SERVER[PHP_SELF]';</script>"; 
					}
					break;
			case "batchdel":
					if(empty($_POST[checkbox])){
						echo "<script>alert('请选择要删除的信息列表！');</script>";
					}else{
						$delete_id=implode(",",$_POST['checkbox']);
						$sql = "delete from category where id in ($delete_id)"; 
						$query = mysql_query($sql) or die(mysql_error());
						if($query){
						   echo "<script>alert('信息删除成功！');</script>";
						}
					}
					break;
}
?>
<hr />
<p class="errorP">品类信息管理</p>
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

<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=batchdel">

  <table width="832" align="center">
    <tr>
      <th width="72" class="check firstLine"><input type="checkbox" name="checkbox" value="checkbox" onclick="select_all()" />全选</th>
      <th width="84">品类</th>
      <th width="85">售价(元/斤)</th>
      <th width="120">成本(斤/元)</th>
      <th width="74">类型</th>
      <th width="296">说明</th>
      <th width="69">编缉|删除</th>
    </tr>
<?php
	$pg = & new turn_page();
	$sql = "select * from  category" ;
    $query=mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query);
	$pg->file = $GLOBALS['PHP_SELF'];
    $pg->pvar = 'page';
	$page_num = '25';
    $pg->set($page_num,$num,0);
    $limit = $pg->limit();
    $sqllimit = $sql ." limit ".$limit;
	$query = mysql_query($sqllimit) or die(mysql_error());
	$error_num = mysql_num_rows($query);
	if( $error_num == '0' ){
?>
    <tr>
      <td colspan="7"  align="center" class="firstLine">目前没有节点
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
      <td align="center"><?php echo $result["category"]?></td>
      <td align="center"><?php echo $result["price"]?></td>
      <td align="center"><?php echo $result["cost"]?></td>
      <td align="center"><?php if($result["groupid"] == '0'){
	  						       echo "海鲜";
							}elseif($result["groupid"] == '1'){
								   echo "蔬菜";
							}elseif($result["groupid"] == '2'){
								   echo "烧烤";
							}elseif($result["groupid"] == '3'){
								   echo "原料";
							}?></td>
      <td align="center"><?php echo $result["comment"]?></td>
      <td align="center"><a href="infop_categoryedit.php?id=<?php echo  $result["id"]?>"></a><a href="infop_categoryedit.php?id=<?php echo  $result["id"]?>">编缉</a>|<a href="<?php echo $_SERVER['PHP_SELF']."?action=delete&id=".$result[id]?>">删除</a></td>
    </tr>
<?php
}
?>
    <tr>
      <td class="bottomtd" align="center" valign="middle"><input type="submit" name="Submit3"  onClick="javascript:return window.confirm('确定要删除品类信息吗？')" value="批量删除" /></td>
      <td class="bottomtd1" colspan="6" align="right"><? echo $page_num.'条/页 共<font color=red>'.$num.'</font>条 '.$pg->output(1);?></td>
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
