<?php 
include('config.php');
include('safe.php');
$outport=$_POST["outport"];
$outport_sql = "select * from host where hostid !=''";
$outport_result = $mysqli->query($outport_sql);
packData("ok",mysqli_num_rows($outport_result));





function packData($status,$count){
     $obj=new stdClass();
     $obj->status=$status;
     $obj->count=$count;
	 if(version_compare(PHP_VERSION,'5.4.0',">")){
		echo json_encode($obj,JSON_UNESCAPED_UNICODE); 
	 }
//	 echo json_encode($obj);
}
