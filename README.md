# DockerLabs-V1

<p>游客可通过web页面直接创建出NAT容器，本项目从发布后将不再维护任何bug，以后有时间会出sdk重构版。</p>

<img src="https://xiz-blog.oss-cn-shenzhen.aliyuncs.com/typecho/2019/01/28/468084185966661/docker.gif" alt="dockerlabs" >

<h3>环境要求</h3>
<p>使用了赛邮云发送短信号码，需要自己去申请appid和appkey填写到app_config.php文件中</p>
<li>php7</li>
<li>nginx</li>
<li>docker</li>
<h3>数据库说明</h3>
<p>创建docker数据库然后执行docker.sql文件导入表结构与demo数据</p>
<li>code表为使用码表</li>
<li>host表为容器表</li>
<li>node表为节点表</li>
<li>runing表为正在运行的容器表</li>
<h3>节点初始化配置</h3>
<li>1.安装docker</li>
<li>2.开启API</li>

```bash
$ systemctl show --property=FragmentPath docker </br>
$ vi /lib/systemd/system/docker.service  </br>
ExecStart=/usr/bin/dockerd -H unix:///var/run/docker.sock -H tcp://0.0.0.0:1117  </br>
$ systemctl daemon-reload  && systemctl restart docker
```

<li>3.拉取基础镜像(或者自己在本地build镜像)</li>
* 请参考[https://github.com/xizim/docker-ttyd](https://github.com/xizim/docker-ttyd)
<h3>API结构说明</h3>

<li>api/config.php --- 数据库配置</li>
<li>api/create.php --- 容器创建接口</li>
<li>api/docker.php --- 容器操作接口，包含创建、启动、停止、删除功能</li>
<li>api/GetCount.php --- 获取已创建过的容器数量</li>
<li>api/Getport.php --- 获取容器的SSH端口、外部放行端口</li>
<li>api/Getstatus.php --- 获取容器信息，版本、宿主机IP、内部端口、外部端口、CPU、内存、使用时长、容器状态</li>
<li>api/kill.php --- 删除容器接口</li>
<li>api/time.php --- 定时任务，删除已过使用时长的容器、删除已过期的验证码</li>
<li>api/GetNodeStatus.php ---获取节点状态</li>
<li>docker.sql --- 数据库结构</li>