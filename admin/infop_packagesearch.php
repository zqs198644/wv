<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查询套餐转让</title>
<style>
*{margin:0;padding:0;}
table {border-collapse: collapse;border-spacing: 0;}
#form2, #form1 {margin:10px 10px 10px 9px;font-size:12px;}
#form2 td, #form2 th, #form1 td, #form1 th{line-height:18px; border:1px solid #CCC;padding:4px 5px;}
#form2 th, #form1 th{background:#F4F5EB;color:#454545;font-weight:bold;}
#form2 .red, #form1 .red{color:#F00;}
#form2 .bgblue, #form1 .bgblue{background:#0CF;}
#form2 .bold, #form1 .bold{font-weight:bold;}
#form2 select, .#form1 select{width:103px;}
#form2 td input, #form1 td input{height:18px;line-height:18px;width:15px;border:1px solid #ddd;vertical-align:middle;}
#form2 .bottomtd input, #form1 .bottomtd input{width:90px;padding:0;height:24px;line-height:24px;}
#form2 .check, #form1 .check{width:60px;}
.errorP{ text-align:center;border:2px solid #ddd;border-width:2px 0;padding:8px 0;color:#4545;}
#form2 .firstLine input, #form1 .firstLine input{width:30px; border:none;}
.submit1{height:20px;line-height:20px;margin:0 5px;width:80px;border:1px solid #DDDDDD;vertical-align:middle;}
.text1{width:280px;line-height:18px; height:18px; border:1px solid #CCC;vertical-align:middle; vertical-align:middle;}
#form2 .th1{ height:24px; line-height:24px;padding:2px 5px 3px 5px;}
.STYLE1 {font-size: 12px}
.STYLE11 {font-size: 12px; color: #454545; font-weight: bold; }
</style>
</head>

<body>
<hr>
<script language="javascript">
function checkdata()
{
if (document.form2.query.value=="") {
alert ("请输入查询的关键字 ！")
return false
}
return true
}
</script>
<form id="form2" name="form2" method="POST" action="<?php echo $_SERVER['PHP_SELF']?>"  onsubmit="return checkdata()">
  <table width="574" border="0" align="center">
    <tr>
      <th width="568" align="left" class="th1" scope="col"> 
        <input name="query" type="text" id="query" size="40" class= "text1" />
        <input type="submit" name="Submit" value="搜索" class="submit1" />
           例：普吉岛，输入“普”即可</th>
    </tr>
    <tr>
      <td class="noborder">搜索分类：
        <input name="search" type="radio" value="country" />
        旅游国家&nbsp;&nbsp;
        <input name="search" type="radio" value="destinations" checked="checked" />
        旅游地点
        <input value="night" type="radio" name="search" />
        几夜
        <input value="username" type="radio" name="search" />
        联系人      </td>
    </tr>
  </table>
</form>
<p>
  <?php

require_once("config/inc.php");
require_once("config/turn_page.php");
//require_once("config/auth.php");

extract($_POST);
extract($_GET);
if($query){
		switch($_REQUEST["search"]) 
		{
			case "country":
					$sql = "select * from package where country like '%".$query."%'";
					echo $country;
					break;
			case "destinations":
					$sql = "select * from package where destinations like '%".$query."%'";
					break;
			case "night":
					$sql = "select * from package where night like '%".$query."%'";
					break;
			case "username":
					$sql = "select * from package where username like '%".$query."%'";
					break;
		}
//	$pg = & new turn_page();
//	$sql = $sql.$str;
	$query = mysql_query($sql) or die(mysql_error());
	$num = mysql_num_rows($query);
	if( $num == '0' ){ echo "<script>alert('搜索的内容不存在！');location.href='$_SERVER[PHP_SELF]';</script>";exit(); }

?>
</p>

<table width="904" height="117" border="1" align="center" bordercolor="#999999">
  <tr>
    <th width="151" height="29" bgcolor="#F4F5EB" class="STYLE11">套餐日期</th>
    <th width="50" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">国家</span></th>
    <th width="75" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">旅游地点</span></th>
    <th width="42" bgcolor="#F4F5EB" class="STYLE11">人数</th>
    <th width="42" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">天数</span></th>
    <th width="61" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">会员价格</span></th>
    <th width="68" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">抵扣积分</span></th>
    <th width="44" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">改名费</span></th>
    <th width="50" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">联系人</span></th>
    <th width="46" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">手机</span></th>
    <th width="43" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">微信</span></th>
    <th width="86" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">发布时间</span></th>
    <th width="82" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">套餐链接</span></th>
  </tr>
  <?php
	$pg = & new turn_page();
//	$sql = "select * from  package  order by id desc" ;
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
    <td colspan="13"  align="center" class="firstLine">目前没有任何套餐信息
      <input name="error_num" type="hidden" id="error_num" value="<?php echo  $error_num?>" /></td>
  </tr>
  <?php	
	}
    while($result = mysql_fetch_array($query))
    {
?>
  <tr>
    <td height="30"  align="center" class="firstLine"><span class="STYLE1"><?php echo $result["startdate"]."至".$result["enddate"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["country"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["destinations"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["num"]?>人</span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["day"]."天".$result["night"]."夜"?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["mprice"]."美元"?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["points"]."美元"?></span></td>
    <td align="center"><span class="STYLE1">
      <?php  if($result["rename"]=="1"){echo "你付";}else{echo "我付";}?>
    </span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["username"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["mobile"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["wechat"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["currdate"]?></span></td>
    <td align="center"><a href="<?php echo $result['link']?>" class="STYLE1">查看</a></td>
  </tr>
  <?php
}
?>
  <tr>
    <td colspan="13" align="right" valign="middle" class="STYLE1"><? echo $page_num.'条/页 共<font color=red>'.$num.'</font>条 '.$pg->output(1);?></td>
  </tr>
<?php
}
?>
</table>
<p>&nbsp;</p>
</body>
</html>
