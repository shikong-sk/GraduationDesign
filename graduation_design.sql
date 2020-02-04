/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50529
 Source Host           : localhost:3306
 Source Schema         : graduation_design

 Target Server Type    : MySQL
 Target Server Version : 50529
 File Encoding         : 65001

 Date: 27/01/2020 17:31:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT '管理员账号',
  `salt` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '加密盐值',
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码',
  `active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '账号是否激活（false:0/true:1）',
  PRIMARY KEY (`id`) USING BTREE,
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id`) REFERENCES `t_teacher` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10002 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (0000010000, '000000', '879570d718ba0c6750b444b1f61c8e8c78a4c6a5', 1);

-- ----------------------------
-- Table structure for channel_content
-- ----------------------------
DROP TABLE IF EXISTS `channel_content`;
CREATE TABLE `channel_content`  (
  `id` char(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `channel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `read` int(255) DEFAULT 0,
  PRIMARY KEY (`id`, `channel`) USING BTREE,
  INDEX `channel`(`channel`) USING BTREE,
  CONSTRAINT `channel` FOREIGN KEY (`channel`) REFERENCES `channel_list` (`channel`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of channel_content
-- ----------------------------
INSERT INTO `channel_content` VALUES ('1579065432173', 'message', 'test131231233123132131231231', '', 0);
INSERT INTO `channel_content` VALUES ('1579065432173', 'news', '新闻test131231233123132131231231', '', 0);
INSERT INTO `channel_content` VALUES ('1579065432175', 'message', 'test131231233123132131231231', '', 1);
INSERT INTO `channel_content` VALUES ('1579326107009', 'notice', '测试测试', '', 0);
INSERT INTO `channel_content` VALUES ('1579326450011', 'news', 'blablabla', '', 0);
INSERT INTO `channel_content` VALUES ('1579326564279', 'news', '123123123', '', 0);
INSERT INTO `channel_content` VALUES ('1579326720855', 'news', '234', '', 0);
INSERT INTO `channel_content` VALUES ('1579338164331', 'message', '1111111111111', '', 0);
INSERT INTO `channel_content` VALUES ('1579338172322', 'message', '2222222222222222222', '', 1);
INSERT INTO `channel_content` VALUES ('1579338190453', 'message', '33333333333333333', '', 0);
INSERT INTO `channel_content` VALUES ('1579338197141', 'message', '4444444444444444444', '', 0);
INSERT INTO `channel_content` VALUES ('1579414470728', 'message', '13213213', '<p>3133232313</p>', 0);
INSERT INTO `channel_content` VALUES ('1579414478967', 'news', '133123213', '<p>123321313123</p>', 1);
INSERT INTO `channel_content` VALUES ('1579414519372', 'message', '123123123', '<p>123123123123</p>', 0);
INSERT INTO `channel_content` VALUES ('1579414525989', 'message', '12312312', '<p>123123123</p>', 0);
INSERT INTO `channel_content` VALUES ('1579414534494', 'message', '1221332321132231213', '<p>123321321321332133231214212132132132133132</p>', 1);
INSERT INTO `channel_content` VALUES ('1579419956225', 'message', '13123', '<p style=\"text-align: center;\">测试</p>', 2);
INSERT INTO `channel_content` VALUES ('1579421274688', 'notice', '132123', '<p>132132</p>', 0);
INSERT INTO `channel_content` VALUES ('1579428603412', 'notice', 'tz', '<p>tz</p>', 0);
INSERT INTO `channel_content` VALUES ('1579428632173', 'notice', 'tztztztztz', '<p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"Storage/notice/Logo.png\" alt=\"\" width=\"176\" height=\"86\" /></p>', 2);
INSERT INTO `channel_content` VALUES ('1579448938513', 'news', '学院四项课题申报获省高校党建研究会2019年党建研究课题立项', '<p class=\"MsoNormal\" style=\"text-indent: 33px; mso-char-indent-count: 1.78; line-height: 150%;\"><span style=\"font-size: 19px; line-height: 150%; font-family: 宋体;\">近日，广东省高等学校党的建设研究会印发<span lang=\"EN-US\">2019</span>年党建课题研究立项通知，我院陈友义教授、黄小铭副教授、徐文副教授、黄彦旎老师申报的党建研究课题成功获得立项。</span></p>\n<p class=\"MsoNormal\" style=\"line-height: 150%;\"><span style=\"font-size: 19px; line-height: 150%; font-family: 宋体;\">据了解，本次共收到课题申报书<span lang=\"EN-US\">635</span>项，其中高职高专院校<span lang=\"EN-US\">139</span>项。经过专家组的严格评审后，评选出立项课题<span lang=\"EN-US\">300</span>项，其中高职高专院校<span lang=\"EN-US\">70</span>项。</span></p>\n<p class=\"MsoNormal\" style=\"line-height: 150%;\"><span style=\"font-size: 19px; line-height: 150%; font-family: 宋体;\">&nbsp; 自<span lang=\"EN-US\">2019</span>年<span lang=\"EN-US\">8</span>月份省高校党建研究会组织开展<span lang=\"EN-US\">2019</span>党建研究课题申报工作以来，学院党委办公室积极组织学院广大教师参与课题的申报立项工作，共收到课题申报书<span lang=\"EN-US\">6</span>份，其中<span lang=\"EN-US\">4</span>份获得立项，申报成功率达<span lang=\"EN-US\">66.7%</span>。</span></p>\n<p class=\"MsoNormal\" style=\"line-height: 150%;\"><span style=\"font-size: 19px; line-height: 150%; font-family: 宋体;\">&nbsp; 接下来，学院将继续加大党建理论研究的支持力度，充分依托和发挥高校人才优势，加大对院级党建课题资金支持力度，组织参加市级、省级党建课题申报，邀请专家莅院开展培训，提高课题申报立项成功率，开展联合党建课题攻关，以党建研究为抓手推进学院基层党建工作创新。</span></p>\n<p class=\"MsoNormal\" style=\"line-height: 150%;\"><span lang=\"EN-US\" style=\"font-size: 19px; line-height: 150%; font-family: 宋体;\">&nbsp;</span></p>\n<p class=\"MsoNormal\" style=\"text-align: right; line-height: 150%;\"><span style=\"font-size: 19px; line-height: 150%; font-family: 宋体;\">（党委宣传部）</span></p>', 34);

-- ----------------------------
-- Table structure for channel_list
-- ----------------------------
DROP TABLE IF EXISTS `channel_list`;
CREATE TABLE `channel_list`  (
  `channel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`channel`) USING BTREE,
  INDEX `channel`(`channel`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of channel_list
-- ----------------------------
INSERT INTO `channel_list` VALUES ('message', '信息公开');
INSERT INTO `channel_list` VALUES ('news', '学院要闻');
INSERT INTO `channel_list` VALUES ('notice', '通知公告');

-- ----------------------------
-- Table structure for global_config
-- ----------------------------
DROP TABLE IF EXISTS `global_config`;
CREATE TABLE `global_config`  (
  `attribute` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of global_config
-- ----------------------------
INSERT INTO `global_config` VALUES ('title', 'XX学院');
INSERT INTO `global_config` VALUES ('h_nav_bgColor', '#007aff');
INSERT INTO `global_config` VALUES ('h_nav_height', '55');
INSERT INTO `global_config` VALUES ('h_nav_logo', '/Template/default/global/logo.png');
INSERT INTO `global_config` VALUES ('h_nav_color', '#FFFFFF');
INSERT INTO `global_config` VALUES ('h_nav_M_bgColor', '#000000');
INSERT INTO `global_config` VALUES ('foot_bgColor', '#007aff');
INSERT INTO `global_config` VALUES ('foot_color', '#fff');
INSERT INTO `global_config` VALUES ('foot_extend', 'false');
INSERT INTO `global_config` VALUES ('foot_extend_contain', '<div class=\"mx-auto text-center\"><a href=\"http://skcks.cn\" style=\"color:yellow;\">时空论坛</a></div>');

-- ----------------------------
-- Table structure for h_nav
-- ----------------------------
DROP TABLE IF EXISTS `h_nav`;
CREATE TABLE `h_nav`  (
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `index` int(255) NOT NULL,
  `target` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of h_nav
-- ----------------------------
INSERT INTO `h_nav` VALUES ('首页', '/index.php', 0, '_self');
INSERT INTO `h_nav` VALUES ('测试', '/Core/Global/frontInit.php', 1, '_blank');

-- ----------------------------
-- Table structure for s_class
-- ----------------------------
DROP TABLE IF EXISTS `s_class`;
CREATE TABLE `s_class`  (
  `class` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `grade` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `major` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`class`, `grade`, `major`, `department`) USING BTREE,
  INDEX `grade`(`grade`) USING BTREE,
  INDEX `major`(`major`) USING BTREE,
  INDEX `department`(`department`) USING BTREE,
  INDEX `class`(`class`) USING BTREE,
  CONSTRAINT `s_class_ibfk_1` FOREIGN KEY (`grade`) REFERENCES `s_grade` (`grade`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `s_class_ibfk_2` FOREIGN KEY (`major`) REFERENCES `s_major` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `s_class_ibfk_3` FOREIGN KEY (`department`) REFERENCES `s_department` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_class
-- ----------------------------
INSERT INTO `s_class` VALUES ('1', '17', '02', '05');
INSERT INTO `s_class` VALUES ('2', '17', '05', '05');

-- ----------------------------
-- Table structure for s_department
-- ----------------------------
DROP TABLE IF EXISTS `s_department`;
CREATE TABLE `s_department`  (
  `id` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `departmentName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_department
-- ----------------------------
INSERT INTO `s_department` VALUES ('05', '计算机系', 1);

-- ----------------------------
-- Table structure for s_grade
-- ----------------------------
DROP TABLE IF EXISTS `s_grade`;
CREATE TABLE `s_grade`  (
  `grade` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `major` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`grade`, `major`, `department`) USING BTREE,
  INDEX `major`(`major`) USING BTREE,
  INDEX `department`(`department`) USING BTREE,
  INDEX `grade`(`grade`) USING BTREE,
  CONSTRAINT `s_grade_ibfk_1` FOREIGN KEY (`major`) REFERENCES `s_major` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `s_grade_ibfk_2` FOREIGN KEY (`department`) REFERENCES `s_department` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_grade
-- ----------------------------
INSERT INTO `s_grade` VALUES ('17', '02', '05');
INSERT INTO `s_grade` VALUES ('17', '05', '05');

-- ----------------------------
-- Table structure for s_major
-- ----------------------------
DROP TABLE IF EXISTS `s_major`;
CREATE TABLE `s_major`  (
  `id` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `department` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`, `department`) USING BTREE,
  INDEX `department`(`department`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  CONSTRAINT `department` FOREIGN KEY (`department`) REFERENCES `s_department` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_major
-- ----------------------------
INSERT INTO `s_major` VALUES ('02', '计算机应用技术', '05', 1);
INSERT INTO `s_major` VALUES ('03', '计算机软件技术', '05', 1);
INSERT INTO `s_major` VALUES ('04', '数字媒体技术', '05', 1);
INSERT INTO `s_major` VALUES ('05', '计算机网络技术', '05', 1);
INSERT INTO `s_major` VALUES ('06', '移动互联', '05', 1);
INSERT INTO `s_major` VALUES ('07', '云计算', '05', 1);

-- ----------------------------
-- Table structure for s_student
-- ----------------------------
DROP TABLE IF EXISTS `s_student`;
CREATE TABLE `s_student`  (
  `id` int(10) NOT NULL COMMENT '学号',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '姓名',
  `sex` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '性别',
  `both` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '出生日期',
  `salt` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '加密盐值',
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '联系电话/手机',
  `grade` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '入学年份',
  `years` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '3' COMMENT '学制',
  `department` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '学系',
  `major` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '专业',
  `class` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '班号',
  `seat` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '座号',
  `active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '账号是否激活（false:0/true:1）',
  `idCard` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '身份证号',
  PRIMARY KEY (`id`, `grade`, `years`, `department`, `major`, `class`, `seat`) USING BTREE,
  INDEX `class`(`class`) USING BTREE,
  INDEX `学系`(`department`) USING BTREE,
  INDEX `专业`(`major`) USING BTREE,
  INDEX `grade`(`grade`) USING BTREE,
  CONSTRAINT `s_student_ibfk_1` FOREIGN KEY (`department`) REFERENCES `s_department` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `s_student_ibfk_2` FOREIGN KEY (`major`) REFERENCES `s_major` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `s_student_ibfk_3` FOREIGN KEY (`grade`) REFERENCES `s_grade` (`grade`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `s_student_ibfk_4` FOREIGN KEY (`class`) REFERENCES `s_class` (`class`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of s_student
-- ----------------------------
INSERT INTO `s_student` VALUES (1730502101, '郑X锋', '男', '1999/01/21', NULL, NULL, '15900000836', '17', '3', '05', '02', '1', '01', 0, '440000199901217232');
INSERT INTO `s_student` VALUES (1730502102, '林X浩', '男', '1998/03/09', NULL, NULL, '13400000092', '17', '3', '05', '02', '1', '02', 0, '440000199803093578');
INSERT INTO `s_student` VALUES (1730502103, '黄X越', '男', '1998/02/19', NULL, NULL, '15700000679', '17', '3', '05', '02', '1', '03', 0, '440000199802190311');
INSERT INTO `s_student` VALUES (1730502104, '李X锋', '男', '1999/08/18', NULL, NULL, '13700000838', '17', '3', '05', '02', '1', '04', 0, '440000199908184154');
INSERT INTO `s_student` VALUES (1730502105, '方X龙', '男', '1998/10/08', NULL, NULL, '15200000656', '17', '3', '05', '02', '1', '05', 0, '440000199810083210');
INSERT INTO `s_student` VALUES (1730502106, '黄X键', '男', '1998/03/10', NULL, NULL, '15600000220', '17', '3', '05', '02', '1', '06', 0, '440000199803103938');
INSERT INTO `s_student` VALUES (1730502107, '范X勋', '男', '1998/10/02', NULL, NULL, '13600000326', '17', '3', '05', '02', '1', '07', 0, '440000199810020215');
INSERT INTO `s_student` VALUES (1730502108, '廖X航', '男', '1999/05/31', NULL, NULL, '18400000495', '17', '3', '05', '02', '1', '08', 0, '440000199905310016');
INSERT INTO `s_student` VALUES (1730502109, '刘X洲', '男', '1997/09/01', NULL, NULL, '13900000054', '17', '3', '05', '02', '1', '09', 0, '440000199709018814');
INSERT INTO `s_student` VALUES (1730502110, '刘X辉', '男', '1998/06/24', NULL, NULL, '15800000049', '17', '3', '05', '02', '1', '10', 0, '440000199806246357');
INSERT INTO `s_student` VALUES (1730502111, '莫X俊', '男', '1998/07/07', NULL, NULL, '13800000999', '17', '3', '05', '02', '1', '11', 0, '440000199807074031');
INSERT INTO `s_student` VALUES (1730502112, '邓X成', '男', '1999/03/09', NULL, NULL, '13400000392', '17', '3', '05', '02', '1', '12', 0, '440000199903096310');
INSERT INTO `s_student` VALUES (1730502113, '赖X煜', '男', '1998/08/08', NULL, NULL, '13000000718', '17', '3', '05', '02', '1', '13', 0, '44000019980808749X');
INSERT INTO `s_student` VALUES (1730502114, '李X燕', '女', '1998/02/10', NULL, NULL, '18300000323', '17', '3', '05', '02', '1', '14', 0, '440000199802103524');
INSERT INTO `s_student` VALUES (1730502115, '安X宏', '男', '1998/09/30', NULL, NULL, '15100000518', '17', '3', '05', '02', '1', '15', 0, '440000199809301116');
INSERT INTO `s_student` VALUES (1730502116, '许X铭', '男', '1998/12/10', NULL, NULL, '13000000369', '17', '3', '05', '02', '1', '16', 0, '440000199812100410');
INSERT INTO `s_student` VALUES (1730502117, '冯X鹏', '男', '1998/03/14', NULL, NULL, '13400000977', '17', '3', '05', '02', '1', '17', 0, '440000199803141850');
INSERT INTO `s_student` VALUES (1730502118, '赵X璇', '女', '1998/09/27', '859205', '776dfda85d4aaf6c88e3c88267b09c3d1bd740ab', '13500000616', '17', '3', '05', '02', '1', '18', 1, '44000019980927364X');
INSERT INTO `s_student` VALUES (1730502119, '郑X凯', '男', '1997/08/14', NULL, NULL, '15000000245', '17', '3', '05', '02', '1', '19', 0, '44000019970814171X');
INSERT INTO `s_student` VALUES (1730502120, '郑X鑫', '男', '1997/04/29', NULL, NULL, '13600000022', '17', '3', '05', '02', '1', '20', 0, '440000199704291550');
INSERT INTO `s_student` VALUES (1730502121, '方X凯', '男', '1998/02/02', NULL, NULL, '13500000527', '17', '3', '05', '02', '1', '21', 0, '440000199802022055');
INSERT INTO `s_student` VALUES (1730502122, '蔡X鑫', '男', '1998/04/04', NULL, NULL, '15000000218', '17', '3', '05', '02', '1', '22', 0, '440000199804046691');
INSERT INTO `s_student` VALUES (1730502123, '翁X鑫', '男', '1999/01/09', NULL, NULL, '13400000904', '17', '3', '05', '02', '1', '23', 0, '440000199901090037');
INSERT INTO `s_student` VALUES (1730502124, '郑X伟', '男', '1999/01/13', NULL, NULL, '15100000644', '17', '3', '05', '02', '1', '24', 0, '440000199901132951');
INSERT INTO `s_student` VALUES (1730502125, '吴X鹏', '男', '1997/12/20', NULL, NULL, '13400000405', '17', '3', '05', '02', '1', '25', 0, '440000199712206336');
INSERT INTO `s_student` VALUES (1730502126, '邱X鑫', '男', '1998/08/28', NULL, NULL, '15900000963', '17', '3', '05', '02', '1', '26', 0, '440000199808280059');
INSERT INTO `s_student` VALUES (1730502127, '郑X彬', '男', '1999/07/10', '486707', '1f1daae11cb6177e8c2041f960707f9012ae980d', '15800000671', '17', '3', '05', '02', '1', '27', 1, '440000199907102912');
INSERT INTO `s_student` VALUES (1730502128, '曹X诚', '男', '1999/06/13', NULL, NULL, '15100000920', '17', '3', '05', '02', '1', '28', 0, '440000199906132519');
INSERT INTO `s_student` VALUES (1730502129, '郑X烜', '男', '1998/10/02', NULL, NULL, '13400000254', '17', '3', '05', '02', '1', '29', 0, '440000199810020439');
INSERT INTO `s_student` VALUES (1730502130, '姚X楠', '男', '1998/02/16', NULL, NULL, '13400000187', '17', '3', '05', '02', '1', '30', 0, '44000019980216001X');
INSERT INTO `s_student` VALUES (1730502131, '蓝X佳', '男', '1998/02/15', NULL, NULL, '15000000320', '17', '3', '05', '02', '1', '31', 0, '440000199802153215');
INSERT INTO `s_student` VALUES (1730502132, '郑X彬', '男', '1998/08/18', NULL, NULL, '13700000992', '17', '3', '05', '02', '1', '32', 0, '440000199808182076');
INSERT INTO `s_student` VALUES (1730502133, '涂X娜', '女', '1996/10/24', NULL, NULL, '13700000359', '17', '3', '05', '02', '1', '33', 0, '44000019961024592X');
INSERT INTO `s_student` VALUES (1730502134, '曾X莎', '女', '1997/05/27', NULL, NULL, '15000000939', '17', '3', '05', '02', '1', '34', 0, '440000199705276947');
INSERT INTO `s_student` VALUES (1730502135, '骆X辉', '男', '1996/06/21', NULL, NULL, '17800000262', '17', '3', '05', '02', '1', '35', 0, '440000199606214690');
INSERT INTO `s_student` VALUES (1730502136, '陈X山', '男', '1998/09/07', NULL, NULL, '18900000265', '17', '3', '05', '02', '1', '36', 0, '440000199809071014');
INSERT INTO `s_student` VALUES (1730502137, '邓X锋', '男', '1997/02/21', NULL, NULL, '15000000235', '17', '3', '05', '02', '1', '37', 0, '440000199702211415');
INSERT INTO `s_student` VALUES (1730502138, '朱X顺', '男', '1998/01/15', NULL, NULL, '17800000461', '17', '3', '05', '02', '1', '38', 0, '440000199801152011');
INSERT INTO `s_student` VALUES (1730502139, '盘X威', '男', '1998/05/02', NULL, NULL, '13700000093', '17', '3', '05', '02', '1', '39', 0, '440000199805022712');
INSERT INTO `s_student` VALUES (1730502140, '杨X豪', '男', '1998/07/01', NULL, NULL, '13600000699', '17', '3', '05', '02', '1', '40', 0, '440000199807013013');
INSERT INTO `s_student` VALUES (1730502141, '赵X元', '男', '1998/09/28', NULL, NULL, '13200000441', '17', '3', '05', '02', '1', '41', 0, '44000019980928367X');
INSERT INTO `s_student` VALUES (1730505201, '杨X兰', '女', '1997/10/06', NULL, NULL, '15000000566', '17', '3', '05', '05', '2', '01', 0, '440000199710061583');
INSERT INTO `s_student` VALUES (1730505202, '陈X欣', '男', '1997/04/30', NULL, NULL, '13400000316', '17', '3', '05', '05', '2', '02', 0, '440000199704300410');
INSERT INTO `s_student` VALUES (1730505203, '刘X楷', '男', '1998/04/04', NULL, NULL, '13400000202', '17', '3', '05', '05', '2', '03', 0, '440000199804042396');
INSERT INTO `s_student` VALUES (1730505204, '黄X飞', '男', '1998/07/09', NULL, NULL, '13500000653', '17', '3', '05', '05', '2', '04', 0, '440000199807093915');
INSERT INTO `s_student` VALUES (1730505205, '韦X戈', '女', '2000/01/16', NULL, NULL, '18300000704', '17', '3', '05', '05', '2', '05', 0, '440000200001162924');
INSERT INTO `s_student` VALUES (1730505206, '黄X杰', '男', '1999/02/06', NULL, NULL, '13400000309', '17', '3', '05', '05', '2', '06', 0, '440000199902066032');
INSERT INTO `s_student` VALUES (1730505207, '施X杰', '男', '1999/02/17', NULL, NULL, '13400000291', '17', '3', '05', '05', '2', '07', 0, '440000199902174579');
INSERT INTO `s_student` VALUES (1730505208, '陈X果', '男', '1999/12/28', NULL, NULL, '13500000714', '17', '3', '05', '05', '2', '08', 0, '440000199912288233');
INSERT INTO `s_student` VALUES (1730505209, '袁X榕', '女', '1998/08/30', NULL, NULL, '13500000275', '17', '3', '05', '05', '2', '09', 0, '44000019980830146X');
INSERT INTO `s_student` VALUES (1730505210, '林X宏', '男', '1999/09/22', NULL, NULL, '13700000997', '17', '3', '05', '05', '2', '10', 0, '440000199909220656');
INSERT INTO `s_student` VALUES (1730505211, '李X明', '男', '1998/07/21', NULL, NULL, '15800000250', '17', '3', '05', '05', '2', '11', 0, '440000199807213119');
INSERT INTO `s_student` VALUES (1730505212, '陈X炎', '男', '1998/08/15', NULL, NULL, '15800000732', '17', '3', '05', '05', '2', '12', 0, '440000199808152792');
INSERT INTO `s_student` VALUES (1730505213, '曾X启', '男', '1998/01/26', NULL, NULL, '13400000642', '17', '3', '05', '05', '2', '13', 0, '440000199801266512');
INSERT INTO `s_student` VALUES (1730505214, '林X喜', '男', '1998/02/14', NULL, NULL, '15200000793', '17', '3', '05', '05', '2', '14', 0, '440000199802146539');
INSERT INTO `s_student` VALUES (1730505215, '杨X仰', '男', '1998/08/07', NULL, NULL, '18300000211', '17', '3', '05', '05', '2', '15', 0, '440000199808074919');
INSERT INTO `s_student` VALUES (1730505216, '吴X斌', '男', '1998/11/02', NULL, NULL, '18000000718', '17', '3', '05', '05', '2', '16', 0, '440000199811022619');
INSERT INTO `s_student` VALUES (1730505217, '黄X茵', '女', '1999/01/08', NULL, NULL, '13100000868', '17', '3', '05', '05', '2', '17', 0, '440000199901081126');
INSERT INTO `s_student` VALUES (1730505218, '林X廷', '男', '1998/12/02', NULL, NULL, '15800000757', '17', '3', '05', '05', '2', '18', 0, '440000199812026914');
INSERT INTO `s_student` VALUES (1730505219, '陈X伟', '男', '1998/11/01', NULL, NULL, '13500000907', '17', '3', '05', '05', '2', '19', 0, '440000199811012617');
INSERT INTO `s_student` VALUES (1730505220, '何X姬', '女', '1998/02/01', NULL, NULL, '13600000221', '17', '3', '05', '05', '2', '20', 0, '440000199802011125');
INSERT INTO `s_student` VALUES (1730505221, '张X雄', '男', '1997/10/12', NULL, NULL, '15900000790', '17', '3', '05', '05', '2', '21', 0, '440000199710125618');
INSERT INTO `s_student` VALUES (1730505222, '黄X婷', '女', '1997/07/08', NULL, NULL, '15900000631', '17', '3', '05', '05', '2', '22', 0, '440000199707084946');
INSERT INTO `s_student` VALUES (1730505223, '蔡X青', '男', '1998/08/26', NULL, NULL, '13100000714', '17', '3', '05', '05', '2', '23', 0, '440000199808261815');
INSERT INTO `s_student` VALUES (1730505224, '柯X煜', '男', '1998/12/29', NULL, NULL, '13100000174', '17', '3', '05', '05', '2', '24', 0, '440000199812292358');
INSERT INTO `s_student` VALUES (1730505225, '黄X凯', '男', '1998/07/27', NULL, NULL, '15800000280', '17', '3', '05', '05', '2', '25', 0, '44000019980727453X');
INSERT INTO `s_student` VALUES (1730505226, '陈X鑫', '男', '1999/03/08', NULL, NULL, '13100000219', '17', '3', '05', '05', '2', '26', 0, '440000199903081930');
INSERT INTO `s_student` VALUES (1730505227, '林X浜', '男', '1998/05/13', NULL, NULL, '13600000626', '17', '3', '05', '05', '2', '27', 0, '440000199805136939');
INSERT INTO `s_student` VALUES (1730505228, '林X强', '男', '1997/10/24', NULL, NULL, '15000000954', '17', '3', '05', '05', '2', '28', 0, '440000199710242410');
INSERT INTO `s_student` VALUES (1730505229, '江X禄', '男', '1999/01/29', NULL, NULL, '18800000736', '17', '3', '05', '05', '2', '29', 0, '440000199901291638');
INSERT INTO `s_student` VALUES (1730505230, '洪X锋', '男', '1995/10/11', NULL, NULL, '13700000339', '17', '3', '05', '05', '2', '30', 0, '440000199510114855');
INSERT INTO `s_student` VALUES (1730505231, '周X民', '男', '1996/12/18', NULL, NULL, '13600000697', '17', '3', '05', '05', '2', '31', 0, '440000199612182736');
INSERT INTO `s_student` VALUES (1730505232, '梁X荣', '男', '1997/10/03', NULL, NULL, '13600000047', '17', '3', '05', '05', '2', '32', 0, '440000199710031516');
INSERT INTO `s_student` VALUES (1730505233, '林X旭', '男', '1998/12/13', NULL, NULL, '18800000109', '17', '3', '05', '05', '2', '33', 0, '440000199812135936');
INSERT INTO `s_student` VALUES (1730505234, '吴X杰', '男', '1996/09/17', NULL, NULL, '13000000691', '17', '3', '05', '05', '2', '34', 0, '440000199609173532');
INSERT INTO `s_student` VALUES (1730505235, '陈X濠', '男', '1999/05/22', NULL, NULL, '13700000986', '17', '3', '05', '05', '2', '35', 0, '44000019990522001X');
INSERT INTO `s_student` VALUES (1730505236, '翁X辉', '男', '1998/05/27', NULL, NULL, '13900000555', '17', '3', '05', '05', '2', '36', 0, '440000199805274530');
INSERT INTO `s_student` VALUES (1730505237, '李X辉', '男', '1998/09/02', NULL, NULL, '13900000733', '17', '3', '05', '05', '2', '37', 0, '440000199809020079');
INSERT INTO `s_student` VALUES (1730505238, '周X鸣', '男', '1996/10/23', NULL, NULL, '13900000971', '17', '3', '05', '05', '2', '38', 0, '440000199610232639');
INSERT INTO `s_student` VALUES (1730505239, '梁X文', '男', '1996/12/09', NULL, NULL, '15700000280', '17', '3', '05', '05', '2', '39', 0, '440000199612091630');
INSERT INTO `s_student` VALUES (1730505240, '梁X武', '男', '1996/12/09', NULL, NULL, '15700000280', '17', '3', '05', '05', '2', '40', 0, '440000199612091657');
INSERT INTO `s_student` VALUES (1730505241, '莫X妹', '女', '1997/03/03', NULL, NULL, '13400000829', '17', '3', '05', '05', '2', '41', 0, '440000199703034027');
INSERT INTO `s_student` VALUES (1730505242, '巫X奇', '男', '1997/02/04', NULL, NULL, NULL, '17', '3', '05', '05', '2', '42', 0, '440000199702043838');
INSERT INTO `s_student` VALUES (1730505243, '甘X华', '男', '1997/03/28', NULL, NULL, '15600000758', '17', '3', '05', '05', '2', '43', 0, '440000199703281632');
INSERT INTO `s_student` VALUES (1730505244, '董X婷', '女', '1999/08/26', NULL, NULL, '13400000613', '17', '3', '05', '05', '2', '44', 0, '440000199908263141');
INSERT INTO `s_student` VALUES (1730505245, '曾X淋', '男', '1998/04/08', NULL, NULL, '18300000596', '17', '3', '05', '05', '2', '45', 0, '440000199804084830');
INSERT INTO `s_student` VALUES (1730505246, '柯X杉', '男', '1996/08/02', NULL, NULL, '13900000359', '17', '3', '05', '05', '2', '46', 0, '440000199608020018');
INSERT INTO `s_student` VALUES (1730505247, '文X杰', '男', '1998/06/12', NULL, NULL, '13800000842', '17', '3', '05', '05', '2', '47', 0, '440000199806122733');

-- ----------------------------
-- Table structure for t_teacher
-- ----------------------------
DROP TABLE IF EXISTS `t_teacher`;
CREATE TABLE `t_teacher`  (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT '教工号',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '姓名',
  `sex` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '性别',
  `both` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '出生日期',
  `salt` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '加密盐值',
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '联系电话/手机',
  `department` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '学系',
  `active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '账号是否激活（false:0/true:1）',
  `idCard` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '身份证号',
  PRIMARY KEY (`id`, `department`) USING BTREE,
  INDEX `学系`(`department`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  CONSTRAINT `t_teacher_ibfk_1` FOREIGN KEY (`department`) REFERENCES `s_department` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10002 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_teacher
-- ----------------------------
INSERT INTO `t_teacher` VALUES (0000010000, '测试', '男', '1990/10/01', '000000', '879570d718ba0c6750b444b1f61c8e8c78a4c6a5', NULL, '05', 0, '440508199010010000');

-- ----------------------------
-- Table structure for top_swiper
-- ----------------------------
DROP TABLE IF EXISTS `top_swiper`;
CREATE TABLE `top_swiper`  (
  `index` int(255) DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of top_swiper
-- ----------------------------
INSERT INTO `top_swiper` VALUES (1, './Storage/top-swiper/1.jpg', '#');
INSERT INTO `top_swiper` VALUES (2, './Storage/top-swiper/2.jpg', '#');
INSERT INTO `top_swiper` VALUES (3, './Storage/top-swiper/3.jpg', '#');

SET FOREIGN_KEY_CHECKS = 1;
