<?php 
include('config.php');
include('safe.php');
$outport=$_GET["outport"];

$host_sql = "select * from host where outport = {$outport}";
$host_result = $mysqli->query($host_sql);

  while($row = $host_result->fetch_assoc()) {
    $hostid=$row['hostid'];
    $apiurl=$row['apiurl'];
}
echo $masterip;
echo "<br>";
echo $hostid;
$data=array(
      "type" => (int)1,
  	  "hostid" => "{$hostid}",
  	  "apiurl" => "{$apiurl}",
      "outport" => "{$outport}"
    );
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://labs.cloudneko.com/api/docker.php?type=1&hostid={$hostid}&apiurl={$apiurl}&outport={$outport}");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($curl);
curl_close($curl);
echo "<br>";
echo $res;