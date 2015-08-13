/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : yii2_demo

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2015-07-12 12:05:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL COMMENT '登录用户名',
  `name` varchar(100) NOT NULL COMMENT '前台显示用户名',
  `password_prefix` char(32) NOT NULL COMMENT '密码前缀(MD5)',
  `password` char(32) NOT NULL COMMENT '密码(MD5)： 输入密码与password_prefix作MD5',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '(1)ok,(0)disable',
  `insert_time` int(10) DEFAULT NULL COMMENT '插入时间',
  `insert_by` varchar(32) DEFAULT NULL COMMENT '添加者',
  `update_by` varchar(32) DEFAULT NULL COMMENT '最后更新者',
  `update_time` int(10) DEFAULT NULL COMMENT '最后更新时间',
  `ext1` varchar(1000) DEFAULT NULL COMMENT '扩展属性',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('1', 'admin', '管理员', 'ed9ff2c73b36f69ec785d2db605a5137', '4706f1af6f9db997c010ab71eaec9e76', '1', null, null, '', null, null);

-- ----------------------------
-- Table structure for admin_user_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_role`;
CREATE TABLE `admin_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `insert_time` int(10) DEFAULT NULL COMMENT '插入时间',
  `insert_by` varchar(32) DEFAULT NULL COMMENT '添加者',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色关联表';

-- ----------------------------
-- Records of admin_user_role
-- ----------------------------

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL COMMENT '父级权限ID',
  `name` varchar(32) NOT NULL COMMENT '权限名称',
  `description` varchar(100) DEFAULT NULL COMMENT '权限描述',
  `link` varchar(100) DEFAULT NULL COMMENT '权限链接',
  `is_leaf` tinyint(1) NOT NULL COMMENT '是否是叶节点',
  `editable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可编辑',
  `is_nav` tinyint(1) NOT NULL COMMENT '是否用于导航，0-非导航，1-导航',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '(1)ok,(0)disable',
  `insert_time` int(10) DEFAULT NULL COMMENT '插入时间',
  `insert_by` varchar(32) DEFAULT NULL COMMENT '添加者',
  `update_by` varchar(32) DEFAULT NULL COMMENT '最后更新者',
  `update_time` int(10) DEFAULT NULL COMMENT '最后更新时间',
  `level` int(5) DEFAULT NULL COMMENT '层级',
  `seq` int(5) DEFAULT '0' COMMENT '排列序号',
  `icon` varchar(50) DEFAULT NULL COMMENT '图标样式',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `link` (`link`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('1', '0', '顶级权限', null, null, '0', '0', '0', '1', null, null, null, '1436584083', '1', '0', null);
INSERT INTO `permission` VALUES ('71', '1', '系统管理', '', '', '0', '1', '0', '1', '1435406080', null, null, '1436589386', '2', '2', 'icon-list');
INSERT INTO `permission` VALUES ('72', '1', '商品主数据', '', 'product/index', '1', '1', '0', '1', '1435406119', null, null, '1436474109', '2', '0', 'icon-list');
INSERT INTO `permission` VALUES ('73', '1', '用户主数据', '', '', '1', '1', '0', '1', '1435406150', null, null, '1436473543', '2', '1', 'icon-list');
INSERT INTO `permission` VALUES ('98', '71', '用户与权限', '', '#', '0', '1', '0', '1', '1435436426', null, null, '1435437358', '3', '0', 'icon-list');
INSERT INTO `permission` VALUES ('99', '98', '用户管理', '', 'admin/user/index', '1', '1', '0', '1', '1435436470', null, null, '1435436470', '4', '2', 'icon-user');
INSERT INTO `permission` VALUES ('100', '98', '权限管理', '', 'admin/permission/index', '1', '1', '0', '1', '1435436482', null, null, '1435436691', '4', '0', 'icon-list');
INSERT INTO `permission` VALUES ('101', '98', '角色管理', '', 'admin/role/index', '1', '1', '0', '1', '1435436494', null, null, '1435440279', '4', '1', '');
INSERT INTO `permission` VALUES ('102', '1', '全局设置', '', '', '1', '1', '0', '1', '1436578365', null, null, '1436635769', '2', '3', 'icon-list');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '角色名',
  `description` varchar(100) NOT NULL COMMENT '角色描述',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '(1)ok,(0)disable',
  `insert_time` int(10) DEFAULT NULL COMMENT '插入时间',
  `insert_by` varchar(32) DEFAULT NULL COMMENT '添加者',
  `update_by` varchar(32) DEFAULT NULL COMMENT '最后更新者',
  `update_time` int(10) DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '超级管理员', '超级管理员', '1', '1435689342', null, null, '1436464808');

-- ----------------------------
-- Table structure for role_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `permission_id` int(11) NOT NULL COMMENT '权限ID',
  `insert_time` int(10) DEFAULT NULL COMMENT '插入时间',
  `insert_by` varchar(32) DEFAULT NULL COMMENT '添加者',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permission` (`role_id`,`permission_id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `permission_id` (`permission_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COMMENT='角色权限关联表';

-- ----------------------------
-- Records of role_permission
-- ----------------------------
INSERT INTO `role_permission` VALUES ('137', '1', '72', '1436464808', null);
INSERT INTO `role_permission` VALUES ('138', '1', '73', '1436464808', null);
INSERT INTO `role_permission` VALUES ('139', '1', '100', '1436464808', null);
INSERT INTO `role_permission` VALUES ('140', '1', '101', '1436464808', null);
INSERT INTO `role_permission` VALUES ('141', '1', '99', '1436464808', null);
INSERT INTO `role_permission` VALUES ('142', '1', '98', '1436464808', null);
INSERT INTO `role_permission` VALUES ('143', '1', '1', '1436464809', null);
INSERT INTO `role_permission` VALUES ('144', '1', '71', '1436464809', null);
