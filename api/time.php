<?php 
include('config.php');
include('safe.php');
$serverdate=date('Y-m-d H:i:s',time());
//删除过期容器
$host_sql = "SELECT * FROM `host` where status='complete'";
$host_result = $mysqli->query($host_sql);

  while($row = $host_result->fetch_assoc()) {
    $usertime=$row['uestime'];
    $createtime=$row['createtime'];
    $outport=$row['outport'];
    $hostid=$row['hostid'];
    $apiurl=$row['apiurl'];
    $endtime = date('Y-m-d H:i:s',strtotime("$createtime +$usertime hours"));
     if(strtotime($endtime)<strtotime($serverdate)) //已到期
     {
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
     }
}
//删除过期验证码
$smscode_sql = "SELECT * FROM `smscode`";
$smscode_result = $mysqli->query($smscode_sql);
while($row = $smscode_result->fetch_assoc()) {
  $createtime=$row['createtime'];
  $smscode=$row['code'];
  $endtime = date('Y-m-d H:i:s',strtotime("$createtime +30 minute"));
   if(strtotime($endtime)<strtotime($serverdate)) //已到期
   {
     $delete_smscode_sql = "DELETE FROM `smscode` WHERE code={$smscode}";
     $delete_smscode_result = $mysqli->query($delete_smscode_sql);
   }
}