<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require_once("config/inc.php");
require_once("config/turn_page.php");
//require_once("config/auth.php");
extract($_GET);
extract($_POST);
?>
<title>套餐转让信息</title>
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

.STYLE1 {font-size: 12px}
.STYLE11 {font-size: 12px; color: #454545; font-weight: bold; }
.STYLE12 {font-size: 14px}
.STYLE13 {font-weight: bold}
</style>
</head>
<body>

<div align="center" class="bottomtd">  
  <p class="STYLE12"><span class="STYLE13"><a href="<? $_SERVER['PHP_SELF']?>?action=packagetransfer">套餐转让 </a>|<a href="<? $_SERVER['PHP_SELF']?>?action=packageneed"> 套餐需求</a></span></p>
  <p class="STYLE12">&nbsp;</p>
</div>
<hr />
<?php
if ($action=="packagetransfer"){
	echo '<p class="errorP">套餐转让信息</p>';
?>
 


  <table width="905" height="117" border="1" align="center" bordercolor="#999999">
    <tr>
      <th width="150" height="29" bgcolor="#F4F5EB" class="STYLE11">套餐日期</th>
      <th width="48" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">国家</span></th>
      <th width="73" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">旅游地点</span></th>
      <th width="40" bgcolor="#F4F5EB" class="STYLE11">人数</th>
      <th width="40" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">天数</span></th>
      <th width="59" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">会员价格</span></th>
      <th width="61" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">抵扣积分</span></th>
      <th width="47" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">更名费</span></th>
      <th width="48" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">联系人</span></th>
      <th width="44" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">手机</span></th>
      <th width="41" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">微信</span></th>
      <th width="84" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">发布时间</span></th>
      <th width="88" bgcolor="#F4F5EB" class="STYLE11"><span class="STYLE1">套餐链接</span></th>
    </tr>
<?php
  	$pg = & new turn_page();
  	$sql = "select * from  package  order by id desc" ;
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
      <td colspan="13"  align="center" class="firstLine"><span class="STYLE1">目前没有任何套餐信息</span>
      <input name="error_num" type="hidden" id="error_num" value="<?php echo  $error_num?>" /></td>
    </tr>
<?php	
	}
    while($result = mysql_fetch_array($query))
    {
?>
    <tr>
      <td height="30"  align="center" class="STYLE11"><?php echo $result["startdate"]."至".$result["enddate"]?></td>
      <td align="center"><span class="STYLE1"><?php echo $result["country"]?></span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["destinations"]?></span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["num"]?>人</span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["day"]."天".$result["night"]."夜"?></span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["mprice"]."美元"?></span></td>
      <td align="center"><span class="STYLE1"><?php echo $result["points"]."美元"?></span></td>
      <td align="center"><span class="STYLE1">
      <?php  if($result["rename"]=="1"){echo "您付";}else{echo "我付";}?>
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
</table>

<?php

//套餐需求
}else{
	echo '<p class="errorP">套餐需求信息</p>';

?>
<table width="902" border="1"  align="center" bordercolor="#999999">
  <tr>
    <th width="186" height="26" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">套餐日期</span></th>
    <th width="66" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">国家</span></th>
    <th width="107" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">旅游地点</span></th>
    <th width="61" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">人数</span></th>
    <th width="61" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">天数</span></th>
    <th width="60" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE1">联系人</span></th>
    <th width="71" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">手机</span></th>
    <th width="78" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">微信</span></th>
    <th width="187" align="center" bgcolor="#F4F5EB" class="STYLE1"><span class="STYLE11">发布时间</span></th>
  </tr>
  <?php
    	$pg = & new turn_page();
    	$sql = "select * from  packageneed  order by id desc" ;
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
    <td colspan="9"  align="center" class="firstLine"><span class="STYLE1">目前没有任何套餐信息</span>
    <input name="error_num2" type="hidden" id="error_num2" value="<?php echo  $error_num?>" /></td>
  </tr>
  <?php	
	}
    while($result = mysql_fetch_array($query))
    {
?>
  <tr>
    <td height="25"  align="center" class="form2"><span class="STYLE1"><?php echo $result["startdate"]."至".$result["enddate"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["country"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["destinations"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["num"]?>人</span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["day"]."天".$result["night"]."夜"?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["username"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["mobile"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["wechat"]?></span></td>
    <td align="center"><span class="STYLE1"><?php echo $result["currdate"]?></span></td>
  </tr>
  <?php
}
?>
  <tr>
    <td colspan="9" align="right" valign="middle" class="STYLE1"><? echo $page_num.'条/页 共<font color=red>'.$num.'</font>条 '.$pg->output(1);?></td>
  </tr>
</table>


<?php
}
?>
</body>
</html>
