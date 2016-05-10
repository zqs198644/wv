<?php
header('Content-Type: image/png');
//$hostname="m1-bae-ui1-1.m1";
//$hostname="BAIDU_OP_INF-OP_arch-op_ODSP_bcs_bcs1";
extract($_GET);
require_once("rrd_options.php");

switch($type){
	  case "traffic": 
	  		$graph=graph_traffic($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
			break;
	  case "cpu": 
	  		$graph=graph_cpu($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
			break;
	  case "mem": 
	       $graph=graph_mem($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
			break;
	  case "io": 
	       $graph=graph_io($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
			break;
	  case "live": 
	       $graph=graph_live($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
			break;	
	  case "storage": 
	       $graph=graph_storage($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
			break;
	  case "request": 
	       $graph=graph_request($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
		    break;
	  case "request_time": 
	       $graph=graph_request_time($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
		    break;
}
 
echo $graph;
?>
