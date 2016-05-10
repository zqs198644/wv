<?php
include("config/inc.php");
echo str_pad(" ",256);
//ob_implicit_flush(true);
$i = "0";
$sql = "select * from disk_error_information";
$query = mysql_query($sql) or die(mysql_error());
while($result = mysql_fetch_array($query)){
    echo 'insert num : <font color=red>'.$i."</font><br>"; 
//    $sql = "insert into dmop_error_disk values ('','".$result[machine_name]."','".$result[idc]."','".$result[error_disk]."','".$result[error_type]."','".$result[error_log]."','".$result[status]."','".$result[reporter]."','".$result[service]."','".$result[report_date]."','".$result[comment]."','".$result[accept_date]."','".$result[reportra_date]."','".$result[finish_handle_date]."','".$result[department]."')";
    $sql = "insert into dmop_error_disk values ('','".$result[machine_name]."','".$result[idc]."','".$result[error_disk]."','".$result[error_type]."','".$result[error_log]."','报修','".$result[reporter]."','".$result[service]."','".$result[report_date]."','".$result[comment]."','".$result[accept_date]."','".$result[reportra_date]."','".$result[finish_handle_date]."','".$result[department]."')";
    mysql_query($sql) or die(mysql_error());
    $i++; 
    ob_flush();
    flush();
}
?>
