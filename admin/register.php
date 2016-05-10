
<?php
include("config/inc.php");
$currdate = date("Y-m-d H:i:s");
header("Content-type: text/html; charset=utf-8"); 

extract($_GET);
extract($_POST);
$userid=trim($user_id);
$password_one=trim($password_one);
$password_two=trim($password_two);

	if("$password_one" != "$password_two")
			{
				echo "<script>alert('两次密码填写不一致');location.href='../register.html';</script>";
				exit ;
			}
			$sql = "select userid from members where userid = '".$userid."'";
			$query = mysql_query($sql) or die(mysql_error());
			$num = mysql_num_rows($query);
			if( $num == 0){
				$sql = "insert into members values('','$userid','','".md5($password_one)."','','','$currdate','','')";
				$query = mysql_query($sql) or die(mysql_error());
				if($query){
					
					echo "<script>alert('用户注册成功，请登陆系统！');location.href='../index.html';</script>"; 
					
					// ·¢ËÍÓÃ»§ÓÊ¼þÓÃ»§Ãû¼°ÃÜÂë
					//$title = "DreamtripsÌ×²Í×ªÈÃÏµÍ³ÕËºÅÇë½÷É÷±£¹Ü";
					//$message ="WVµÄ¼ÒÈËÄúºÃ£º\n\n   ÄúÏÖÔÚµÄÌ×²Í×ªÈÃ»áÔ±IDÎª£º".$user_id."\n\nÃÜÂëÎª£º ".$password_one.", Çë½÷É÷±£¹Ü!\n\n";
					//sendmail($email,$title,$message);
					
				}
			}else{
				echo "<script>alert('用户名已存在，请重新注册！');location.href='../register.html';</script>";
			}

?>
