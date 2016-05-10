<?php
header('Content-Type: image/png');
$rrd_data=dirname($_SERVER['SCRIPT_FILENAME'])."/rrd_data";
$hostname="m1-bae-ui1-0.m1";
//$hostname="BAIDU_OP_INF-OP_cloud-op_VHOST-SHARE_bae_ui_onlineB";
//$hostname="BAIDU_OP_INF-OP_arch-op_ODSP";
$hostname="BAIDU_OP_INF-OP_arch-op_ODSP_bcs_bcs1";
$rrd_file=$rrd_data."/".$hostname;
//$rrd_file="/home/web/admin/rrd_data/m1-bae-ui1-8.m1_mem.rrd";
//$rrd_file="/home/web/admin/rrd_data/BAIDU_OP_INF-OP_cloud-op_VHOST-SHARE_bae_ui_static_io.rrd";
$rrdtool="/usr/local/rrdtool/bin/rrdtool";
$height="150";
$width="650";
define("RRD_NL", " \\\n");
function escape_command($command) {
        return ereg_replace(":", "\:", $command);
}
extract($_GET);
$curdate=date("Y-m-d H:i:s");
$opts_cpu = "$rrdtool"." graph - --start=-86400 --end=-300 --title=Test --height=400 --width=800 --alt-autoscale-max DEF:cpuIDLE=".$rrd_file.":cpuIDLE:AVERAGE AREA:cpuIDLE#ff0000"; 
$opts_io = "$rrdtool"." graph - --start=-86400 --end=-300 --title=Test --height=400 --width=800 --alt-autoscale-max DEF:IO_WRITE=".$rrd_file.":IO_WRITE:AVERAGE AREA:IO_WRITE#ff0000"; 
$opts_mem = "$rrdtool"." graph - --start=-86400 --end=-300 --title=Test --height=400 --width=800 --alt-autoscale-max DEF:memTotalReal=".$rrd_file.":memTotalReal:AVERAGE  DEF:memAvailReal=".$rrd_file.":memAvailReal:AVERAGE AREA:memTotalReal#ff0000 STACK:memAvailReal#00ff00"; 


function graph_traffic($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
		$opts_traffic = "$rrdtool graph -"  . RRD_NL .
					   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--height=$height --width=$width --base=1000 --alt-autoscale-max --lower-limit=0 "  . RRD_NL . 
					   "-t 'Day -- Traffic of Gragh to '".$hostname." -v 'Bits per second'" . RRD_NL . 
					   "DEF:traffic_in=".$rrd_file."_traffic.rrd:traffic_in:AVERAGE" . RRD_NL .
					   "DEF:traffic_out=".$rrd_file."_traffic.rrd:traffic_out:AVERAGE" . RRD_NL .
			//			"CDEF:in_bits=traffic_in,8,*" . RRD_NL .
			//			"CDEF:out_bits=traffic_out,8,*" . RRD_NL .
						"COMMENT:'                '" . RRD_NL .
						"COMMENT:'Maximum         '" . RRD_NL .
						"COMMENT:'Average         '" . RRD_NL .
						"COMMENT:'Minimum        '" . RRD_NL .
						"COMMENT:'Current         '" . RRD_NL . 
						"COMMENT:'\\n'" . RRD_NL .
						"AREA:traffic_in#00FF00:traffic_in " . RRD_NL .
						"GPRINT:traffic_in:'MAX:%10.2lf  %Sb/s'" . RRD_NL .
						"GPRINT:traffic_in:'AVERAGE:%10.2lf  %Sb/s'" . RRD_NL .
						"GPRINT:traffic_in:'MIN:%10.2lf %Sb/s'" . RRD_NL .
						"GPRINT:traffic_in:'LAST:%10.2lf %Sb/s'" . RRD_NL .
						"COMMENT:'\\n'" . RRD_NL .
						"LINE1:traffic_out#0000FF:traffic_out" . RRD_NL .
						"GPRINT:traffic_out:'MAX:%9.2lf  %Sb/s'" . RRD_NL .
						"GPRINT:traffic_out:'AVERAGE:%10.2lf  %Sb/s'" . RRD_NL .
						"GPRINT:traffic_out:'MIN:%10.2lf %Sb/s'" . RRD_NL .
						"GPRINT:traffic_out:'LAST:%10.2lf %Sb/s'" . RRD_NL .
			//			"COMMENT:'\\n'" . RRD_NL .	
						"VRULE:10000000#0000FF:x-mark" . RRD_NL .
						"HRULE:50000000#FF0000:'y-mark > 50M'" . RRD_NL .
						"COMMENT:'\\n'" . RRD_NL .
			//			"COMMENT:Update time:".escape_command($curdate)."" . RRD_NL .
						"-W \"Author: ZhangQuanSheng  @2010\"";	
			
		
						$handle = popen("$opts_traffic", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return $read; 

}

function graph_mem($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
		$opts_mem = "$rrdtool graph -"  . RRD_NL .
					   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--height=$height --width=$width --base=1000  --alt-autoscale-max --lower-limit=0"  . RRD_NL . 
					   "-t 'Day -- Mem of Gragh to '".$hostname." -v 'Bits per second'" . RRD_NL . 
					   "DEF:memTotalReal=".$rrd_file."_mem.rrd:memTotalReal:AVERAGE" . RRD_NL .
					   "DEF:memAvailReal=".$rrd_file."_mem.rrd:memAvailReal:AVERAGE" . RRD_NL .
					   "DEF:memUsedReal=".$rrd_file."_mem.rrd:memUsedReal:AVERAGE" . RRD_NL .
					   "CDEF:Total=memTotalReal,1024,*". RRD_NL .
	     			   "CDEF:Avail=memAvailReal,1024,*". RRD_NL .
	    			   "CDEF:Used=memUsedReal,1024,*". RRD_NL .
					   "COMMENT:'               '" 	 . RRD_NL .
	   				   "COMMENT:'Maximum          '"   . RRD_NL .
					   "COMMENT:'Average          '"   . RRD_NL .
					   "COMMENT:'Minimum         '"    . RRD_NL .
					   "COMMENT:'Current         '"    . RRD_NL .	
		 			   "COMMENT:'\\n'" . RRD_NL .
					   "AREA:Total#FFFFFF:Total " . RRD_NL .
					   "GPRINT:Total:'MAX:%13.2lf  %Sb'" . RRD_NL .
					   "GPRINT:Total:'AVERAGE:%13.2lf  %Sb'" . RRD_NL .
					   "GPRINT:Total:'MIN:%13.2lf %Sb'" . RRD_NL .
					   "GPRINT:Total:'LAST:%13.2lf %Sb'" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .
					   "AREA:Used#0000FF:Used " . RRD_NL .
					   "GPRINT:Used:'MAX:%14.2lf  %Sb'" . RRD_NL .
					   "GPRINT:Used:'AVERAGE:%13.2lf  %Sb'" . RRD_NL .
					   "GPRINT:Used:'MIN:%13.2lf %Sb'" . RRD_NL .
					   "GPRINT:Used:'LAST:%13.2lf %Sb'" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .	
					   "STACK:Avail#00FF00:Free " . RRD_NL .
					   "GPRINT:Avail:'MAX:%14.2lf  %Sb'" . RRD_NL .
					   "GPRINT:Avail:'AVERAGE:%13.2lf  %Sb'" . RRD_NL .
					   "GPRINT:Avail:'MIN:%13.2lf %Sb'" . RRD_NL .
					   "GPRINT:Avail:'LAST:%13.2lf %Sb'" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .						
			//		   "COMMENT:Update time:".escape_command($curdate)."" . RRD_NL .
					   "-W \"Author: ZhangQuanSheng  @2010\"";	
	//					echo $opts_mem;
						$handle = popen("$opts_mem", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return  $read; 

}
function graph__cluster_cpu($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
		$opts_cpu = "$rrdtool graph -"  . RRD_NL .
					   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--height=$height --width=$width --base=1000  --alt-autoscale-max --lower-limit=0"  . RRD_NL . 
					   "-t 'Day -- CPU of Gragh to '".$hostname." -v 'Bits per second'" . RRD_NL . 
					   "DEF:cpuIDLE=".$rrd_file."_cpu.rrd:cpuIDLE:AVERAGE" . RRD_NL .
					   "DEF:cpuUSR=".$rrd_file."_cpu.rrd:cpuUSR:AVERAGE" . RRD_NL .
					   "DEF:cpuSYS=".$rrd_file."_cpu.rrd:cpuSYS:AVERAGE" . RRD_NL .
					   "DEF:cpuWIO=".$rrd_file."_cpu.rrd:cpuWIO:AVERAGE" . RRD_NL .
/*					   "CDEF:total=cpuIDLE,cpuUSR,cpuSYS,cpuWIO,+" . RRD_NL .
					   "CDEF:IDLE=100,cpuIDLE,100,/,*" . RRD_NL .
					   "CDEF:USR=100,cpuUSR,100,/,*" . RRD_NL .
					   "CDEF:SYS=100,cpuSYS,100,/,*" . RRD_NL .
					   "CDEF:WIO=100,cpuWIO,100,/,*" . RRD_NL .
*/    				   "COMMENT:'               '" 	 . RRD_NL .
	   				   "COMMENT:'Maximum          '"   . RRD_NL .
					   "COMMENT:'Average          '"   . RRD_NL .
					   "COMMENT:'Minimum         '"    . RRD_NL .
					   "COMMENT:'Current         '"    . RRD_NL .	
		 			   "COMMENT:'\\n'" . RRD_NL .
					   "AREA:cpuWIO#FFCC00:cpuWIO " . RRD_NL .
					   "GPRINT:cpuWIO:'MAX:%14.0lf%%  '" . RRD_NL .
					   "GPRINT:cpuWIO:'AVERAGE:%13.0lf%%  '" . RRD_NL .
					   "GPRINT:cpuWIO:'MIN:%13.0lf%% '" . RRD_NL .
					   "GPRINT:cpuWIO:'LAST:%13.0lf%% '" . RRD_NL . 
					   "COMMENT:'\\n'" . RRD_NL .	
					   "STACK:cpuSYS#0000FF:cpuSYS " . RRD_NL .
					   "GPRINT:cpuSYS:'MAX:%14.0lf%%  '" . RRD_NL .
					   "GPRINT:cpuSYS:'AVERAGE:%13.0lf%%  '" . RRD_NL .
					   "GPRINT:cpuSYS:'MIN:%13.0lf%% '" . RRD_NL .
					   "GPRINT:cpuSYS:'LAST:%13.0lf%% '" . RRD_NL . 
					   "COMMENT:'\\n'" . RRD_NL .	
					   "STACK:cpuUSR#FF0000:cpuUSR " . RRD_NL .
					   "GPRINT:cpuUSR:'MAX:%14.0lf%%  '" . RRD_NL .
					   "GPRINT:cpuUSR:'AVERAGE:%13.0lf%% '" . RRD_NL .
					   "GPRINT:cpuUSR:'MIN:%14.0lf%% '" . RRD_NL .
					   "GPRINT:cpuUSR:'LAST:%13.0lf%% '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .	
					   "STACK:cpuIDLE#00FF00:cpuIDLE " . RRD_NL .
					   "GPRINT:cpuIDLE:'MAX:%13.0lf%%  '" . RRD_NL .
					   "GPRINT:cpuIDLE:'AVERAGE:%14.0lf%% '" . RRD_NL .
					   "GPRINT:cpuIDLE:'MIN:%13.0lf%% '" . RRD_NL .
					   "GPRINT:cpuIDLE:'LAST:%13.0lf%% '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .				
					   "-W \"Author: ZhangQuanSheng  @2010\"";	
					   
						$handle = popen("$opts_cpu", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return  $read; 

}
function graph_cpu($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
		  $opts_cpu = "$rrdtool graph -"  . RRD_NL .
					   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--height=$height --width=$width --base=1000  --alt-autoscale-max --lower-limit=0"  . RRD_NL . 
					   "-t 'Day -- CPU IDLE of Gragh to '".$hostname." -v 'CPU per second'" . RRD_NL . 
					   "DEF:cpuIDLE=".$rrd_file."_cpu.rrd:cpuIDLE:AVERAGE" . RRD_NL .
    				   "COMMENT:'                 '" 	 . RRD_NL .
	   				   "COMMENT:'Maximum          '"   . RRD_NL .
					   "COMMENT:'Average          '"   . RRD_NL .
					   "COMMENT:'Minimum        '"    . RRD_NL .
					   "COMMENT:'Current         '"    . RRD_NL .	
		 			   "COMMENT:'\\n'" . RRD_NL .
					   "AREA:cpuIDLE#FF00FF:cpuIDLE " . RRD_NL .
					   "GPRINT:cpuIDLE:'MAX:%13.0lf%%  '" . RRD_NL .
					   "GPRINT:cpuIDLE:'AVERAGE:%14.0lf%% '" . RRD_NL .
					   "GPRINT:cpuIDLE:'MIN:%13.0lf%% '" . RRD_NL .
					   "GPRINT:cpuIDLE:'LAST:%13.0lf%% '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .				
					   "-W \"Author: ZhangQuanSheng  @2010\"";	
					   
						$handle = popen("$opts_cpu", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return  $read; 

}
function graph_storage($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
	   $opts_storage = "$rrdtool graph -"  . RRD_NL .
					   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--height=$height --width=$width --alt-autoscale-max --lower-limit=0"  . RRD_NL . 
					   "-t 'Day -- Cloud stoage of Gragh to '".$hostname." -v 'Storage per second'" . RRD_NL . 
					   "DEF:Total=".$rrd_file."_storage.rrd:Total:AVERAGE" . RRD_NL .
					   "DEF:Used=".$rrd_file."_storage.rrd:Used:AVERAGE" . RRD_NL .
					   "DEF:Free=".$rrd_file."_storage.rrd:Free:AVERAGE" . RRD_NL .
					   "DEF:Avail=".$rrd_file."_storage.rrd:Avail:AVERAGE" . RRD_NL .
    				   "COMMENT:'                 '" 	 . RRD_NL .
	   				   "COMMENT:'Maximum           '"   . RRD_NL .
					   "COMMENT:'Average          '"   . RRD_NL .
					   "COMMENT:'Minimum        '"    . RRD_NL .
					   "COMMENT:'Current         '"    . RRD_NL .	
		 			   "COMMENT:'\\n'" . RRD_NL .
					   "AREA:Total#FF00FF:Total " . RRD_NL .
					   "GPRINT:Total:'MAX:%15.2lf %S  '" . RRD_NL .
					   "GPRINT:Total:'AVERAGE:%14.2lf %S '" . RRD_NL .
					   "GPRINT:Total:'MIN:%13.2lf %S '" . RRD_NL .
					   "GPRINT:Total:'LAST:%13.2lf %S '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .						  
					   "AREA:Used#00CCFF:Used " . RRD_NL .
					   "GPRINT:Used:'MAX:%16.2lf %S  '" . RRD_NL .
					   "GPRINT:Used:'AVERAGE:%14.2lf %S '" . RRD_NL .
					   "GPRINT:Used:'MIN:%13.2lf %S '" . RRD_NL .
					   "GPRINT:Used:'LAST:%13.2lf %S '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .						  
					   "STACK:Free#FFCC00:Free " . RRD_NL .
					   "GPRINT:Free:'MAX:%16.2lf %S  '" . RRD_NL .
					   "GPRINT:Free:'AVERAGE:%14.2lf %S '" . RRD_NL .
					   "GPRINT:Free:'MIN:%13.2lf %S '" . RRD_NL .
					   "GPRINT:Free:'LAST:%13.2lf %S '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .
					   "STACK:Avail#00FF00:Avail " . RRD_NL .
					   "GPRINT:Avail:'MAX:%14.0lf %S  '" . RRD_NL .
					   "GPRINT:Avail:'AVERAGE:%15.2lf %S '" . RRD_NL .
					   "GPRINT:Avail:'MIN:%13.2lf %S '" . RRD_NL .
					   "GPRINT:Avail:'LAST:%13.2lf %S '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .	

					   "-W \"Author: ZhangQuanSheng  @2010\"";	
					   "COMMENT:'\\n'" . RRD_NL .
						$handle = popen("$opts_storage", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return  $read; 

}
function graph_request($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
	   $opts_request = "$rrdtool graph - "  . RRD_NL .
					   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--height=$height --width=$width --base=1000  --alt-autoscale-max --lower-limit=0"  . RRD_NL . 
					   "-t 'Qps of Gragh to '".$hostname." -v 'Qps per second'" . RRD_NL . 
					   "DEF:READ_QPS=".$rrd_file."_request.rrd:READ_QPS:AVERAGE" . RRD_NL .
					   "DEF:WRITE_QPS=".$rrd_file."_request.rrd:WRITE_QPS:AVERAGE" . RRD_NL .
    				   "COMMENT:'                   '" 	 . RRD_NL .
	   				   "COMMENT:'Maximum          '"   . RRD_NL .
					   "COMMENT:'Average            '"   . RRD_NL .
					   "COMMENT:'Minimum             '"    . RRD_NL .
					   "COMMENT:'Current         '"    . RRD_NL .	
					   "COMMENT:'\\n'" . RRD_NL .	
					   "AREA:WRITE_QPS#FFCC00:WRITE_QPS " . RRD_NL .
					   "GPRINT:WRITE_QPS:'MAX:%12.0lf%S ups/s  '" . RRD_NL .
					   "GPRINT:WRITE_QPS:'AVERAGE:%8.0lf%S ups/s '" . RRD_NL .
					   "GPRINT:WRITE_QPS:'MIN:%11.0lf%S ups/s '" . RRD_NL .
					   "GPRINT:WRITE_QPS:'LAST:%13.0lf%S ups/s '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .
					   "LINE2:READ_QPS#0000FF:READ_QPS " . RRD_NL .
					   "GPRINT:READ_QPS:'MAX:%13.0lf%S qps/s  '" . RRD_NL .
					   "GPRINT:READ_QPS:'AVERAGE:%8.0lf%S qps/s '" . RRD_NL .
					   "GPRINT:READ_QPS:'MIN:%11.0lf%S qps/s '" . RRD_NL .
					   "GPRINT:READ_QPS:'LAST:%13.0lf%S qps/s '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .				
					   "-W \"Author: ZhangQuanSheng  @2010\"";	
					   
						$handle = popen("$opts_request", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return  $read; 
						echo $opts_request;

}
function graph_request_time($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
		  $opts_request_time = "$rrdtool graph -"  . RRD_NL .
					   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--height=$height --width=$width --base=1000  --alt-autoscale-max --lower-limit=0"  . RRD_NL . 
					   "-t 'Time of Gragh to '".$hostname." -v 'Time per msecond'" . RRD_NL . 
					   "DEF:READ_MS=".$rrd_file."_request.rrd:READ_MS:AVERAGE" . RRD_NL .
					   "DEF:WRITE_MS=".$rrd_file."_request.rrd:WRITE_MS:AVERAGE" . RRD_NL .
    				   "COMMENT:'                   '" 	 . RRD_NL .
	   				   "COMMENT:'Maximum          '"   . RRD_NL .
					   "COMMENT:'Average            '"   . RRD_NL .
					   "COMMENT:'Minimum           '"    . RRD_NL .
					   "COMMENT:'Current         '"    . RRD_NL .	
					   "COMMENT:'\\n'" . RRD_NL .	
					   "AREA:WRITE_MS#FFCC00:WRITE_TIME " . RRD_NL .
					   "GPRINT:WRITE_MS:'MAX:%13.2lf%S ms  '" . RRD_NL .
					   "GPRINT:WRITE_MS:'AVERAGE:%11.2lf%S ms '" . RRD_NL .
					   "GPRINT:WRITE_MS:'MIN:%13.2lf%S ms '" . RRD_NL .
					   "GPRINT:WRITE_MS:'LAST:%13.2lf%S ms '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .
					   "LINE1:READ_MS#0000FF:READ_TIME " . RRD_NL .
					   "GPRINT:READ_MS:'MAX:%14.2lf%S ms  '" . RRD_NL .
					   "GPRINT:READ_MS:'AVERAGE:%11.2lf%S ms '" . RRD_NL .
					   "GPRINT:READ_MS:'MIN:%13.2lf%S ms '" . RRD_NL .
					   "GPRINT:READ_MS:'LAST:%13.2lf%S ms '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .				
					   "-W \"Author: ZhangQuanSheng  @2010\"";	
					   
						$handle = popen("$opts_request_time", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return  $read; 

}
function graph_live($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
	 	  $opts_live = "$rrdtool graph -"  . RRD_NL .
					   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--height=$height --width=$width --alt-autoscale-max --lower-limit=0"  . RRD_NL . 
					   "-t 'Live Machine of Gragh to '".$hostname." -v 'Live per cluster'" . RRD_NL . 
					   "DEF:LIVE=".$rrd_file."_live.rrd:LIVE:AVERAGE" . RRD_NL .
    				   "COMMENT:'                 '" 	 . RRD_NL .
	   				   "COMMENT:'Maximum           '"   . RRD_NL .
					   "COMMENT:'Average          '"   . RRD_NL .
					   "COMMENT:'Minimum        '"    . RRD_NL .
					   "COMMENT:'Current         '"    . RRD_NL .	
		 			   "COMMENT:'\\n'" . RRD_NL .
					   "LINE1:LIVE#FF0000:LIVE " . RRD_NL .
					   "GPRINT:LIVE:'MAX:%16.0lf  '" . RRD_NL .
					   "GPRINT:LIVE:'AVERAGE:%17.0lf '" . RRD_NL .
					   "GPRINT:LIVE:'MIN:%16.0lf '" . RRD_NL .
					   "GPRINT:LIVE:'LAST:%13.0lf '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .				
					   "-W \"Author: ZhangQuanSheng  @2010\"";	
					    
						$handle = popen("$opts_live", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return  $read; 

}

function graph_io($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool){
	 	  $opts_io = "$rrdtool graph -"  . RRD_NL .
		//			   "--start=-".$start." --end=-"."$end"  . RRD_NL .
					   "--start=$start --end=$end"  . RRD_NL .
					   "--height=$height --width=$width --base=1000 --alt-autoscale-max --lower-limit=0"  . RRD_NL . 
					   "-t 'IO of Gragh to '".$hostname." -v 'IO Read and Write'" . RRD_NL . 
					   "DEF:IO_READ=".$rrd_file."_io.rrd:IO_READ:AVERAGE" . RRD_NL .
					   "DEF:IO_WRITE=".$rrd_file."_io.rrd:IO_WRITE:AVERAGE" . RRD_NL .
    				   "COMMENT:'                 '" 	 . RRD_NL .
	   				   "COMMENT:'Maximum           '"   . RRD_NL .
					   "COMMENT:'Average          '"   . RRD_NL .
					   "COMMENT:'Minimum        '"    . RRD_NL .
					   "COMMENT:'Current         '"    . RRD_NL .	
		 			   "COMMENT:'\\n'" . RRD_NL .
					   "LINE1:IO_READ#0000FF:IO_READ " . RRD_NL .
					   "GPRINT:IO_READ:'MAX:%13.2lf%Sb  '" . RRD_NL .
					   "GPRINT:IO_READ:'AVERAGE:%14.2lf%Sb  '" . RRD_NL .
					   "GPRINT:IO_READ:'MIN:%13.2lf%Sb  '" . RRD_NL .
					   "GPRINT:IO_READ:'LAST:%10.2lf%Sb  '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .	
					   "AREA:IO_WRITE#FFCC00:IO_WRITE " . RRD_NL .
					   "GPRINT:IO_WRITE:'MAX:%12.2lf%Sb   '" . RRD_NL .
					   "GPRINT:IO_WRITE:'AVERAGE:%13.2lf%Sb  '" . RRD_NL .
					   "GPRINT:IO_WRITE:'MIN:%13.2lf%Sb  '" . RRD_NL .
					   "GPRINT:IO_WRITE:'LAST:%10.2lf%Sb  '" . RRD_NL .
					   "COMMENT:'\\n'" . RRD_NL .				
					   "-W \"Author: ZhangQuanSheng  @2010\"";	
					    
						$handle = popen("$opts_io", 'r'); 
						$read = ''; 
						while (!feof($handle)) { 
								$read .= fgets($handle, 4096); 
						} 
						pclose($handle); 
						return  $read; 

}
$rr=graph_io($start,$end,$width,$height,$hostname,$rrd_file,$rrdtool);
echo $rr;
?>
