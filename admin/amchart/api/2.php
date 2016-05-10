<?php
echo "<pre>";
$path=$_SERVER['DOCUMENT_ROOT'];
require_once("$path/admin/admin/config/inc.php");
require_once("$path/admin/amchart/api/amchart_line_function.php");
$sql = "select datetime,category,sum(money) as money from sale group by category,datetime";
$query = mysql_query($sql) or die(mysql_error());
$data=array();
$graph=array();
$res=array();
while($result = mysql_fetch_array($query)){
//	echo $result[datetime].":".$result[category]."-".$result[money]."<br>";
	$data = array_merge($data,array($result[datetime]=>$result[money]));

//	$name= array_merge($graph,array("name"=>"$result[category]"));

	$graph= array_merge($graph,array("name"=>"$result[category]","data"=>$data));
//	$res = array_merge($res,array("title"=>"Money","graph"=>array($graph)));
}
//	$name =array_merge($graph);



//$graph = array("name"=>"$name","data"=>$data);
//print_r($graph);
$res = array("title"=>"Money","graph"=>array($graph));
print_r($res);
amchart_line_function($res);
?>
