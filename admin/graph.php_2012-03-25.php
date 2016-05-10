<?php
header('Content-Type: image/png');
$rrd_file="/home/web/admin/rrd_data/tc-bae-ui1-1.tc_traffic.rrd";
//$rrd_file="/home/web/admin/rrd_data/m1-bae-ui1-8.m1_cpu.rrd";
//$rrd_file="/home/web/admin/rrd_data/m1-bae-ui1-8.m1_mem.rrd";
$rrdtool="/usr/local/rrdtool/bin/rrdtool";
define("RRD_NL", " \\\n");
function escape_command($command) {
        return ereg_replace(":", "\:", $command);
}
extract($_GET);
/*$curdate=date("Y-m-d H:i:s");
$start=$_GET['start'];
$end=$_GET['end'];*/
$opts_cpu = "$rrdtool"." graph - --start=-86400 --end=-300 --title=Test --height=400 --width=800 --alt-autoscale-max DEF:cpuIDLE=".$rrd_file.":cpuIDLE:AVERAGE AREA:cpuIDLE#ff0000"; 
$opts_mem = "$rrdtool"." graph - --start=-86400 --end=-300 --title=Test --height=400 --width=800 --alt-autoscale-max DEF:memTotalReal=".$rrd_file.":memTotalReal:AVERAGE  DEF:memAvailReal=".$rrd_file.":memAvailReal:AVERAGE AREA:memTotalReal#ff0000 STACK:memAvailReal#00ff00"; 

$command = "$rrdtool graph -"  . RRD_NL .
		   "--start=-".$start." --end=-"."$end"  . RRD_NL .
		   "--height=150 --width=650 --base=1000"  . RRD_NL . 
		   "-t 'Day -- Traffic of Gragh to' -v 'Bits per second'" . RRD_NL . 
		   "--alt-autoscale-max" . RRD_NL . 
		   "DEF:traffic_in=".$rrd_file.":traffic_in:AVERAGE" . RRD_NL .
		   "DEF:traffic_out=".$rrd_file.":traffic_out:AVERAGE" . RRD_NL .
//			"CDEF:in_bits=traffic_in,8,*" . RRD_NL .
//			"CDEF:out_bits=traffic_out,8,*" . RRD_NL .
			"COMMENT:'               '" . RRD_NL .
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
			"GPRINT:traffic_out:'MAX:%10.2lf  %Sb/s'" . RRD_NL .
			"GPRINT:traffic_out:'AVERAGE:%10.2lf  %Sb/s'" . RRD_NL .
			"GPRINT:traffic_out:'MIN:%10.2lf %Sb/s'" . RRD_NL .
			"GPRINT:traffic_out:'LAST:%10.2lf %Sb/s'" . RRD_NL .
//			"COMMENT:'\\n'" . RRD_NL .	
			"VRULE:10000000#0000FF:x-mark" . RRD_NL .
			"HRULE:50000000#FF0000:'y-mark > 50M'" . RRD_NL .
			"COMMENT:'\\n'" . RRD_NL .
//			"COMMENT:Update time:".escape_command($curdate)."" . RRD_NL .
			"-W \"Author: ZhangQuanSheng  @2010\"";	
	


//echo $command;

$handle = popen("$command", 'r'); 
$read = ''; 
while (!feof($handle)) { 
        $read .= fgets($handle, 4096); 
} 
pclose($handle); 
echo $read; 

?>
