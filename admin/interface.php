<?php
extract($_GET);
$rrd_data=dirname($_SERVER['SCRIPT_FILENAME'])."/rrd_data";
$rrd_file=$rrd_data."/".$hostname;

//判断URL是否有POST参数
if(extract($_GET) == '0'){
		
			echo '<pre>';
			echo 'Uage : curl http://' .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?type=live\&hostname=BAIDU_OP_INF-OP_arch-op_ODSP_bcs_bcs1\&live=1230\&key=xxxxxx <br>';
			echo '       curl http://' .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?type=request\&hostname=BAIDU_OP_INF-OP_arch-op_ODSP_bcs_bcs1\&read_qps=1230\\&write_qps=1230&key=xxxxxx <br>';
			echo '       curl http://' .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?type=storage\&hostname=BAIDU_OP_INF-OP_arch-op_ODSP_bcs_bcs1\&Total=1000\&Used=800\&Free=200\&Avail=100\&key=xxxxxx <br>';


}else{
	//判断密钥是否正确
	if( $key == 'infop666666' )
	{
		//更新RRD数据库内容
		switch($type)
		{
			case 'storage': $ret = rrd_update($rrd_file."_storage.rrd", "N:$Total:$Used:$Free:$Avail");;break;
			case 'live': $ret = rrd_update($rrd_file."_live.rrd", "N:$live");;break;
			case 'request': $ret = rrd_update($rrd_file."_request.rrd", "N:$read_qps:$write_ups:$read_time$write_time");;break;
		}
			//判断数据更新是否成功
			if( $ret == 0 )
			{
			  $err = rrd_error();
			  echo "rrd_update() ERROR occurred: $err\n";
			}else{
				echo 'Update Success !';
			}
	}else{
		echo 'Key Error ,No Permission To Submit Data !';
	}	
}

?>