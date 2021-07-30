<?php 
include('config.php');
include('safe.php');
$status="ok";
$outport = mt_rand(20000, 30000);
$sshport = mt_rand(30001, 40000);
$outport_sql = "select * from host where outport = '{$outport}'";
$outport_result = $mysqli->query($outport_sql);
$sshport_sql = "select * from host where sshport = '{$sshport}'";
$sshport_result = $mysqli->query($sshport_sql);
if(mysqli_num_rows($outport_result)=='0' && mysqli_num_rows($sshport_result)=='0' )
{
  packData($status,$outport,$sshport);
}
else
{
$outport = mt_rand(20000, 30000);
$sshport = mt_rand(30001, 40000);
$outport_sql = "select * from host where outport = '{$outport}'";
$outport_result = $mysqli->query($outport_sql);
$sshport_sql = "select * from host where sshport = '{$sshport}'";
$sshport_result = $mysqli->query($sshport_sql);
if(mysqli_num_rows($outport_result)=='0' && mysqli_num_rows($sshport_result)=='0' )
{
  packData($status,$outport,$sshport);
}
  else
  {
    $outport = mt_rand(20000, 30000);
$sshport = mt_rand(30001, 40000);
$outport_sql = "select * from host where outport = '{$outport}'";
$outport_result = $mysqli->query($outport_sql);
$sshport_sql = "select * from host where sshport = '{$sshport}'";
$sshport_result = $mysqli->query($sshport_sql);
if(mysqli_num_rows($outport_result)=='0' && mysqli_num_rows($sshport_result)=='0' )
{
  packData($status,$outport,$sshport);
}
  }
}







function packData($status,$outport,$sshport){
     $obj=new stdClass();
     $obj->status=$status;
     $obj->outport=$outport;
     $obj->sshport=$sshport;
	 if(version_compare(PHP_VERSION,'5.4.0',">")){
		echo json_encode($obj,JSON_UNESCAPED_UNICODE); 
	 }
//	 echo json_encode($obj);
}
