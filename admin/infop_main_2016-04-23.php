<!DOCTYPE html PUbLiC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DreamTrips套餐转让系统</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.STYLE1 {font-size: 14px}
-->
</style>
</head>
<body>
<?php 
			include("config/inc.php");
//			require_once("config/auth.php");
			$sql = "select status from members where status = '1'";
			$query = mysql_query($sql) or die(mysql_error());
			$num = mysql_num_rows($query);
?>
<div class="header">
	<div class="header03" ></div>
	<div class="header01"></div>
	<div class="header02">DreamTrips套餐转让系统</div>
</div>
<div class="bd" id="bd">
<div class="left" id="LeftBox">
	<div class="left_1">
		<div class="left_1_c">当前用户：<?php echo "<font color='red'>".$_SESSION['userid'] . "</font>";if( $_SESSION['isadmin'] == '1' ){ echo '(超级管理员)';}else{ echo '(普通用户)';}?></div>
	</div>
	<div class="left_2">
		<h3 class="left_2top">套餐发布</h3>
	    <div class="left_2down">
		    <div class="left_2down01"><a href="javascript:linkFrom('infop_packagetransfer.php')">发布套餐转让</a></div>
		    <div class="left_2down01"><a href="javascript:linkFrom('infop_packageneed.php');">发布套餐需求</a></div>			
		</div>
	</div>	
	<div class="left_2">
		<h3 class="left_2top">套餐查看</h3>
	    <div class="left_2down">
		    <div class="left_2down01"><a href="javascript:linkFrom('infop_packagemain.php?action=packagetransfer')">查看套餐信息</a></div>
		    <div class="left_2down01"><a href="javascript:linkFrom('infop_packagesearch.php');">查询套餐转让</a></div>			
		</div>
	</div>	
	<div class="left_2">
		<h3 class="left_2top">发布信息管理</h3>
	    <div class="left_2down">
		    <div class="left_2down01"><a href="javascript:linkFrom('infop_infomain.php')">已发布信息管理</a></div>			
		</div>
	</div>	
	<div class="left_2">
		<h3 class="left_2top">用户管理</h3>
		<div class="left_2down">
		<?php if( $_SESSION['isadmin'] == '0' ) {?>
			<div class="left_2down01"><a href="javascript:linkFrom('infop_changepasswd.php');">修改密码</a></div>
			<div class="left_2down01"><a href="javascript:linkFrom('infop_userinfo.php');">个人信息</a></div>
			<div class="left_2down01"><a href="http://www.coolker.cn">翻墙加速</a></div>
			<div class="left_2down01"><a href="javascript:linkFrom('infop_friendship.php');">友情支持</a></div>
		<?php }else{?>
			<div class="left_2down01"><a href="javascript:linkFrom('infop_changepasswd.php');">修改密码</a></div>
			<div class="left_2down01"><a href="javascript:linkFrom('infop_userinfo.php');">个人信息</a></div>
			<div class="left_2down01"><a href="javascript:linkFrom('infop_usermain.php');">用户管理</a></div>
			<div class="left_2down01"><a href="http://www.coolker.cn">翻墙加速</a></div>
			<div class="left_2down01"><a href="javascript:linkFrom('infop_friendship.php');">友情支持</a></div>
		<?php } ?>
		</div>
	</div>
	
	
	<div class="left_1">
		<div class="left03_c"><a href="infop_logout.php">安全退出</a></div>
		<!--退回到登陆页面-->
	</div>
</div>
<div class="rrcc" id="RightBox">
	<div class="center" id="Mobile" onclick="show_menuC()"></div>
	<div class="right" id="li10">	
			<!--2011bxy-->
			 <div class="xy1">
             	 <div class="right01" id="rightName">当前在线人数：<?php echo '<font color=red>'.$num.'</font>';?> 人</div>
				 <iframe frameborder="0" allowtransparency="true" src="infop_packagemain.php?action=packagetransfer" width="920" onload="this.height =900" id="frame_content"></iframe>
			 </div>
	</div>	
</div>
</div>
<div style="text-align:center;font-family:\5fae\8f6f\96c5\9ed1;clear:both;">&nbsp;&nbsp;&nbsp;
  <p>Copyright &copy 2015.6 Worldventures | Dreamtrips All rights reserved. Powered by <a  href="mailto:509447546@qq.com">ZhangQuansheng &nbsp;&nbsp;&nbsp; wechat： zqs198644 </p>
  <p>&nbsp;</p>
</div>
</body>

<script type="text/JavaScript"> 
var $=function(id) {
   return typeof id == "string" ? document.getElementById(id) : id
}
var temp=0;
var leftA = $('LeftBox').getElementsByTagName('a');
var rightIframe = $('RightBox').getElementsByTagName('iframe')[0];
var n = null;
function show_menuC(){
	if (temp==0){
		 $('LeftBox').style.display='none';
	  	 $('RightBox').style.marginLeft='0';
		 $('Mobile').style.background='url(images/center.gif)';
		 temp=1;
	}else{
		$('RightBox').style.marginLeft='222px';
	   	$('LeftBox').style.display='block';
		$('Mobile').style.background='url(images/center0.gif)';
	    temp=0;
	}
}
//iframe
function reinitIframe(){
	var iframe = document.getElementById("frame_content");
	try{
		var bHeight = iframe.contentWindow.document.body.scrollHeight;
		var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
		var height = Math.max(bHeight, dHeight);
		iframe.height =  height;
	}catch (ex){	
	
	}
}
window.setInterval(reinitIframe, 200);
//location 	 
function linkFrom(a){
	for(var i=0;i<leftA.length;i++){
		leftA[i].onclick = function(index){
			return function(){
				$('rightName').innerHTML  = leftA[index].innerHTML ;
			}
		}(i)
	}
	rightIframe.src = a + ""
};
</script>

</html>
