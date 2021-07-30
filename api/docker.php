<?php
include('config.php');
include('safe.php');
$type=$_GET["type"];
switch ($type) {
case 0: //创建并启动
    
$host_sql = "select * from host where status = 'ing'";
$host_result = $mysqli->query($host_sql);
if(mysqli_num_rows($host_result)!='0')//如果有待执行的任务的话
{
  while($row = $host_result->fetch_assoc()){
    $version=$row['version'];
    $masterip=$row['masterip'];
    $inport=$row['inport'];
    $outport=$row['outport'];
    $sshport=$row['sshport'];
    $cpu=$row['cpu'];
    $memory=1048576*$row['memory'];
    $uestime=$row['uestime'];
    $nodeapiurl=$row['apiurl'];
    Create($nodeapiurl,$cpu,$memory,$version,$sshport,$outport,$inport);
}
}
    break;
    case 1: //停止容器并删除
        $hostid=$_GET["hostid"];
        $outport=$_GET["outport"];
        $masterip=$_GET["masterip"];
        $nodeapiurl=$_GET['apiurl'];
        kill($nodeapiurl,$hostid,$outport);
        break;
}
//创建容器并启动
function Create($nodeapiurl,$cpu,$memory,$version,$sshport,$outport,$inport)
{
include('config.php');
$data=array(
      "Image" => "{$version}",
      "ExposedPorts" => array(
	  "7681/tcp" =>(Object)array(),
	  "{$inport}/tcp" =>(Object)array()
	  ),
      "HostConfig" => array(
        "Privileged" => true,
        "PortBindings" =>  array(
        "7681/tcp" => array(
            array('HostPort'=>"{$sshport}")
        ),
		"{$inport}/tcp" => array(
            array('HostPort'=>"{$outport}")
        ),
        ),
        "Memory" =>(int)$memory,
        "CpusetCpus" => "0,{$cpu}",
        "CpusetMems" => "0,0"
        )
    );

$data_string = $data;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "{$nodeapiurl}/containers/create");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data_string));
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Content-Type: application/json'
    )
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($curl);
curl_close($curl);
echo $res;
  echo "<br>";
  echo json_encode($data_string);
  
$arr = json_decode($res, true);
$hostid=$arr['Id'];
echo "<br>";
  echo $hostid;
 if($hostid !="")
 {
   //增加运行容器
$runing_sql="INSERT INTO `runing`(`hostid`,`node`) VALUES ('{$hostid}','{$nodeapiurl}')";
$runing_result = $mysqli->query($runing_sql);
   //修改状态
$done_sql="UPDATE host SET status='complete' where outport='{$outport}'"; 
$done_result = $mysqli->query($done_sql);
   //修改容器ID
$hostid_sql="UPDATE host SET hostid='{$hostid}' where outport='{$outport}'"; 
$hostid_result = $mysqli->query($hostid_sql);
   Start($nodeapiurl,$hostid);
 }
  else
  {
$done_sql="UPDATE host SET status='error' where outport='{$outport}'"; 
$done_result = $mysqli->query($done_sql);
  }
}
function Start($nodeapiurl,$hostid)
{
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "{$nodeapiurl}/containers/{$hostid}/start");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data_string));
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Content-Type: application/json'
    )
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($curl);
curl_close($curl);
echo $res;
}


//停止容器
function kill($nodeapiurl,$hostid,$outport)
{
include('config.php');
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "{$nodeapiurl}/containers/{$hostid}/kill");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data_string));
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Content-Type: application/json'
    )
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($curl);
curl_close($curl);
echo $res;
$delete_sql="DELETE FROM `runing` WHERE `hostid`='{$hostid}'";
$delete_result = $mysqli->query($delete_sql);
$done_sql="UPDATE host SET status='kill' where outport='{$outport}'"; 
$done_result = $mysqli->query($done_sql);
  Delete($nodeapiurl,$hostid);
}

function Delete($nodeapiurl,$hostid)
{
     $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"{$nodeapiurl}/containers/{$hostid}");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $result = json_decode($result);
    curl_close($ch);

}