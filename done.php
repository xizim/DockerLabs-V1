<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<title>Docker Labs - 容实验</title>

	<meta name="author" content="" />
	<meta name="description" content="" />

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600" />

	<link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" href="plugins/font-awesome/css/all.css" />

	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/responsive.css" />
	<link rel="stylesheet" href="css/ic-helpers.min.css" />

</head>
<body>



	<!-- Content -->
	<div class="content-home">
		<div class="container m-t-100 m-b-100">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="text-center" id="status">Docker Labs</h1>

					<div class="separator-three"></div>
				</div>

				<div class="m-b-70 clearfix hidden-xs hidden-sm"></div>

				<div class="col-sm-12 m-t-70">
					<form>
						<div class="row">
							<div class="col-xs-12 col-sm-4 col-sm-push-4">
<?php 
include('api/config.php');
include('api/safe.php');
$outport=$_GET["outport"];
$outport_sql = "select * from host where outport = {$outport}";
$outport_result = $mysqli->query($outport_sql);
while($row = $outport_result->fetch_assoc()){
  $version=$row['version'];
  $masterip=$row['masterip'];
  $inport=$row['inport'];
  $outport=$row['outport'];
  $cpu=$row['cpu'];
  $memory=$row['memory'];
  $uestime=$row['uestime'];
  $sshport=$row['sshport'];
  $status=$row['status'];
  $imagesname=$row['imagesname'];
}
                              if($status=="complete"){
                                echo "<h1 class=\"text-center\">创建成功</h1>";
                                echo "<h3 class=\"text-center\">关闭/刷新页面时容器将被删除！</h3>";
                                if($imagesname!="")
                                {
                                 echo "<div class=\"form-group form-group-default\"><label>系统</label><p>$imagesname</p></div>";
                                }
                                else
                                {
                                  echo "<div class=\"form-group form-group-default\"><label>系统</label><p>$version</p></div>";
                                }
							  echo "<div class=\"form-group form-group-default\"><label>外网IP</label><p>$masterip</p></div>";
                              echo "<div class=\"form-group form-group-default\"><label>内部端口</label><p>$inport</p></div>";
                              echo "<div class=\"form-group form-group-default\"><label>外部端口</label><p id=\"outport\">$outport</p></div>";
							  echo "<div class=\"form-group form-group-default\"><label>核心(CPU)</label><p>$cpu</p></div>";
                              echo "<div class=\"form-group form-group-default\"><label>内存(MB)</label><p>$memory</p></div>";
                              echo "<div class=\"form-group form-group-default\"><label>使用时长</label><p>$uestime</p></div>";
								
								echo "<a style=\"margin-top: 10px;margin:5%;\" href=\"http://$masterip:$sshport\" target=\"_blank\"class=\"btn btn-success\"><i class=\"fas fa-terminal\"></i>&nbsp; 打开终端</a>";
                                echo " <a style=\"margin-top: 10px;margin:5%;\" href=\"index.html\" class=\"btn btn-success\"><i class=\"fas fa-home\"></i>&nbsp; 返回首页</a>";
                                echo " <a style=\"margin-top: 10px;width:100%;\" href=\"https://www.xiz.im/archives/63/\" target=\"_blank\" class=\"btn btn-success\"><i class=\"fas fa-cloud-upload-alt\"></i>&nbsp; 上传/下载教程</a>";
                              }
                              else
                              {
                                echo "<h2 class=\"text-center\">请求失败，请稍后重试</h2>";
                                echo " <a href=\"index.html\" class=\"btn btn-success\" style=\"width:360px;\"><i class=\"fas fa-home\"></i>&nbsp; 返回首页</a>";
                              }
                              ?>
                            

								</div>
							</div>

					</form>
				</div>

				<div class="m-b-70 clearfix hidden-xs hidden-sm"></div>
			</div>
		</div>


	<script src="plugins/jquery.min.js"></script>
	<script src="plugins/bootstrap/bootstrap.min.js"></script>

	<script src="js/global.js"></script>
<script> 
    window.onbeforeunload = function (e) {
        e = e || window.event;
        if (e) {
            e.returnValue = '关闭提示';
          var obj = document.getElementById("outport");  
          var outport =obj.innerText;
                var postparams = {
                outport: outport
                };
              console.log(outport);
              $.get("http://labs.cloudneko.com/api/kill.php",postparams,function(data, xhr) { 
          }, "json")
        }

    };
</script> 
</body>
</html>

