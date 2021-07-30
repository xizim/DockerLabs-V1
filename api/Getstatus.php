<?php 
include('config.php');
include('safe.php');
$outport=$_POST["outport"];
$outport_sql = "select * from host where outport = '{$outport}'";
$outport_result = $mysqli->query($outport_sql);
while($row = $outport_result->fetch_assoc()){
  $version=$row['version'];
  $masterip=$row['masterip'];
  $inport=$row['inport'];
  $outport=$row['outport'];
  $cpu=$row['cpu'];
  $memory=$row['memory'];
  $uestime=$row['uestime'];
  $status=$row['status'];
  packData($version,$masterip,$inport,$outport,$cpu,$memory,$uestime,$status);
}






function packData($version,$masterip,$inport,$outport,$cpu,$memory,$uestime,$status){
     $obj=new stdClass();
     $obj->version=$version;
     $obj->masterip=$masterip;
     $obj->inport=$inport;
     $obj->outport=$outport;
     $obj->cpu=$cpu;
     $obj->memory=$memory;
     $obj->uestime=$uestime;
     $obj->status=$status;
	 if(version_compare(PHP_VERSION,'5.4.0',">")){
		echo json_encode($obj,JSON_UNESCAPED_UNICODE); 
	 }
//	 echo json_encode($obj);
}
