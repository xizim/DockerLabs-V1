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
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "$apiurl/containers/$hostid/json");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($curl);
curl_close($curl);
echo "<br>";
echo $res;