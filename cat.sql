/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : cat

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 19/01/2021 07:47:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for deletedfile
-- ----------------------------
DROP TABLE IF EXISTS `deletedfile`;
CREATE TABLE `deletedfile`  (
  `deleted_ID` int(11) NULL DEFAULT NULL COMMENT '删除文件ID',
  `del_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '删除名称',
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '删除文件类型'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '回收站 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for filefortranslation
-- ----------------------------
DROP TABLE IF EXISTS `filefortranslation`;
CREATE TABLE `filefortranslation`  (
  `file_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `file_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件名',
  `file_Format` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件格式',
  `file_Status` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件状态',
  `project_ID` int(11) NULL DEFAULT NULL COMMENT '项目ID',
  PRIMARY KEY (`file_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '翻译文件 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for machinetranslation
-- ----------------------------
DROP TABLE IF EXISTS `machinetranslation`;
CREATE TABLE `machinetranslation`  (
  `mtID` int(11) NOT NULL AUTO_INCREMENT COMMENT '机器翻译ID',
  `mtName` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '机器翻译名',
  `mtAPIkey` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '机器翻译Key',
  `mtAPIkey2` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '机器翻译Key2',
  PRIMARY KEY (`mtID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '机器翻译 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project`  (
  `PM_ID` int(11) NULL DEFAULT NULL COMMENT '项目所属人_ID',
  `project_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '项目ID',
  `project_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '项目名',
  `project_Status` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '项目状态',
  `project_Property` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '项目属性',
  `due_Date` date NULL DEFAULT NULL COMMENT '截止日期',
  `source_Language` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '源语言',
  `target_Language` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '目标语言',
  PRIMARY KEY (`project_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '项目 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for projectmanager
-- ----------------------------
DROP TABLE IF EXISTS `projectmanager`;
CREATE TABLE `projectmanager`  (
  `pm_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '项目经理ID',
  `pm_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '项目经理名',
  `pm_Password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '项目经理密码',
  PRIMARY KEY (`pm_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '项目经理 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for realationsheet3
-- ----------------------------
DROP TABLE IF EXISTS `realationsheet3`;
CREATE TABLE `realationsheet3`  (
  `project_ID` int(11) NULL DEFAULT NULL COMMENT '项目ID',
  `translationbase_ID` int(11) NULL DEFAULT NULL COMMENT '翻译表ID'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '关联表3 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for relationsheet1
-- ----------------------------
DROP TABLE IF EXISTS `relationsheet1`;
CREATE TABLE `relationsheet1`  (
  `project_ID` int(11) NULL DEFAULT NULL COMMENT '项目ID',
  `tmb_ID` int(11) NULL DEFAULT NULL COMMENT '翻译记忆表ID'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '关联表1 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for relationsheet2
-- ----------------------------
DROP TABLE IF EXISTS `relationsheet2`;
CREATE TABLE `relationsheet2`  (
  `project_ID` int(11) NULL DEFAULT NULL COMMENT '项目ID',
  `tb_ID` int(11) NULL DEFAULT NULL COMMENT '术语表ID'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '关联表2 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for team
-- ----------------------------
DROP TABLE IF EXISTS `team`;
CREATE TABLE `team`  (
  `team_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '团队ID',
  `team_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '团队名',
  `pm_ID` int(11) NULL DEFAULT NULL COMMENT '项目经理ID',
  `translator_ID1` int(11) NULL DEFAULT NULL COMMENT '译员ID1',
  `translator_ID2` int(11) NULL DEFAULT NULL COMMENT '译员ID2',
  `translator_ID3` int(11) NULL DEFAULT NULL COMMENT '译员ID3',
  PRIMARY KEY (`team_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '团队 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for termbase
-- ----------------------------
DROP TABLE IF EXISTS `termbase`;
CREATE TABLE `termbase`  (
  `term_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '术语ID',
  `tbsheet_ID` int(11) NULL DEFAULT NULL COMMENT '术语表ID',
  `zh_CN` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '源文本',
  `en_US` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '目标文本',
  `term_Definition` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '术语定义',
  `term_Property` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '术语属性',
  PRIMARY KEY (`term_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '术语库 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for termsheet
-- ----------------------------
DROP TABLE IF EXISTS `termsheet`;
CREATE TABLE `termsheet`  (
  `tbsheet_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '术语表ID',
  `tbsheet_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '术语表名',
  `sourceLanguage` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '源语言',
  `targetLanguage` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '目标语言',
  `tbsheet_Status` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '术语表状态',
  `owner_ID` int(11) NULL DEFAULT NULL COMMENT '所属人ID',
  `owner_Type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属人类型',
  PRIMARY KEY (`tbsheet_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '术语表 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for translationbase
-- ----------------------------
DROP TABLE IF EXISTS `translationbase`;
CREATE TABLE `translationbase`  (
  `translation_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '翻译ID',
  `translationsheet_ID` int(11) NULL DEFAULT NULL COMMENT '翻译表ID',
  `sourceText` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '源文本',
  `targetText` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '目标文本',
  `translation_Property` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '翻译属性',
  PRIMARY KEY (`translation_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 187 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '翻译库 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for translationmemorybase
-- ----------------------------
DROP TABLE IF EXISTS `translationmemorybase`;
CREATE TABLE `translationmemorybase`  (
  `tm_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '翻译记忆ID',
  `tmsheet_ID` int(11) NULL DEFAULT NULL COMMENT '翻译记忆表ID',
  `sourceText` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '源文本',
  `targertText` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '目标文本',
  `tm_Property` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '翻译记忆属性',
  PRIMARY KEY (`tm_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '翻译记忆库 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for translationmemorysheet
-- ----------------------------
DROP TABLE IF EXISTS `translationmemorysheet`;
CREATE TABLE `translationmemorysheet`  (
  `tmsheet_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '翻译记忆表ID',
  `tmsheet_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '翻译记忆表名',
  `sourceLanguage` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '源语言',
  `targetLanguage` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '目标语言',
  `tmsheet_Status` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '翻译记忆表状态',
  `owner_ID` int(11) NULL DEFAULT NULL COMMENT '所属人ID',
  `owner_Type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属人类型',
  PRIMARY KEY (`tmsheet_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '翻译记忆表 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for translationsheet
-- ----------------------------
DROP TABLE IF EXISTS `translationsheet`;
CREATE TABLE `translationsheet`  (
  `translationsheet_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '翻译表ID',
  `file_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件ID',
  `sourceLanguage` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '源语言',
  `targetLanguage` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '目标语言',
  `translationsheet_Status` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '翻译表状态',
  `owner_ID` int(11) NULL DEFAULT NULL COMMENT '所属人ID',
  `owner_Type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属人类型',
  `project_ID` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`translationsheet_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '翻译表 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for translator
-- ----------------------------
DROP TABLE IF EXISTS `translator`;
CREATE TABLE `translator`  (
  `translator_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '译员ID',
  `translator_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '译员名',
  `translator_Password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '译员密码',
  PRIMARY KEY (`translator_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '译员 ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for websearch
-- ----------------------------
DROP TABLE IF EXISTS `websearch`;
CREATE TABLE `websearch`  (
  `websearch_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '网络查询ID',
  `websearch_Name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网络查询名',
  `websearch_Connection` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网络查询链接',
  PRIMARY KEY (`websearch_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '网络查询 ' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
