<?php 
include('config.php');
include('safe.php');
$cpu=$_GET["cpu"];
$memory=$_GET["memory"];
$inport=$_GET["inport"];
$outport=$_GET["outport"];
$sshport=$_GET["sshport"];
$uestime=$_GET["uestime"];
$version=$_GET["version"];
$nodename=$_GET["nodename"];
$code=$_GET["code"];
$smscode=$_GET["smscode"];
$date=date('Y-m-d H:i:s',time());
//获取使用码
$code_sql = "select * from code where code = {$code}";
$code_result = $mysqli->query($code_sql);
if (!$code_result) {
    printf("Error: %s\n", mysqli_error($mysqli));
  echo "<br>";
   echo $code_sql;
    exit();
}
if(mysqli_num_rows($code_result)=='0' )
{
  $status="error1";
  packData($status,$date,$outport,"使用码无效");
}
else
{
//判断验证码是否存在
if($smscode!="")
{
$smscode_sql = "select * from smscode where code = {$smscode}";
$smscode_result = $mysqli->query($smscode_sql);
if(mysqli_num_rows($smscode_result)=='0' )
{
  $status="error2";
  packData($status,$date,$outport,"验证码无效");
}
else
{
//获取手机号码
while($smscoderow = $smscode_result->fetch_assoc()){
  $phone=$smscoderow['phone'];
}

//获取节点接口地址和IP地址
$node_sql = "select * from node where nodename = '{$nodename}'";
$node_result = $mysqli->query($node_sql);
while($row = $node_result->fetch_assoc()){
  $apiurl=$row['apiurl'];
  $masterip=$row['ip'];
}
//获取系统又名镜像
$images_sql = "select * from images where imagesname = '{$version}'";
$images_result = $mysqli->query($images_sql);
if(mysqli_num_rows($images_result)!='0' )//如果有又名的话使用又名
{
 while($images_row = $images_result->fetch_assoc()){
$imagesname=$images_row['name'];
$host_sql="INSERT INTO `host`(`cpu`,`memory`, `inport`, `outport`, `sshport`, `uestime`, `version`,`imagesname`, `createtime`, `code`, `status`, `masterip`,`apiurl`,`phone`) VALUES ({$cpu},{$memory},{$inport},{$outport},{$sshport},{$uestime},'{$version}','{$imagesname}','{$date}','{$code}','ing','{$masterip}','{$apiurl}',{$phone})";
$host_result = $mysqli->query($host_sql);
$status="ok";
}
}
else
{
$host_sql="INSERT INTO `host`(`cpu`,`memory`, `inport`, `outport`, `sshport`, `uestime`, `version`, `createtime`, `code`, `status`, `masterip`,`apiurl`,`phone`) VALUES ({$cpu},{$memory},{$inport},{$outport},{$sshport},{$uestime},'{$version}','{$date}','{$code}','ing','{$masterip}','{$apiurl}',{$phone})";
$host_result = $mysqli->query($host_sql);
$status="ok";
}
  




//删除验证码
if($phone!="7777777")
{
$delete_smscode_sql="DELETE FROM `smscode` WHERE code={$smscode} AND phone='{$phone}'";
$delete_smscode_result = $mysqli->query($delete_smscode_sql);
}
packData($status,$date,$outport,$delete_smscode_sql); 
$data=array(
      "type" => (int)0,
    );
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://labs.cloudneko.com/api/docker.php");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($curl);
curl_close($curl);
}
}
  else
  {
      $status="error2";
  packData($status,$date,$outport,"验证码无效");
  }
}
function packData($status,$date,$outport,$result){
     $obj=new stdClass();
     $obj->status=$status;
     $obj->date=$date;
     $obj->outport=$outport;
     $obj->result=$result;
	 if(version_compare(PHP_VERSION,'5.4.0',">")){
		echo json_encode($obj,JSON_UNESCAPED_UNICODE); 
	 }
//	 echo json_encode($obj);
}