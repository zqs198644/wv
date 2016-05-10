<?php
function amchart_line_function($res_arr)
{
#	var_dump($_SERVER['DOCUMENT_ROOT']);
	$TMP_DATA=$_SERVER['DOCUMENT_ROOT']."/oa/admin/amchart/tmpdata";
	#data_file
	$data=$res_arr["graph"];
	$data_xml='<?xml version="1.0"?>
<chart>
  <series>';
	$i=0;
	$x_axis=array();
    foreach($data[0]["data"] as $key=>$value){
		$x_axis[$key]=$i;
		$data_xml.='<value xid="'.$i.'">'.$key.'</value>'."\n";
		$i++;
	}
	$data_xml.='  
    </series>  
  <graphs>
		';
     foreach($data as $graph){
		$data_xml.='<graph title="'.$graph['name'].'" line_width="1" >'."\n";
		foreach($graph["data"] as $key=>$tem_point){
			$data_xml.='<value xid="'.$x_axis[$key].'">'.$tem_point.'</value>'."\n";
		}
		$data_xml.=" </graph>\n";
	 }
    $data_xml.="
	</graphs>
</chart>\n";        
	$data_xml;
	$data_filename="/oa/admin/amchart/tmpdata/amchart_line_data_".time().".xml";
    $datafileFD=fopen($_SERVER['DOCUMENT_ROOT'].$data_filename,"w");
    fwrite($datafileFD,$data_xml);
    fclose($datafileFD);

	#setting_file
	$title=$res_arr["title"];
	$set_xml='<?xml version="1.0"?>
<settings>
  <labels>
    <label lid="0">
      <align>center</align>
      <text_color>#0D8ECF</text_color>
      <text_size>15</text_size>
      <text>'.$title.'</text>
    </label>
  </labels>
</settings>';
	$setting_filename="/oa/admin/amchart/tmpdata/amchart_line_setting_".time().".xml";
    $datafileFD=fopen($_SERVER['DOCUMENT_ROOT'].$setting_filename,"w");
    fwrite($datafileFD,$set_xml);
    fclose($datafileFD);

	#show the chart
	$timestamp=time();
	echo"";
    echo	'<div class="widget_body" id="__widget_fault_tasks">
			<!-- amline script--> 
			<script type="text/javascript" src="amchart/config/amline_1.6.3.0/amline/swfobject.js"></script>
			<div id="'."normal_line_".$timestamp.'">
			     <strong>You need to upgrade your Flash Player</strong>
			</div>
			';
    echo"";
	echo'	<script type="text/javascript">
			                
			     var so = new SWFObject("amchart/config/amline_1.6.3.0/amline/amline.swf", "amline", "100%", "300", "1", "#FFFFFF");
			     so.addVariable("path", "amchart/config/amline_1.6.3.0/amline/");
			     so.addVariable("data_file", encodeURIComponent("'.$data_filename.'"));
			     so.addVariable("settings_file", encodeURIComponent("'.$setting_filename.'"));
//			     so.addVariable("settings_file", encodeURIComponent("amchart/config/amline_1.6.3.0/amline/amline_settings.xml"));
			     // so.addParam("wmode", "Opaque");
			     so.write("'."normal_line_".$timestamp.'");
			     so.write("flashcontent"); 
			</script>
			<!-- end of amline script --> 
		    </div>
				';
//	return;
    
}

function api_example(){
	$res=array(
			"title"=>"我的趋势图",                           #图表名称
			"graph"=>array(
				"0"=>array(                                  #第一条曲线
					"name"=>"line_1",                   #曲线名为“line_name_1”
					"data"=>array(                           
						"2012-03-01"=>"19",			          #曲线数值，为x轴对应y轴值形式
						"2012-03-02"=>"27",
						"2012-03-03"=>35,
						"2012-03-04"=>42,
						"2012-03-05"=>62,
						"2012-03-06"=>32,
						"2012-03-07"=>12,
						)
					),
				"1"=>array(
					"name"=>"line_2",						 #第二条曲线
					"data"=>array(
						"2012-03-01"=>"21",
						"2012-03-02"=>11,
						"2012-03-03"=>32,
						"2012-03-04"=>20,
						"2012-03-05"=>32,
						"2012-03-06"=>41,
						"2012-03-07"=>46,
						)
					)
			)
        );
	amchart_line_function($res);
}
//api_example();
?>
