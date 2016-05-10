<?php
echo "<pre>";
$path=$_SERVER['DOCUMENT_ROOT'];
require_once("$path/admin/admin/config/inc.php");
require_once("$path/admin/amchart/api/amchart_line_function.php");
$sql = "select datetime,sum(money) as money from sale group by datetime";
$query = mysql_query($sql) or die(mysql_error());
$data=array();
while($result = mysql_fetch_array($query)){
//	echo $result[datetime].":".$result[money]."<br>";
	$data = array_merge($data,array($result[datetime]=>$result[money]));
}



$graph = array("name"=>"total","data"=>$data);
print_r($graph);
$res = array("title"=>"Money","graph"=>array($graph));
//print_r($res);
amchart_line_function($res);
?>
