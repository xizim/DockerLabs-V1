-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-07-30 14:38:12
-- 服务器版本： 5.7.27-log
-- PHP 版本： 7.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `docker`
--

-- --------------------------------------------------------

--
-- 表的结构 `code`
--

CREATE TABLE `code` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL COMMENT '使用码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用码表';

-- --------------------------------------------------------

--
-- 表的结构 `host`
--

CREATE TABLE `host` (
  `id` int(11) NOT NULL,
  `hostid` varchar(255) NOT NULL COMMENT '容器ID',
  `cpu` int(11) NOT NULL COMMENT 'CPU',
  `memory` int(11) NOT NULL COMMENT '内存',
  `inport` int(11) NOT NULL COMMENT '内部端口(申请时填写)',
  `outport` int(11) NOT NULL COMMENT '外部端口',
  `sshport` int(11) NOT NULL COMMENT 'ssh网页外部端口',
  `uestime` int(11) NOT NULL COMMENT '使用时长(时)',
  `version` varchar(255) NOT NULL COMMENT '镜像版本',
  `imagesname` varchar(255) NOT NULL COMMENT '镜像又名',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `code` varchar(20) NOT NULL COMMENT '使用码',
  `status` varchar(20) NOT NULL COMMENT '状态',
  `masterip` varchar(30) NOT NULL COMMENT '宿主机IP',
  `apiurl` varchar(255) NOT NULL COMMENT '节点API地址',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='申请表';

-- --------------------------------------------------------

--
-- 表的结构 `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `imagesname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `node`
--

CREATE TABLE `node` (
  `id` int(11) NOT NULL,
  `apiurl` varchar(255) NOT NULL COMMENT '节点接口地址',
  `ip` varchar(50) NOT NULL COMMENT '节点IP地址',
  `nodename` varchar(50) NOT NULL COMMENT '节点名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='节点表';

--
-- 转存表中的数据 `node`
--

INSERT INTO `node` (`id`, `apiurl`, `ip`, `nodename`) VALUES
(1, 'http://demo.com:1117', '8.8.8.8', 'node1');

-- --------------------------------------------------------

--
-- 表的结构 `runing`
--

CREATE TABLE `runing` (
  `id` int(11) NOT NULL,
  `hostid` varchar(255) NOT NULL COMMENT '容器ID',
  `node` varchar(30) NOT NULL COMMENT '所属节点名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `smscode`
--

CREATE TABLE `smscode` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `createtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `host`
--
ALTER TABLE `host`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- 表的索引 `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `node`
--
ALTER TABLE `node`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `runing`
--
ALTER TABLE `runing`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `smscode`
--
ALTER TABLE `smscode`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `code`
--
ALTER TABLE `code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `host`
--
ALTER TABLE `host`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `node`
--
ALTER TABLE `node`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `runing`
--
ALTER TABLE `runing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `smscode`
--
ALTER TABLE `smscode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
