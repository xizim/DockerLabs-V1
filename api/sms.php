<?PHP
include('config.php');
include('safe.php');
$phone=$_POST["phone"];
    /*
     | Submail message/send API demo
     | SUBMAIL SDK Version 2.6 --PHP
     | copyright 2011 - 2017 SUBMAIL
     |--------------------------------------------------------------------------
     */
    
    /*
     |载入 app_config 文件
     |--------------------------------------------------------------------------
     */
    require '../app_config.php';
    
    /*
     |载入 SUBMAILAutoload 文件
     |--------------------------------------------------------------------------
     */
    
    require_once('../SUBMAILAutoload.php');
    
    /*
     |初始化 MESSAGEXsend 类
     |--------------------------------------------------------------------------
     */
    
    $submail=new MESSAGEsend($message_configs);
    
    /*
     |必选参数
     |--------------------------------------------------------------------------
     |设置短信接收的11位手机号码
     |--------------------------------------------------------------------------
     */
    
    $submail->setTo("{$phone}");
    
    /*
     |必选参数
     |--------------------------------------------------------------------------
     |设置短信正文
     |短信正文必须提交一个短信签名，该签名必须使用全角大括号"【"和"】"包含，切该签名必须放在您短信正文的最前端
     |您提交的短信正文，需要在SUBMAIL-》短信-》新建页面提交模板审核后才可以发送，如果 API 返回 420 错误，可判断为没有匹配到模板
     |例：【SUBMAIL】您的短信验证码：4438，请在10分钟内输入。
     |模板匹配机制：缓存+模板计算相似度模式
     |--------------------------------------------------------------------------
     */
    $date=date('Y-m-d H:i:s',time());
    $code=rand(000000,999999);
    $submail->SetContent('【猫云计算】欢迎使用容实验，您的验证码是'.$code.'，30分钟内输入有效。');


    /*
     |调用 send 方法发送短信
     |--------------------------------------------------------------------------
     */
  $phone_sql = "SELECT * FROM `smscode` WHERE `phone`='$phone'";
  $phone_result = $mysqli->query($phone_sql);
 if(mysqli_num_rows($phone_result)<='3')//半小时只能发送3次短信
 {
    while($phonerow = $phone_result->fetch_assoc()){
      $smscode_createtime=$phonerow['createtime'];
    }
    $smscode_time = date('Y-m-d H:i:s',strtotime("$smscode_createtime +5 minute"));//发送频率要间隔在5分钟
    if(strtotime($date)<strtotime($smscode_time))
    {
    if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$/",$phone)){    
    $send=$submail->send();
    
    }
    else
    {
	  packData("error2",$date,"",$phone);
      exit;
    }
    }
   else
   {
     packData("error4",$date,"",$phone);
      exit;
   }
  }
  else
  {
      packData("error3",$date,"",$phone);
      exit;
  }
      /*
     |打印服务器返回值
     |--------------------------------------------------------------------------
     */
    
   // print_r($send);
if($send['status']!="error")
{
//发送成功
$smscode_sql="INSERT INTO `smscode`(`code`,`createtime`,phone) VALUES ({$code},'{$date}','{$phone}')";
$smscode_result = $mysqli->query($smscode_sql);
packData($send['status'],$date,$send['code'],$phone);
}else{ //发送失败
packData($send['status'],$date,$send['code'],$phone);
}

function packData($status,$date,$code,$phone){
     $obj=new stdClass();
     $obj->status=$status;
     $obj->date=$date;
      $obj->code=$code;
      $obj->phone=$phone;
	 if(version_compare(PHP_VERSION,'5.4.0',">")){
		echo json_encode($obj,JSON_UNESCAPED_UNICODE); 
	 }
//	 echo json_encode($obj);
}