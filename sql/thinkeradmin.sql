/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100134
 Source Host           : localhost:3306
 Source Schema         : thinkeradmin

 Target Server Type    : MySQL
 Target Server Version : 100134
 File Encoding         : 65001

 Date: 26/03/2019 19:59:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ices_cms
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms`;
CREATE TABLE `ices_cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `columnid` int(11) DEFAULT NULL COMMENT '当前栏目ID',
  `modelid` int(11) DEFAULT NULL COMMENT '模型ID',
  `is_b` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否加粗: 0=不加粗, 1=加粗',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `coverpic` longtext COMMENT '封面图片',
  `is_head` tinyint(1) NOT NULL DEFAULT '0' COMMENT '头条（0=否，1=是）',
  `is_special` tinyint(1) NOT NULL DEFAULT '0' COMMENT '特荐（0=否，1=是）',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶（0=否，1=是）',
  `is_recom` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐（0=否，1=是）',
  `content` longtext COMMENT '内容，可以为文本或图片',
  `author` varchar(200) DEFAULT NULL COMMENT '作者',
  `visit_num` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `seo_title` varchar(200) CHARACTER SET utf8 DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(200) CHARACTER SET utf8 DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` text CHARACTER SET utf8 COMMENT 'SEO描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态(0=屏蔽，1=正常)',
  `list_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序号',
  `op_id` int(11) DEFAULT NULL COMMENT '操作编号',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='Cms具体内容表';

-- ----------------------------
-- Table structure for ices_cms_columns
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_columns`;
CREATE TABLE `ices_cms_columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `modelid` int(11) DEFAULT NULL COMMENT '栏目当前模型ID',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '栏目上级ID,不填写默认为0，顶级栏目',
  `name` varchar(200) DEFAULT NULL COMMENT '栏目名称',
  `en_name` varchar(200) DEFAULT NULL COMMENT '栏目英文名',
  `level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '栏目层级',
  `is_link` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是外部链接：0=不是，1=是外部链接',
  `link` longtext COMMENT '栏目链接',
  `coverpic` longtext COMMENT '栏目图片',
  `seo_title` varchar(200) DEFAULT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(200) DEFAULT NULL COMMENT 'SEO关键字',
  `seo_description` varchar(200) DEFAULT NULL COMMENT 'SEO描述',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏栏目：0=显示，1=隐藏',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用栏目：1=显示，0=隐藏',
  `op_id` int(11) DEFAULT NULL COMMENT '操作人ID',
  `list_order` int(11) DEFAULT NULL COMMENT '排序',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='Cms对应栏目表';

-- ----------------------------
-- Table structure for ices_cms_guestbook
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_guestbook`;
CREATE TABLE `ices_cms_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `columnid` int(11) DEFAULT NULL,
  `content` longtext,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `columnid` (`columnid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='留言板记录';

-- ----------------------------
-- Table structure for ices_cms_guestbook_attr
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_guestbook_attr`;
CREATE TABLE `ices_cms_guestbook_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `columnid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `values` longtext,
  `is_must` int(1) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `columnid` (`columnid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='留言板参数';

-- ----------------------------
-- Table structure for ices_cms_models
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_models`;
CREATE TABLE `ices_cms_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` varchar(50) NOT NULL DEFAULT '' COMMENT '识别id',
  `title` varchar(50) DEFAULT NULL COMMENT '名称',
  `stitle` varchar(30) DEFAULT NULL COMMENT '菜单缩写名称',
  `table` varchar(50) DEFAULT NULL COMMENT '表名，除了archives之外其他对应',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态(1=启用，0=屏蔽)',
  `ifsystem` tinyint(1) NOT NULL DEFAULT '0' COMMENT '字段分类，1=系统(不可修改)，0=自定义',
  `list_order` tinyint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `fields` longtext COMMENT '拥有字段',
  `create_time` datetime DEFAULT NULL COMMENT '新增时间',
  `update_time` datetime DEFAULT NULL COMMENT '刷新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nid` (`nid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='Cms对应类型表';

-- ----------------------------
-- Records of ices_cms_models
-- ----------------------------
BEGIN;
INSERT INTO `ices_cms_models` VALUES (1, 'article', '文章模型', '文章', '', 1, 1, 0, NULL, '2019-03-13 17:53:36', '2019-03-21 19:30:59');
INSERT INTO `ices_cms_models` VALUES (2, 'download', '下载模型', '下载', '', 1, 1, 0, NULL, '2019-03-13 17:56:46', '2019-03-21 19:51:04');
INSERT INTO `ices_cms_models` VALUES (3, 'product', '产品模型', '产品', '', 1, 1, 0, NULL, '2019-03-13 17:57:06', '2019-03-21 23:36:26');
INSERT INTO `ices_cms_models` VALUES (4, 'guestbook', '留言模型', '留言', '', 1, 1, 0, NULL, '2019-03-13 17:57:23', '2019-03-21 23:36:28');
INSERT INTO `ices_cms_models` VALUES (5, 'single', '单页模型', '单页', '', 1, 1, 0, NULL, '2019-03-13 17:57:50', '2019-03-21 19:31:06');
INSERT INTO `ices_cms_models` VALUES (6, 'images', '图集模型', '图集', '', 1, 1, 0, NULL, '2019-03-13 17:58:03', '2019-03-21 19:31:09');
COMMIT;

-- ----------------------------
-- Table structure for ices_cms_models_field
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_models_field`;
CREATE TABLE `ices_cms_models_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelid` int(11) DEFAULT NULL COMMENT '上级modelid',
  `title` varchar(100) DEFAULT NULL COMMENT '字段标题',
  `name` varchar(20) DEFAULT NULL COMMENT '字段名称(英文)',
  `type` varchar(20) DEFAULT NULL COMMENT '字段类型',
  `dvalue` longtext COMMENT '默认值',
  `values` longtext COMMENT '可选择值',
  `unit` varchar(20) DEFAULT NULL COMMENT '数值单位',
  `list_order` int(11) DEFAULT NULL COMMENT '排序',
  `can_see` longtext COMMENT '可使用栏目',
  `is_must` int(1) NOT NULL DEFAULT '0' COMMENT '是否必填: 0=否,1=是',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='模型对应字段';

-- ----------------------------
-- Records of ices_cms_models_field
-- ----------------------------
BEGIN;
INSERT INTO `ices_cms_models_field` VALUES (1, 1, '文章内容', 'content', 'wangeditor', '', '', '', 1, '1,2,3,4', 0, '2019-03-19 19:06:31', '2019-03-21 17:10:01');
INSERT INTO `ices_cms_models_field` VALUES (2, 5, '单页内容', 'content', 'wangeditor', '', '', '', 1, '1,2,3,4', 0, '2019-03-21 17:09:52', '2019-03-21 17:09:52');
INSERT INTO `ices_cms_models_field` VALUES (3, 6, '图集列表', 'content', 'uploadmulti', '', '', '', 0, '1,2,3,4,5,6', 0, '2019-03-21 17:33:27', '2019-03-21 17:49:52');
INSERT INTO `ices_cms_models_field` VALUES (4, 2, '下载文件', 'content', 'uploadmulti', '', '', '', 0, '1,2,3,4,5,6', 0, '2019-03-21 19:51:38', '2019-03-21 20:46:36');
INSERT INTO `ices_cms_models_field` VALUES (5, 3, '产品内容', 'content', 'wangeditor', '', '', '', 0, '1,2,3,4,5,6', 0, '2019-03-21 22:24:01', '2019-03-21 22:24:01');
COMMIT;

-- ----------------------------
-- Table structure for ices_cms_product
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_product`;
CREATE TABLE `ices_cms_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `columnid` int(11) DEFAULT NULL COMMENT '当前栏目ID',
  `modelid` int(11) DEFAULT NULL COMMENT '模型ID',
  `is_b` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否加粗: 0=不加粗, 1=加粗',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `coverpic` longtext COMMENT '封面图片',
  `is_head` tinyint(1) NOT NULL DEFAULT '0' COMMENT '头条（0=否，1=是）',
  `is_special` tinyint(1) NOT NULL DEFAULT '0' COMMENT '特荐（0=否，1=是）',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶（0=否，1=是）',
  `is_recom` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐（0=否，1=是）',
  `content` longtext COMMENT '内容，可以为文本或图片',
  `attrs` longtext COMMENT '参数设置，json字段',
  `author` varchar(200) DEFAULT NULL COMMENT '作者',
  `visit_num` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `seo_title` varchar(200) CHARACTER SET utf8 DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(200) CHARACTER SET utf8 DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` text CHARACTER SET utf8 COMMENT 'SEO描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态(0=屏蔽，1=正常)',
  `list_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序号',
  `op_id` int(11) DEFAULT NULL COMMENT '操作编号',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `columnid` (`columnid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Cms产品类型表';

-- ----------------------------
-- Table structure for ices_cms_product_attr
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_product_attr`;
CREATE TABLE `ices_cms_product_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `columnid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `values` longtext,
  `is_must` int(1) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `columnid` (`columnid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='产品属性表';

-- ----------------------------
-- Table structure for ices_cms_templates
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_templates`;
CREATE TABLE `ices_cms_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '模板名称',
  `status` int(1) NOT NULL DEFAULT '0',
  `path` longtext,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ices_cms_templates
-- ----------------------------
BEGIN;
INSERT INTO `ices_cms_templates` VALUES (1, 'default', 1, 'THINKER_CMS_ROOT/templates/default/', '2019-03-22 00:19:04', '2019-03-22 15:28:43');
COMMIT;

-- ----------------------------
-- Table structure for ices_cms_templates_vars
-- ----------------------------
DROP TABLE IF EXISTS `ices_cms_templates_vars`;
CREATE TABLE `ices_cms_templates_vars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `templateid` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` longtext,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ices_cms_templates_vars
-- ----------------------------
BEGIN;
INSERT INTO `ices_cms_templates_vars` VALUES (1, 1, '前台是否可登录', 'login_show', '', '2019-03-22 15:21:58', '2019-03-22 15:21:58');
INSERT INTO `ices_cms_templates_vars` VALUES (2, 1, '网站名称', 'web_title', 'ThinkerAdminCms', '2019-03-22 17:53:09', '2019-03-22 17:53:09');
INSERT INTO `ices_cms_templates_vars` VALUES (5, 1, '首页滚动图', 'banner', '{\"text\":\"ThinkerAdmin<br/>CMS文章发布\",\"btns\":[{\"href\":\"#\",\"text\":\"填写资料\"}],\"img\":\"/templates/default/images/about/1.png\"}\n{\"text\":\"ThinkerAdmin<br/>后台管理系统\",\"btns\":[{\"href\":\"#\",\"text\":\"前往留言\"}],\"img\":\"/templates/default/images/about/2.png\"}', '2019-03-22 18:34:54', '2019-03-22 18:41:40');
INSERT INTO `ices_cms_templates_vars` VALUES (6, 1, '卡片展示', 'cards', '{\"img\":\"/templates/default/images/icons/1.png\",\"title\":\"共计项目\",\"text\":\"平台14个,小程序8个\"}\n{\"img\":\"/templates/default/images/icons/2.png\",\"title\":\"共计项目\",\"text\":\"平台14个,小程序8个\"}\n{\"img\":\"/templates/default/images/icons/3.png\",\"title\":\"共计项目\",\"text\":\"平台14个,小程序8个\"}\n{\"img\":\"/templates/default/images/icons/4.png\",\"title\":\"共计项目\",\"text\":\"平台14个,小程序8个\"}\n{\"img\":\"/templates/default/images/icons/5.png\",\"title\":\"共计项目\",\"text\":\"平台14个,小程序8个\"}', '2019-03-22 18:48:15', '2019-03-22 18:58:40');
INSERT INTO `ices_cms_templates_vars` VALUES (7, 1, '第三段展示文字', 'thrid_text', '项目优势', '2019-03-24 19:55:04', '2019-03-24 19:55:04');
INSERT INTO `ices_cms_templates_vars` VALUES (8, 1, '第三段卡片', 'third_cards', '{\"img\":\"/templates/default/images/icons/6.png\",\"text\":\"平台14个,小程序8个\",\"time\":\"1.0\"}\n{\"img\":\"/templates/default/images/icons/7.png\",\"text\":\"平台14个,小程序8个\",\"time\":\"1.3\"}\n{\"img\":\"/templates/default/images/icons/8.png\",\"text\":\"平台14个,小程序8个\",\"time\":\"1.6\"}\n{\"img\":\"/templates/default/images/icons/9.png\",\"text\":\"平台14个,小程序8个\",\"time\":\"1.9\"}\n{\"img\":\"/templates/default/images/icons/10.png\",\"text\":\"平台14个,小程序8个\",\"time\":\"2.1\"}\n{\"img\":\"/templates/default/images/icons/11.png\",\"text\":\"平台14个,小程序8个\",\"time\":\"2.4\"}', '2019-03-24 19:56:11', '2019-03-24 20:00:12');
INSERT INTO `ices_cms_templates_vars` VALUES (9, 1, '第四段文字', 'fourth_text', '公司发展历程<br/>\n(项目时间)', '2019-03-24 20:05:56', '2019-03-24 20:06:58');
INSERT INTO `ices_cms_templates_vars` VALUES (10, 1, '第四段卡片', 'fourth_cards', '{\"text\":\"2017年\",\"cards\":[{\"img\":\"/templates/default/images/video/3.png\",\"text\":\"<h3>项目</h3><p>平台14个,小程序8个</p>\",\"time\":\"1.0\"},{\"img\":\"/templates/default/images/video/4.png\",\"text\":\"<h3>项目</h3><p>平台14个,小程序8个</p>\",\"time\":\"1.3\"}]}\n{\"text\":\"2017年\",\"cards\":[{\"img\":\"/templates/default/images/video/3.png\",\"text\":\"<h3>项目</h3><p>平台14个,小程序8个</p>\",\"time\":\"1.0\"},{\"img\":\"/templates/default/images/video/4.png\",\"text\":\"<h3>项目</h3><p>平台14个,小程序8个</p>\",\"time\":\"1.3\"}]}\n{\"text\":\"2017年\",\"cards\":[{\"img\":\"/templates/default/images/video/3.png\",\"text\":\"<h3>项目</h3><p>平台14个,小程序8个</p>\",\"time\":\"1.0\"},{\"img\":\"/templates/default/images/video/4.png\",\"text\":\"<h3>项目</h3><p>平台14个,小程序8个</p>\",\"time\":\"1.3\"}]}', '2019-03-24 20:07:47', '2019-03-24 20:25:49');
INSERT INTO `ices_cms_templates_vars` VALUES (11, 1, '常见问题', 'questions', '{\"title\":\"这个问题\",\"text\":\"这个问题的答案是XXXXX\"}', '2019-03-24 20:48:23', '2019-03-24 20:48:23');
COMMIT;

-- ----------------------------
-- Records of ices_admin_rule
-- ----------------------------
INSERT INTO `ices_admin_rule` VALUES (16, 'thinkercms', 'Cms管理', 1, '', 0, 1, '2019-03-12 17:21:21', '2019-03-13 16:51:47');
INSERT INTO `ices_admin_rule` VALUES (17, '/thinkercms/models', '模型管理', 1, '', 16, 1, '2019-03-13 16:51:29', '2019-03-13 16:51:29');
INSERT INTO `ices_admin_rule` VALUES (18, '/restful/cmsmodels', '模型管理Restful', 1, '', 17, 1, '2019-03-13 16:51:29', '2019-03-13 18:17:31');
INSERT INTO `ices_admin_rule` VALUES (19, '/thinkercms/modelsEdit', '模型管理Edit界面', 1, '', 17, 1, '2019-03-13 16:51:29', '2019-03-13 16:51:29');
INSERT INTO `ices_admin_rule` VALUES (20, '/thinkercms/columns', '栏目管理', 1, '', 16, 1, '2019-03-13 18:33:17', '2019-03-13 18:33:17');
INSERT INTO `ices_admin_rule` VALUES (21, '/restful/cmscolumns', '栏目管理Restful', 1, '', 20, 1, '2019-03-13 18:33:17', '2019-03-13 18:33:17');
INSERT INTO `ices_admin_rule` VALUES (22, '/thinkercms/columnsEdit', '栏目管理Edit界面', 1, '', 20, 1, '2019-03-13 18:33:17', '2019-03-13 18:33:17');
INSERT INTO `ices_admin_rule` VALUES (23, '/thinkercms/cms', 'Cms内容管理', 1, '', 16, 1, '2019-03-19 11:33:24', '2019-03-19 11:33:24');
INSERT INTO `ices_admin_rule` VALUES (24, '/restful/cms', 'Cms内容Restful', 1, '', 23, 1, '2019-03-19 11:49:11', '2019-03-19 11:49:11');
INSERT INTO `ices_admin_rule` VALUES (25, '/thinkercms/cmsEdit', 'Cms编辑Edit', 1, '', 23, 1, '2019-03-19 12:11:50', '2019-03-19 12:11:50');
INSERT INTO `ices_admin_rule` VALUES (26, '/thinkercms/modelsField', '模型字段', 1, '', 17, 1, '2019-03-19 12:54:43', '2019-03-19 12:54:43');
INSERT INTO `ices_admin_rule` VALUES (27, '/restful/cmsmodelsfield', '模型字段Restful', 1, '', 16, 1, '2019-03-19 18:09:50', '2019-03-19 18:09:50');
INSERT INTO `ices_admin_rule` VALUES (28, '/thinkercms/modelsFieldEdit', '模型字段Edit', 1, '', 17, 1, '2019-03-19 18:19:31', '2019-03-19 18:19:31');
INSERT INTO `ices_admin_rule` VALUES (29, '/thinkercms/cmsAttr', 'Cms属性管理', 1, '', 23, 1, '2019-03-21 21:00:20', '2019-03-21 21:00:20');
INSERT INTO `ices_admin_rule` VALUES (30, '/thinkercms/cmsAttrEdit', 'Cms属性编辑', 1, '', 23, 1, '2019-03-21 21:40:42', '2019-03-21 21:40:42');
INSERT INTO `ices_admin_rule` VALUES (31, '/restful/cmsguestbook', 'Cms的留言Restful', 1, '', 23, 1, '2019-03-21 21:41:13', '2019-03-21 21:41:13');
INSERT INTO `ices_admin_rule` VALUES (32, '/restful/cmsguestbookattr', 'Cms留言板属性Restful', 1, '', 23, 1, '2019-03-21 21:41:29', '2019-03-21 21:41:29');
INSERT INTO `ices_admin_rule` VALUES (33, '/restful/cmsproduct', 'Cms产品Restful', 1, '', 23, 1, '2019-03-21 21:42:02', '2019-03-21 21:42:02');
INSERT INTO `ices_admin_rule` VALUES (34, '/restful/cmsproductattr', 'Cms产品属性Restful', 1, '', 23, 1, '2019-03-21 21:42:18', '2019-03-21 21:42:18');
INSERT INTO `ices_admin_rule` VALUES (35, '/thinkercms/templates', '模板管理', 1, '', 16, 1, '2019-03-21 23:47:52', '2019-03-21 23:47:52');
INSERT INTO `ices_admin_rule` VALUES (36, '/restful/cmstemplates', '模板管理Restful', 1, '', 35, 1, '2019-03-21 23:47:52', '2019-03-21 23:54:58');
INSERT INTO `ices_admin_rule` VALUES (37, '/thinkercms/templatesEdit', '模板管理Edit界面', 1, '', 35, 1, '2019-03-21 23:47:52', '2019-03-21 23:47:52');
INSERT INTO `ices_admin_rule` VALUES (38, '/thinkercms/templateVars', '模板变量', 1, '', 35, 1, '2019-03-22 15:01:33', '2019-03-22 15:02:52');
INSERT INTO `ices_admin_rule` VALUES (39, '/restful/cmstemplatesvars', '模板变量Restful', 1, '', 38, 1, '2019-03-22 15:01:33', '2019-03-22 15:01:33');
INSERT INTO `ices_admin_rule` VALUES (40, '/thinkercms/templateVarsEdit', '模板变量Edit界面', 1, '', 38, 1, '2019-03-22 15:01:33', '2019-03-22 15:01:33');

-- ----------------------------
-- Records of ices_admin_menu
-- ----------------------------
INSERT INTO `ices_admin_menu` VALUES (7, 0, 'thinkercms', 'Cms管理', 'thinkercms', 'layui-icon-align-center', 0, '2019-03-12 17:21:21', '2019-03-13 16:51:42');
INSERT INTO `ices_admin_menu` VALUES (8, 7, 'thinkercms-models', '模型管理', '/thinkercms/models', NULL, 0, '2019-03-13 16:51:29', '2019-03-13 16:51:29');
INSERT INTO `ices_admin_menu` VALUES (9, 7, 'thinkercms-columns', '栏目管理', '/thinkercms/columns', NULL, 0, '2019-03-13 18:33:17', '2019-03-13 18:33:17');
INSERT INTO `ices_admin_menu` VALUES (10, 7, 'thinkercms-templates', '模板管理', '/thinkercms/templates', NULL, 0, '2019-03-21 23:47:52', '2019-03-21 23:47:52');

SET FOREIGN_KEY_CHECKS = 1;
