<?php
include('config.php');
include('safe.php');
$getname=$_GET["nodename"];
$node_sql = "select * from node where nodename='{$getname}'";
$node_result = $mysqli->query($node_sql);
while($row = $node_result->fetch_assoc()){
  $apiurl=$row['apiurl'];
  $nodename=$row['nodename'];
  if(getHttpcode($apiurl)=="404")
  {
  packData("ok",$nodename);
  }
  else
  {
  packData("error",$nodename);
  }
}
function getHttpcode($url){
$ch=curl_init();
$timeout=10;
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
curl_setopt($ch,CURLOPT_URL,$url);
curl_exec($ch);
$httpcode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
curl_close($ch);
return $httpcode;
}
function packData($status,$nodename){
     $obj=new stdClass();
     $obj->status=$status;
     $obj->nodename=$nodename;
	 if(version_compare(PHP_VERSION,'5.4.0',">")){
		echo json_encode($obj,JSON_UNESCAPED_UNICODE); 
	 }
//	 echo json_encode($obj);
}