<?php
require_once("config/inc.php");
require_once("config/auth.php");
$rrd_path='rrd_data';
function create_rrd($rrd_path,$hostname,$type,$opts){
	
	  $rrd_file = "$rrd_path/$hostname"._."$type".".rrd";
	  if(!file_exists("$rrd_file"))
	  {
			$ret = rrd_create($rrd_file, $opts, count($opts));
	 		if( $ret == 0 )
	 		{
				 $err = rrd_error();
				 echo "Create error: $err\n";
	 		 }else{
			 	 echo "<font color=\"#00CC00\"><blink><b>Create:$rrd_file .</b></blink></font><br>";
			 }
	  }else{ 
	  		echo "<font color=\"#FF0000\"><blink><b>".$rrd_file. " is exists !"."</b></blink></font><br>"; 
	  }
}  

$opts_traffic = array( "--step", "300", "--start", 0,
//           "DS:traffic_in:COUNTER:600:U:U",
//           "DS:traffic_out:COUNTER:600:U:U",
           "DS:traffic_in:GAUGE:600:U:U",
           "DS:traffic_out:GAUGE:600:U:U",
           "RRA:AVERAGE:0.5:1:600",
           "RRA:AVERAGE:0.5:6:700",
           "RRA:AVERAGE:0.5:24:775",
           "RRA:AVERAGE:0.5:288:800",
           "RRA:MAX:0.5:1:600",
           "RRA:MAX:0.5:6:700",
           "RRA:MAX:0.5:24:775",
           "RRA:MAX:0.5:288:800",
           "RRA:MIN:0.5:1:600",
           "RRA:MIN:0.5:6:700",
           "RRA:MIN:0.5:24:775",
           "RRA:MIN:0.5:288:800",
           "RRA:LAST:0.5:1:600",
           "RRA:LAST:0.5:6:700",
           "RRA:LAST:0.5:24:775",
           "RRA:LAST:0.5:288:800"
		   );
$opts_mem = array( "--step", "300", "--start", 0,
           "DS:memTotalReal:GAUGE:600:U:U",
           "DS:memAvailReal:GAUGE:600:U:U",
           "DS:memUsedReal:GAUGE:600:U:U",
           "DS:memTotalSwap:GAUGE:600:U:U",
           "DS:memAvailSwap:GAUGE:600:U:U",
           "DS:memUsedSwap:GAUGE:600:U:U",
           "RRA:AVERAGE:0.5:1:600",
           "RRA:AVERAGE:0.5:6:700",
           "RRA:AVERAGE:0.5:24:775",
           "RRA:AVERAGE:0.5:288:800",
           "RRA:MAX:0.5:1:600",
           "RRA:MAX:0.5:6:700",
           "RRA:MAX:0.5:24:775",
           "RRA:MAX:0.5:288:800",
           "RRA:MIN:0.5:1:600",
           "RRA:MIN:0.5:6:700",
           "RRA:MIN:0.5:24:775",
           "RRA:MIN:0.5:288:800",
           "RRA:LAST:0.5:1:600",
           "RRA:LAST:0.5:6:700",
           "RRA:LAST:0.5:24:775",
           "RRA:LAST:0.5:288:800"
        );
$opts_cpu = array( "--step", "300", "--start", 0,
           "DS:cpuIDLE:GAUGE:600:U:U",
           "DS:cpuUSR:GAUGE:600:U:U",
           "DS:cpuSYS:GAUGE:600:U:U",
           "DS:cpuWIO:GAUGE:600:U:U",
           "RRA:AVERAGE:0.5:1:600",
           "RRA:AVERAGE:0.5:6:700",
           "RRA:AVERAGE:0.5:24:775",
           "RRA:AVERAGE:0.5:288:800",
           "RRA:MAX:0.5:1:600",
           "RRA:MAX:0.5:6:700",
           "RRA:MAX:0.5:24:775",
           "RRA:MAX:0.5:288:800",
           "RRA:MIN:0.5:1:600",
           "RRA:MIN:0.5:6:700",
           "RRA:MIN:0.5:24:775",
           "RRA:MIN:0.5:288:800",
           "RRA:LAST:0.5:1:600",
           "RRA:LAST:0.5:6:700",
           "RRA:LAST:0.5:24:775",
           "RRA:LAST:0.5:288:800"
        );
$opts_io = array( "--step", "300", "--start", 0,
           "DS:IO_READ:GAUGE:600:U:U",
           "DS:IO_WRITE:GAUGE:600:U:U",
           "RRA:AVERAGE:0.5:1:600",
           "RRA:AVERAGE:0.5:6:700",
           "RRA:AVERAGE:0.5:24:775",
           "RRA:AVERAGE:0.5:288:800",
           "RRA:MAX:0.5:1:600",
           "RRA:MAX:0.5:6:700",
           "RRA:MAX:0.5:24:775",
           "RRA:MAX:0.5:288:800",
           "RRA:MIN:0.5:1:600",
           "RRA:MIN:0.5:6:700",
           "RRA:MIN:0.5:24:775",
           "RRA:MIN:0.5:288:800",
           "RRA:LAST:0.5:1:600",
           "RRA:LAST:0.5:6:700",
           "RRA:LAST:0.5:24:775",
           "RRA:LAST:0.5:288:800"
        );
$opts_load = array( "--step", "300", "--start", 0,
           "DS:load1min:GAUGE:600:U:U",
           "DS:load5min:GAUGE:600:U:U",
           "DS:load15min:GAUGE:600:U:U",
           "RRA:AVERAGE:0.5:1:600",
           "RRA:AVERAGE:0.5:6:700",
           "RRA:AVERAGE:0.5:24:775",
           "RRA:AVERAGE:0.5:288:800",
           "RRA:MAX:0.5:1:600",
           "RRA:MAX:0.5:6:700",
           "RRA:MAX:0.5:24:775",
           "RRA:MAX:0.5:288:800",
           "RRA:MIN:0.5:1:600",
           "RRA:MIN:0.5:6:700",
           "RRA:MIN:0.5:24:775",
           "RRA:MIN:0.5:288:800",
           "RRA:LAST:0.5:1:600",
           "RRA:LAST:0.5:6:700",
           "RRA:LAST:0.5:24:775",
           "RRA:LAST:0.5:288:800"
        );
$opts_storage = array( "--step", "300", "--start", 0,
           "DS:Total:GAUGE:600:U:U",
           "DS:Used:GAUGE:600:U:U",
           "DS:Free:GAUGE:600:U:U",
           "DS:Avail:GAUGE:600:U:U",
           "RRA:AVERAGE:0.5:1:600",
           "RRA:AVERAGE:0.5:6:700",
           "RRA:AVERAGE:0.5:24:775",
           "RRA:AVERAGE:0.5:288:800",
           "RRA:MAX:0.5:1:600",
           "RRA:MAX:0.5:6:700",
           "RRA:MAX:0.5:24:775",
           "RRA:MAX:0.5:288:800",
           "RRA:MIN:0.5:1:600",
           "RRA:MIN:0.5:6:700",
           "RRA:MIN:0.5:24:775",
           "RRA:MIN:0.5:288:800",
           "RRA:LAST:0.5:1:600",
           "RRA:LAST:0.5:6:700",
           "RRA:LAST:0.5:24:775",
           "RRA:LAST:0.5:288:800"
        );
$opts_request = array( "--step", "300", "--start", 0,
           "DS:READ_QPS:GAUGE:600:U:U",
           "DS:WRITE_QPS:GAUGE:600:U:U",
           "DS:READ_MS:GAUGE:600:U:U",
           "DS:WRITE_MS:GAUGE:600:U:U",
           "RRA:AVERAGE:0.5:1:600",
           "RRA:AVERAGE:0.5:6:700",
           "RRA:AVERAGE:0.5:24:775",
           "RRA:AVERAGE:0.5:288:800",
           "RRA:MAX:0.5:1:600",
           "RRA:MAX:0.5:6:700",
           "RRA:MAX:0.5:24:775",
           "RRA:MAX:0.5:288:800",
           "RRA:MIN:0.5:1:600",
           "RRA:MIN:0.5:6:700",
           "RRA:MIN:0.5:24:775",
           "RRA:MIN:0.5:288:800",
           "RRA:LAST:0.5:1:600",
           "RRA:LAST:0.5:6:700",
           "RRA:LAST:0.5:24:775",
           "RRA:LAST:0.5:288:800"
        );
$opts_live = array( "--step", "300", "--start", 0,
           "DS:LIVE:GAUGE:600:U:U",
           "RRA:AVERAGE:0.5:1:600",
           "RRA:AVERAGE:0.5:6:700",
           "RRA:AVERAGE:0.5:24:775",
           "RRA:AVERAGE:0.5:288:800",
           "RRA:MAX:0.5:1:600",
           "RRA:MAX:0.5:6:700",
           "RRA:MAX:0.5:24:775",
           "RRA:MAX:0.5:288:800",
           "RRA:MIN:0.5:1:600",
           "RRA:MIN:0.5:6:700",
           "RRA:MIN:0.5:24:775",
           "RRA:MIN:0.5:288:800",
           "RRA:LAST:0.5:1:600",
           "RRA:LAST:0.5:6:700",
           "RRA:LAST:0.5:24:775",
           "RRA:LAST:0.5:288:800"
        );
$rrd_type = array("mem","cpu","traffic","io");
//create_rrd($rrd_path,$hostname="BAIDU_OP_INF-OP_arch-op_ODSP_bcs_bcs1",storage,$opts_storage);


//生成machine类型rrd数据库
$sql = "select hostname,type from infop_machine";
$query = mysql_query($sql) or die(mysql_error());

while($result = mysql_fetch_array($query)){
	
	$hostname = $result[hostname];
	$item = explode(',',$result[type]);
    for($i=0;$i<count($item);$i++) 
  	{
		switch($item[$i])
		{
			case 'io': $type = 'io'; $opts = $opts_io;break;
			case 'live': $type = 'live'; $opts = $opts_live;break;
			case 'cpu': $type = 'cpu'; $opts = $opts_cpu;break;
			case 'mem': $type = 'mem'; $opts = $opts_mem;break;
			case 'request': $type = 'request'; $opts = $opts_request;break;
			case 'storage': $type = 'storage'; $opts = $opts_storage;break;
			case 'traffic': $type = 'traffic'; $opts = $opts_traffic;break;
		}
		create_rrd($rrd_path,$hostname,$type,$opts);
		
	}
	
}

//生成cluster 节点类型rrd数据库
$sql = "select nodename,type from infop_nodename";
$query = mysql_query($sql) or die(mysql_error());

while($result = mysql_fetch_array($query)){
	
	$cluster = $result[nodename];
	$item = explode(',',$result[type]);
    for($i=0;$i<count($item);$i++) 
  	{
		switch($item[$i])
		{
			case 'io': $type = 'io'; $opts = $opts_io;break;
			case 'live': $type = 'live'; $opts = $opts_live;break;
			case 'cpu': $type = 'cpu'; $opts = $opts_cpu;break;
			case 'mem': $type = 'mem'; $opts = $opts_mem;break;
			case 'request': $type = 'request'; $opts = $opts_request;break;
			case 'storage': $type = 'storage'; $opts = $opts_storage;break;
			case 'traffic': $type = 'traffic'; $opts = $opts_traffic;break;
		}
		create_rrd($rrd_path,$cluster,$type,$opts);
		
	}
	
}
?>
