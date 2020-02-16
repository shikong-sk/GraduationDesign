<?php

Class sqlHelper
{
    const user = 'root'; // 数据库用户名
    const passwd = '';   // 数据库密码
    const dbip = '127.0.0.1'; // 数据库地址
    const dbport = '3306';   // 数据库端口号
    const dbname = 'graduation_design';  // 数据库名
    const salt = 'shikong';  // 密码加密盐值，安装后不可更改

    const global_config = 'global_config'; // 网站全局配置数据表
    const headerNav = 'h_nav'; // 网站导航栏数据表
    const topSwiper = 'top_swiper'; // 网站首页轮播图
    const channelList = 'channel_list'; // 频道分类列表
    const channelContent = 'channel_content'; // 内容

    const department = 's_department'; // 学系列表
    const major = 's_major'; // 专业列表
    const grade = 's_grade'; // 年级列表
    const _class = 's_class'; // 班级列表
    const student = 's_student'; // 学生信息表

    const teacher = 't_teacher'; // 教工信息表

    const admin = 'admin'; // 管理员信息表

    const course = 'course'; // 课程信息表
    const score = 'score'; // 成绩信息表

    var $database;

    function __construct()
    {
        $this->database = new mysqli();
        $this->database->connect($this::dbip . ':' . $this::dbport, $this::user, $this::passwd);
        if ($this->database->connect_error) {
            die('数据库连接失败,请检查数据库配置文件 ./Core/System/Config/db.config.php 配置是否有误');
        }

        $this->database->query('set names utf8');
        $this->database->query('use ' . $this::dbname);
    }

    function getGlobalConfig()
    {
        $database = $this->database;
        $res = $database->query("SELECT * FROM " . $this::global_config);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_row();
            $json[$data[0]] = $data[1];
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getHeaderNav()
    {
        $database = $this->database;
        $res = $database->query("SELECT `name`,`url`,`target` FROM " . $this::headerNav . ' ORDER BY `index` ASC');
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getTopSwiper()
    {
        $database = $this->database;
        $res = $database->query("SELECT `img`,`url` FROM " . $this::topSwiper . ' ORDER BY `index` ASC');
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getChannelList()
    {
        $database = $this->database;
        $res = $database->query("SELECT `channel`,`name` FROM " . $this::channelList);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getChannelContentTop10($channel)
    {
        $database = $this->database;
        $res = $database->query("SELECT `title`,`id` FROM " . $this::channelContent . " WHERE `channel` = '$channel' ORDER BY `id` DESC limit 0,10");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            $data['date'] = date('Y-m-d', $data['id'] / 1000);
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getDepartmentList()
    {
        $database = $this->database;
        $res = $database->query("SELECT `departmentName`,`id` FROM " . $this::department . " WHERE `active` = 1 ORDER BY `id`");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getMajorList($department)
    {
        $database = $this->database;
        $res = $database->query("SELECT `name`,`id` FROM " . $this::major . " WHERE `active` = 1 AND `department` = '$department' ORDER BY `id`");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getGradeList($department, $major)
    {
        $database = $this->database;
        $res = $database->query("SELECT DISTINCT `grade` as grade FROM " . $this::grade . " WHERE `major` = '$major' AND `department` = '$department' ORDER BY `grade` DESC");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getClassList($department, $major, $grade)
    {
        $database = $this->database;
        $res = $database->query("SELECT DISTINCT `class` FROM " . $this::_class . " WHERE `grade` = '$grade' AND`major` = '$major' AND `department` = '$department' ORDER BY `class` ASC");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function studentReg($name, $idCard, $password, $department, $major, $grade, $class)
    {
        $database = $this->database;
        $salt = ''; // 随机加密密钥
        while (strlen($salt) < 6) {
            $x = mt_rand(0, 9);
            $salt .= $x;
        }
        $password = sha1($password . $salt); // sha1哈希加密

        $database->query("UPDATE " . $this::student . " SET `password` = '$password',`salt` = '$salt', `active` = 1 WHERE `name` = '$name' AND `grade` = '$grade' AND `department` = '$department' AND `major` = '$major' AND `class` = '$class' AND `idCard` = '$idCard' AND `active` = 0;");

        if ($database->affected_rows == 0) {
            return json_encode(Array('error' => '学生信息不正确 或 该学生账号已被激活'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('success' => '账号已成功激活'), JSON_UNESCAPED_UNICODE);
        }
    }

    function studentLogin($id, $password)
    {
        $database = $this->database;
        $res = $database->query('SELECT `salt`,`password`,`name` FROM ' . $this::student . " WHERE id='$id'");
        $res = $res->fetch_assoc();
        if ($res === null) {
            return json_encode(Array('error' => '该账号不存在 或 密码错误'), JSON_UNESCAPED_UNICODE);
        } else {
            if (sha1($password . $res['salt']) === $res['password']) {
                $_SESSION['user'] = $id;
                $_SESSION['name'] = $res['name'];
                $_SESSION['identity'] = 'student';
                return json_encode(Array('success' => '登录成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '该账号不存在 或 密码错误'), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    function teacherLogin($id, $password)
    {
        $database = $this->database;
        $res = $database->query('SELECT `salt`,`password`,`name` FROM ' . $this::teacher . " WHERE id='$id' AND active = 1");
        $res = $res->fetch_assoc();
        if ($res === null) {
            return json_encode(Array('error' => '该账号不存在 或 密码错误'), JSON_UNESCAPED_UNICODE);
        } else {
            if (sha1($password . $res['salt']) === $res['password']) {
                $_SESSION['user'] = $id;
                $_SESSION['name'] = $res['name'];
                $_SESSION['identity'] = 'teacher';
                return json_encode(Array('success' => '登录成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '该账号不存在 或 密码错误'), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    function adminLogin($id, $password)
    {
        $database = $this->database;
        $res = $database->query('SELECT a.salt,a.password,t.name FROM ' . $this::admin . " a," . $this::teacher . " t WHERE a.id='$id' AND a.id=t.id");
        $res = $res->fetch_assoc();
        if ($res === null) {
            return json_encode(Array('error' => '该账号不存在 或 密码错误'), JSON_UNESCAPED_UNICODE);
        } else {
            if (sha1($password . $res['salt']) === $res['password']) {
                $_SESSION['user'] = $id;
                $_SESSION['name'] = $res['name'];
                $_SESSION['identity'] = 'admin';
                return json_encode(Array('success' => '登录成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '该账号不存在 或 密码错误'), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    function settingUpdate($title, $h_nav_bgColor, $h_nav_height, $h_nav_color, $h_nav_M_bgColor)
    {
        $database = $this->database;

        $titleRes = $database->query("UPDATE " . $this::global_config . " SET value = '$title' WHERE attribute = 'title'");

        $h_nav_bgColorRes = $database->query("UPDATE " . $this::global_config . " SET value = '$h_nav_bgColor' WHERE attribute = 'h_nav_bgColor'");

        $h_nav_heightRes = $database->query("UPDATE " . $this::global_config . " SET value = '$h_nav_height' WHERE attribute = 'h_nav_height'");

        $h_nav_colorRes = $database->query("UPDATE " . $this::global_config . " SET value = '$h_nav_color' WHERE attribute = 'h_nav_color'");

        $h_nav_M_bgColorRes = $database->query("UPDATE " . $this::global_config . " SET value = '$h_nav_M_bgColor' WHERE attribute = 'h_nav_M_bgColor'");

        if ($titleRes && $h_nav_bgColorRes && $h_nav_heightRes && $h_nav_colorRes && $h_nav_M_bgColorRes) {
            return json_encode(Array('success' => '网站设置更新成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '网站设置更新失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function channelAddContain($channel, $title, $content)
    {
        $channelFlag = false;
        $content = base64_decode($content);
        $database = $this->database;
        $channelList = json_decode($this->getChannelList(), true);
        foreach ($channelList as $c) {
            if ($c['channel'] == $channel) {
                $channelFlag = !$channelFlag;
            }
        }
        if ($channelFlag) {
            $id = time() . mtime();
            $res = $database->query("INSERT INTO " . $this::channelContent . "(`id`, `channel`, `title`, `content`, `read`) VALUES ('$id', '$channel', '$title', '$content', 0);");
            if ($res) {
                return json_encode(Array('success' => '文章添加成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '文章添加失败'), JSON_UNESCAPED_UNICODE);
            }
        } else {
            return json_encode(Array('error' => '该频道不存在'), JSON_UNESCAPED_UNICODE);
        }

    }

    function getChannelCount($channel)
    {
        $database = $this->database;
        $res = $database->query("SELECT count(*) as num FROM " . $this::channelContent . " WHERE `channel` = '$channel'")->fetch_assoc();
        $resNum = 0;
        $json = Array();
        $json = json_encode($res, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getChannelTitle($channel, $page, $num)
    {
        $database = $this->database;
        $page = ($page - 1) * $num;
        $res = $database->query("SELECT * FROM " . $this::channelContent . " WHERE `channel` = '$channel' ORDER BY `id` DESC LIMIT $page,$num");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            $data['date'] = date('Y-m-d H:i:s', $data['id'] / 1000);
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function deleteChannelContent($id, $title)
    {
        $database = $this->database;

        $delRes = $database->query("DELETE FROM " . $this::channelContent . " WHERE `id`= '$id' AND `title` = '$title'");


        if ($delRes) {
            return json_encode(Array('success' => '文章删除成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '文章删除失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function getChannelData($channel, $id)
    {
        $database = $this->database;
        $res = $database->query("SELECT * FROM " . $this::channelContent . " WHERE `channel` = '$channel' AND `id` = '$id'");

        $json = Array();

        $data = $res->fetch_assoc();

        if ($data === null) {
            $json = json_encode(Array('error' => '该文章不存在'), JSON_UNESCAPED_UNICODE);
            return $json;
        }

        $data['date'] = date('Y-m-d H:i:s', $data['id'] / 1000);
        array_push($json, $data);

        $read = intval($data['read']) + 1;

        $database->query("UPDATE " . $this::channelContent . " SET `read` = '$read' WHERE `id` = '$id' AND `channel` = '$channel'");

        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getGrade()
    {
        $database = $this->database;
        $res = $database->query("SELECT DISTINCT `grade` FROM " . $this::grade . " ORDER BY `grade` DESC");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['grade'] . '级', 'value' => $data['grade']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function DepartmentList($grade)
    {
        $database = $this->database;
        $res = $database->query("SELECT DISTINCT g.department,d.departmentName FROM ".$this::grade." g,".$this::department." d WHERE d.id = g.department AND g.grade = '$grade'");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['departmentName'], 'value' => $data['department']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function Department()
    {
        $database = $this->database;
        $res = $database->query("SELECT id,departmentName FROM ".$this::department);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['departmentName'], 'value' => $data['id']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function MajorList($department,$grade)
    {
        $database = $this->database;
        $res = $database->query("SELECT DISTINCT g.major,m.name FROM ".$this::grade." g,".$this::department." d,".$this::major." m WHERE d.id = g.department AND m.department = g.department AND m.id = g.major AND g.grade = '$grade' AND g.department = '$department'");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['name'], 'value' => $data['major']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function teacherList($department)
    {
        $database = $this->database;
        $res = $database->query("SELECT `id`,`name` FROM ".$this::teacher." WHERE department='$department'");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['name'], 'value' => $data['id']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getMaxClass($grade,$department, $major)
    {
        $database = $this->database;
        $res = $database->query("SELECT IFNULL(MAX((`class`))+1,1) as classes FROM ".$this::_class." WHERE grade = '$grade' AND department = '$department' AND major = '$major'");
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function addClass($grade,$department,$major,$class)
    {

        $database = $this->database;

        $res = $database->query("INSERT INTO ".$this::_class."(`class`, `grade`, `major`, `department`) VALUES ('$class', '$grade', '$major', '$department');");
        if ($res) {
            return json_encode(Array('success' => '班级添加成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '班级添加失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function getDepartment()
    {
        $database = $this->database;
        $res = $database->query("SELECT `id`,`departmentName` FROM " . $this::department . " WHERE `active` = 1 ORDER BY `id` DESC");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['departmentName'], 'value' => $data['id']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getMajor($department = '')
    {
        $database = $this->database;
        $query = "SELECT `id`,`name` FROM " . $this::major . " WHERE `active` = 1";

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (`department` = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR `department`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `department` = '" . $department[0] . "'";
                }
            }
        }

        $query .= " ORDER BY `id` ASC";
        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['name'], 'value' => $data['id']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getStudentListCount($sex = '', $grade = "", $department = "", $major = '')
    {
        $database = $this->database;
        $query = "SELECT count(*) as num FROM " . $this::student . " WHERE 1=1";

        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (`major` = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR `major`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `major` = '" . $major[0] . "'";
                }
            }
        }

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (`department` = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR `department`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `department` = '" . $department[0] . "'";
                }
            }
        }

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (`grade` = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR `grade`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `grade` = '" . $grade[0] . "'";
                }
            }
        }

        if ((strlen($sex) != 0)) {
            $sex = json_decode($sex);
            if (is_array($sex) && count($sex) != 0) {
                if (count($sex) > 1) {
                    $query .= " AND (`sex` = '" . $sex[0] . "'";
                    foreach (array_slice($sex, 1) as $s) {
                        $query .= " OR `sex`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `sex` = '" . $sex[0] . "'";
                }
            }
        }

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getStudentList($page, $num, $sex = '', $grade = '', $department = "", $major = '')
    {
        $query = "SELECT s.id,s.name,s.sex,s.both,s.phone,s.grade,s.years,d.departmentName as department,m.name as major,s.class,s.seat,s.active,s.idCard FROM " . $this::student . " s," . $this::department . " d," . $this::major . " m WHERE s.major = m.id AND s.department = d.id";

        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (s.major = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR s.major ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND s.major = '" . $major[0] . "'";
                }
            }
        }

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (s.department = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR s.department ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND s.department = '" . $department[0] . "'";
                }
            }
        }

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (s.grade = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR s.grade ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND s.grade = '" . $grade[0] . "'";
                }
            }
        }

        if ((strlen($sex) != 0)) {
            $sex = json_decode($sex);
            if (is_array($sex) && count($sex) != 0) {
                if (count($sex) > 1) {
                    $query .= " AND (s.sex = '" . $sex[0] . "'";
                    foreach (array_slice($sex, 1) as $s) {
                        $query .= " OR s.sex ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND s.sex = '" . $sex[0] . "'";
                }
            }
        }

        $database = $this->database;

        $page = ($page - 1) * $num;
        $query .= " ORDER BY s.id ASC LIMIT $page,$num";

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function addStudent($name,$sex,$both,$phone,$grade,$years,$department,$major,$class,$seat,$idCard)
    {
        $database = $this->database;
        $id = $grade.$years.$department.$major.$class.$seat;
        $idRes = $database->query("SELECT `id` FROM ".$this::student." WHERE `id`='$id'")->fetch_assoc();
        if ($idRes == null) {
            $res = $database->query("INSERT INTO " . $this::student. " (`id`,`name`,`sex`,`both`,`phone`,`grade`,`years`,`department`,`major`,`class`,`seat`,`idCard`) VALUES ($id,'$name','$sex','$both','$phone','$grade','$years','$department','$major','$class','$seat','$idCard')");
            if ($res) {
                return json_encode(Array('success' => '学生添加成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '学生添加失败'), JSON_UNESCAPED_UNICODE);
            }
        } else {
            return json_encode(Array('error' => '该学号已被使用'), JSON_UNESCAPED_UNICODE);
        }

    }

    function updateStudent($id,$name,$sex,$both,$phone,$idCard,$active){
        $database = $this->database;
        $res = $database->query("UPDATE " . $this::student . " SET `name` = '$name',`sex` = '$sex',`both` = '$both',`phone` = '$phone',`idCard` = '$idCard',`active` = $active WHERE `id` = '$id'");
//        var_dump("UPDATE " . $this::student . " SET `name` = '$name',`sex` = '$sex',`both` = '$both',`phone` = '$phone',`idCard` = '$idCard',`active` = $active WHERE `id` = '$id'");
        if($res){
            return json_encode(Array('success' => '学生信息更新成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '学生信息更新失败'), JSON_UNESCAPED_UNICODE);
        }
    }

    function delStudent($id){
        $database = $this->database;

        $delRes = $database->query("DELETE FROM " . $this::student . " WHERE `id`= '$id'");

        if ($delRes) {
            return json_encode(Array('success' => '学生删除成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '学生删除失败'), JSON_UNESCAPED_UNICODE);
        }
    }

    function getTeacherListCount()
    {
        $database = $this->database;
        $res = $database->query("SELECT count(*) as num FROM " . $this::teacher);
        $resNum = 0;
        $json = Array();
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getTeacherList($page, $num)
    {
        $database = $this->database;
        $page = ($page - 1) * $num;
        $res = $database->query("SELECT t.id,t.name,t.sex,t.both,t.phone,d.departmentName,t.active,t.idCard FROM " . $this::teacher . " t," . $this::department . " d WHERE t.department = d.id LIMIT $page,$num");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function addTeacher($name,$sex,$both,$phone,$department,$idCard,$password,$active)
    {
        $database = $this->database;
        $idRes = $database->query("SELECT IFNULL(MAX((`id`))+1,1) as id FROM ".$this::teacher)->fetch_assoc();

        $salt = ''; // 随机加密密钥
        while (strlen($salt) < 6) {
            $x = mt_rand(0, 9);
            $salt .= $x;
        }
        $password = sha1($password . $salt); // sha1哈希加密

        $id = $idRes['id'];
        $res = $database->query("INSERT INTO " . $this::teacher. " (`id`,`name`,`sex`,`both`,`phone`,`department`,`idCard`,`salt`,`password`,`active`) VALUES ($id,'$name','$sex','$both','$phone','$department','$idCard','$salt','$password',$active)");
        if ($res) {
            return json_encode(Array('success' => '教师添加成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '教师添加失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function updateTeacher($id,$name,$sex,$both,$phone,$idCard,$active){
        $database = $this->database;
        $res = $database->query("UPDATE " . $this::teacher . " SET `name` = '$name',`sex` = '$sex',`both` = '$both',`phone` = '$phone',`idCard` = '$idCard',`active` = $active WHERE `id` = '$id'");
//        var_dump("UPDATE " . $this::student . " SET `name` = '$name',`sex` = '$sex',`both` = '$both',`phone` = '$phone',`idCard` = '$idCard',`active` = $active WHERE `id` = '$id'");
        if($res){
            return json_encode(Array('success' => '教工信息更新成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '教工信息更新失败'), JSON_UNESCAPED_UNICODE);
        }
    }

    function changeTeacherPassword($id,$password)
    {
        $database = $this->database;
        $res = $database->query("SELECT id FROM " . $this::teacher . " WHERE `id` = '$id'");

        $data = $res->fetch_assoc();

        if ($data === null) {
            return json_encode(Array('error' => '该教师不存在'), JSON_UNESCAPED_UNICODE);

        }

        $salt = ''; // 随机加密密钥
        while (strlen($salt) < 6) {
            $x = mt_rand(0, 9);
            $salt .= $x;
        }
        $password = sha1($password . $salt); // sha1哈希加密

        $res = $database->query("UPDATE " . $this::teacher . " SET `salt` = '$salt',`password` = '$password' WHERE `id` = '$id'");

        if($res){
            return json_encode(Array('success' => '密码更新成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '密码更新失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function upgradeToAdmin($id,$password){
        $database = $this->database;

        $admin_res = $database->query("SELECT id FROM ".$this::admin." WHERE `id` = '$id'") ->fetch_assoc();
        if(!$admin_res['id']){
            $salt = ''; // 随机加密密钥
            while (strlen($salt) < 6) {
                $x = mt_rand(0, 9);
                $salt .= $x;
            }
            $password = sha1($password . $salt); // sha1哈希加密

            $res = $database->query("INSERT INTO " . $this::admin. " (`id`,`salt`,`password`,`active`) VALUES ($id,'$salt','$password',1)");

            if ($res) {
                return json_encode(Array('success' => '设置管理员成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '设置管理员失败'), JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            return json_encode(Array('error' => '该教工已经是后台管理员'), JSON_UNESCAPED_UNICODE);
        }
    }

    function delTeacher($id){
        $database = $this->database;

        $select_admin = $database->query("SELECT * FROM ".$this::admin." WHERE `id` = '$id'") ->fetch_assoc();
        if(!$select_admin['id']) {
            $delRes = $database->query("DELETE FROM " . $this::teacher . " WHERE `id` = '$id'");

            if ($delRes) {
                return json_encode(Array('success' => '教工删除成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '教工删除失败'), JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            return json_encode(Array('error' => '该教工为后台管理员，请先移除其管理员权限后再进行此操作'), JSON_UNESCAPED_UNICODE);
        }
    }

    function getAdminListCount()
    {
        $database = $this->database;
        $res = $database->query("SELECT count(*) as num FROM " . $this::admin);
        $resNum = 0;
        $json = Array();
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getAdminList($page, $num)
    {
        $database = $this->database;
        $page = ($page - 1) * $num;
        $res = $database->query("SELECT a.id,t.name,t.sex,t.both,t.phone,d.departmentName,a.active,t.idCard FROM " . $this::teacher . " t," . $this::department . " d," . $this::admin . " a WHERE a.id = t.id AND t.department = d.id LIMIT $page,$num");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function changeAdminPassword($id,$password)
    {
        $database = $this->database;
        $res = $database->query("SELECT id FROM " . $this::admin . " WHERE `id` = '$id'");

        $data = $res->fetch_assoc();

        if ($data === null) {
            return json_encode(Array('error' => '该管理员不存在'), JSON_UNESCAPED_UNICODE);

        }

        $salt = ''; // 随机加密密钥
        while (strlen($salt) < 6) {
            $x = mt_rand(0, 9);
            $salt .= $x;
        }
        $password = sha1($password . $salt); // sha1哈希加密

        $res = $database->query("UPDATE " . $this::admin . " SET `salt` = '$salt',`password` = '$password' WHERE `id` = '$id'");

        if($res){
            return json_encode(Array('success' => '密码更新成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '密码更新失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function delAdmin($id){
        $database = $this->database;

        $select_admin = $database->query("SELECT count(*) as num FROM ".$this::admin) ->fetch_assoc();
        if($select_admin['num'] != 1) {
            $delRes = $database->query("DELETE FROM " . $this::admin . " WHERE `id` = '$id'");

            if ($delRes) {
                return json_encode(Array('success' => '管理员删除成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '管理员删除失败'), JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            return json_encode(Array('error' => '该管理员为唯一的管理员，不可删除'), JSON_UNESCAPED_UNICODE);
        }
    }

    function getMaxSeat($department, $major, $grade, $class)
    {
        $database = $this->database;
        $res = $database->query("select IFNULL(MAX((`seat`))+1,1) as seat FROM " . $this::student . " WHERE department = '$department' AND major = '$major' AND grade = '$grade' AND class = '$class' ");
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getClassCount($grade = "", $department = "", $major = '')
    {
        $database = $this->database;
        $query = "SELECT count(*) as num FROM " . $this::_class . " WHERE 1=1";

        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (`major` = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR `major`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `major` = '" . $major[0] . "'";
                }
            }
        }

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (`department` = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR `department`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `department` = '" . $department[0] . "'";
                }
            }
        }

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (`grade` = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR `grade`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `grade` = '" . $grade[0] . "'";
                }
            }
        }

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getClass($page, $num, $grade = '', $department = "", $major = '')
    {
        $query = "SELECT DISTINCT c.class,g.grade,m.name as major,d.departmentName as department FROM s_class c,s_grade g,s_major m,s_department d WHERE c.grade = g.grade AND c.major = m.id AND m.department = d.id AND c.department = m.department";


        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (c.major = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR c.major ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND c.major = '" . $major[0] . "'";
                }
            }
        }

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (c.department = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR c.department ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND c.department = '" . $department[0] . "'";
                }
            }
        }

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (c.grade = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR c.grade ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND c.grade = '" . $grade[0] . "'";
                }
            }
        }

        $database = $this->database;

        $page = ($page - 1) * $num;
        $query .= " ORDER BY g.grade DESC LIMIT $page,$num";

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function delClass($grade,$department,$major,$class){
        $database = $this->database;

        $department = $database->query("SELECT id FROM ".$this::department." WHERE departmentName = '$department'") ->fetch_assoc()['id'];
        if(!$department)
        {
            return json_encode(Array('error' => '该学系不存在'), JSON_UNESCAPED_UNICODE);
        }
        $major = $database->query("SELECT id FROM ".$this::major." WHERE `name` = '$major' AND `department` = '$department'") ->fetch_assoc()['id'];
        if(!$major)
        {
            return json_encode(Array('error' => '该专业不存在'), JSON_UNESCAPED_UNICODE);
        }

        $select = $database->query("SELECT count(*) as num FROM ".$this::student." WHERE `grade` = '$grade' AND `department` = '$department' AND `major` = '$major' AND `class` = '$class'") ->fetch_assoc();

        if($select['num'] == '0') {
            $query = "DELETE FROM ".$this::_class." WHERE `grade` = '$grade' AND `department` = '$department' AND `major` = '$major' AND `class` = '$class'";
            $delRes = $database->query($query);
            if ($delRes) {
                return json_encode(Array('success' => '班级删除成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '班级删除失败'), JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            return json_encode(Array('error' => '该班级已有学生，不可删除'), JSON_UNESCAPED_UNICODE);
        }
    }

    function Major($department = '',$page,$num)
    {
        $database = $this->database;
        $query = "SELECT d.departmentName as department,m.name as major FROM ".$this::department." d,".$this::major." m WHERE m.department = d.id";

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (d.id = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR d.id='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND d.id = '" . $department[0] . "'";
                }
            }
        }


        $page = ($page - 1) * $num;
        $query .=" LIMIT $page,$num";


        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function MajorCount($department = "")
    {
        $database = $this->database;
        $query = "SELECT count(*) as num FROM ".$this::department." d,".$this::major." m WHERE m.department = d.id";

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (d.id = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR d.id='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND d.id = '" . $department[0] . "'";
                }
            }
        }

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function addMajor($department,$name)
    {

        $database = $this->database;

        $id = $database->query("select IFNULL(MAX((`id`))+1,1) as id FROM ".$this::major." WHERE department = '$department'")->fetch_assoc()['id'];

        if(intval($id)<10)
        {
            $id = '0'. strval($id);
        }

        $res = $database->query("INSERT INTO ".$this::major."(`id`, `name`, `department`, `active`) VALUES ('$id', '$name', '$department', 1)");
        if ($res) {
            return json_encode(Array('success' => '专业添加成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '专业添加失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function delMajor($department,$major){
        $database = $this->database;

        $department = $database->query("SELECT id FROM ".$this::department." WHERE departmentName = '$department'") ->fetch_assoc()['id'];
        if(!$department)
        {
            return json_encode(Array('error' => '该学系不存在'), JSON_UNESCAPED_UNICODE);
        }

        $major = $database->query("SELECT id FROM ".$this::major." WHERE `name` = '$major' AND `department` = '$department'") ->fetch_assoc()['id'];
        if(!$major)
        {
            return json_encode(Array('error' => '该专业不存在'), JSON_UNESCAPED_UNICODE);
        }

        $select = $database->query("SELECT count(*) as num FROM ".$this::student." WHERE `department` = '$department' AND `major` = '$major'") ->fetch_assoc();

        if($select['num'] == '0') {
            $query = "DELETE FROM ".$this::major." WHERE `department` = '$department' AND `id` = '$major'";

            $delRes = $database->query($query);
            if ($delRes) {
                return json_encode(Array('success' => '专业删除成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '专业删除失败'), JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            return json_encode(Array('error' => '该专业已有学生，不可删除'), JSON_UNESCAPED_UNICODE);
        }
    }

    function DepartmentDetail($page,$num)
    {
        $database = $this->database;
        $query = "SELECT id,departmentName as department FROM ".$this::department;

        $page = ($page - 1) * $num;
        $query .=" LIMIT $page,$num";

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function DepartmentCount()
    {
        $database = $this->database;
        $query = "SELECT count(*) as num FROM ".$this::department;


        $res = $database->query($query);
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function addDepartment($name)
    {

        $database = $this->database;

        $id = $database->query("select IFNULL(MAX((`id`))+1,1) as id FROM ".$this::department)->fetch_assoc()['id'];

        if(intval($id)<10)
        {
            $id = '0'. strval($id);
        }

        $res = $database->query("INSERT INTO ".$this::department."(`id`, `departmentName`, `active`) VALUES ('$id', '$name', 1)");
        if ($res) {
            return json_encode(Array('success' => '院系添加成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '院系添加失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function delDepartment($department){
        $database = $this->database;

        $department = $database->query("SELECT id FROM ".$this::department." WHERE departmentName = '$department'") ->fetch_assoc()['id'];
        if(!$department)
        {
            return json_encode(Array('error' => '该学系不存在'), JSON_UNESCAPED_UNICODE);
        }

        $select = $database->query("SELECT count(*) as num FROM ".$this::student." WHERE `department` = '$department'") ->fetch_assoc();

        if($select['num'] == '0') {
            $query = "DELETE FROM ".$this::department." WHERE `id` = '$department'";

            $delRes = $database->query($query);
            if ($delRes) {
                return json_encode(Array('success' => '院系删除成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '院系删除失败'), JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            return json_encode(Array('error' => '该院系已有学生，不可删除'), JSON_UNESCAPED_UNICODE);
        }
    }

    function getClassGrade()
    {
        $database = $this->database;
        $res = $database->query("SELECT DISTINCT grade FROM ".$this::grade." union select IFNULL(MAX((`grade`))+1,SUBSTR(YEAR(NOW()),3,2)) as grade FROM ".$this::grade." ORDER BY grade DESC");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['grade'] . '级', 'value' => $data['grade']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function addGrade($grade,$department,$major){
        $database = $this->database;
        $res = $database->query("INSERT INTO ".$this::grade."(`grade`, `major`, `department`) VALUES ('$grade', '$major', '$department')");
        if ($res) {
            return json_encode(Array('success' => '专业开设成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '专业开设失败，可能该专业已开设'), JSON_UNESCAPED_UNICODE);
        }
    }

    function addCourse($name,$tid,$class,$grade,$major,$department,$stime,$etime,$period,$public,$num)
    {

        $database = $this->database;

        $id = $database->query("select IFNULL(MAX((`id`))+1,10000) as id FROM ".$this::course)->fetch_assoc()['id'];

        if(intval($id)<10)
        {
            $id = '0'. strval($id);
        }

        $res = $database->query("INSERT INTO ".$this::course."(`id`, `name`, `tid`, `class`, `grade`, `major`, `department`, `stime`, `etime`, `period`, `public`, `num`) VALUES ($id, '$name', $tid, '$class', '$grade', '$major', '$department', '$stime', '$etime', $period, $public, $num);");
        if ($res) {
            return json_encode(Array('success' => '课程添加成功'), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(Array('error' => '课程添加失败'), JSON_UNESCAPED_UNICODE);
        }

    }

    function getCourseCount($grade = "", $department = "", $major = '')
    {
        $database = $this->database;
        $query = "SELECT count(*) as num FROM " . $this::course . " WHERE 1=1";

        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (`major` = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR `major`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `major` = '" . $major[0] . "'";
                }
            }
        }

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (`department` = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR `department`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `department` = '" . $department[0] . "'";
                }
            }
        }

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (`grade` = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR `grade`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `grade` = '" . $grade[0] . "'";
                }
            }
        }

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getCourse($page, $num, $grade = '', $department = "", $major = '')
    {
        $query = "SELECT DISTINCT c.id as id,c.name as course,t.name as teacher,cl.class,g.grade,m.name as major,d.departmentName as department,c.stime,c.etime,c.public,c.period,c.num FROM ".$this::course." c,s_grade g,s_major m,s_department d,t_teacher t,s_class cl
WHERE c.grade = g.grade AND c.major = m.id AND m.department = d.id AND c.department = m.department AND c.tid = t.id AND cl.department = d.id AND cl.major = m.id AND cl.grade = g.grade AND cl.class = c.class";


        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (c.major = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR c.major ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND c.major = '" . $major[0] . "'";
                }
            }
        }

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (c.department = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR c.department ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND c.department = '" . $department[0] . "'";
                }
            }
        }

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (c.grade = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR c.grade ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND c.grade = '" . $grade[0] . "'";
                }
            }
        }

        $database = $this->database;

        $page = ($page - 1) * $num;
        $query .= " ORDER BY g.grade DESC LIMIT $page,$num";

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function delCourse($id){
        $database = $this->database;

        $select = $database->query("SELECT count(*) as num FROM ".$this::score." WHERE `cid` = '$id'") ->fetch_assoc();

        if($select['num'] == '0') {
            $query = "DELETE FROM ".$this::course." WHERE `id` = '$id'";
            $delRes = $database->query($query);
            if ($delRes) {
                return json_encode(Array('success' => '课程删除成功'), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(Array('error' => '课程删除失败'), JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            return json_encode(Array('error' => '该课程已登记成绩，不可删除'), JSON_UNESCAPED_UNICODE);
        }
    }

    function getScoreCount($grade = "", $department = "", $major = '')
    {
        $database = $this->database;
        $query = "SELECT count(*) as num FROM score s,s_student ss,course c,s_major sm,s_department sd,s_class sc WHERE s.sid = ss.id AND s.cid = c.id AND c.major = sm.id AND c.department = sd.id AND sm.department = sd.id AND c.department = sc.department AND c.major = sc.major AND c.class = sc.class AND ss.class = c.class AND ss.class = sc.class AND c.major = sc.major AND c.department = sc.department AND ss.grade = sc.grade";

        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (ss.major = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR ss.major='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND ss.major = '" . $major[0] . "'";
                }
            }
        }

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (ss.department = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR ss.department='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND ss.department = '" . $department[0] . "'";
                }
            }
        }

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (ss.grade = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR ss.grade='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND ss.grade = '" . $grade[0] . "'";
                }
            }
        }

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getScore($page, $num, $grade = '', $department = "", $major = '')
    {
        $query = "SELECT ss.grade,sd.departmentName as department,sm.name as major,c.class,c.name as course,ss.id,ss.name as name,t.name as teacher,s.score,s.makeUp FROM score s,s_student ss,course c,s_major sm,s_department sd,s_class sc,t_teacher t WHERE s.sid = ss.id AND s.cid = c.id AND c.major = sm.id AND c.department = sd.id AND sm.department = sd.id AND c.department = sc.department AND c.major = sc.major AND c.class = sc.class AND ss.class = c.class AND ss.class = sc.class AND c.major = sc.major AND c.department = sc.department AND ss.grade = sc.grade AND c.tid = t.id";

        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (ss.major = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR ss.major ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND ss.major = '" . $major[0] . "'";
                }
            }
        }

        if ((strlen($department) != 0)) {
            $department = json_decode($department);
            if (is_array($department) && count($department) != 0) {
                if (count($department) > 1) {
                    $query .= " AND (ss.department = '" . $department[0] . "'";
                    foreach (array_slice($department, 1) as $s) {
                        $query .= " OR ss.department ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND ss.department = '" . $department[0] . "'";
                }
            }
        }

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (ss.grade = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR ss.grade ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND ss.grade = '" . $grade[0] . "'";
                }
            }
        }

        $database = $this->database;

        $page = ($page - 1) * $num;
        $query .= " ORDER BY ss.grade DESC LIMIT $page,$num";

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }


    function getTeacherClassCount($tid,$grade = "",$major = '')
    {
        $database = $this->database;
        $department = $database->query("SELECT department FROM ".$this::teacher." WHERE id = $tid")->fetch_assoc()['department'];
        $query = "SELECT count(*) as num FROM course c,t_teacher t,s_grade sg,s_department sd,s_major sm,s_class sc WHERE c.tid = t.id AND sd.id = c.department AND sm.department = c.department AND sm.id = c.major AND sg.grade = c.grade AND sg.department = sd.id AND sg.major = sm.id AND sc.department = sd.id AND sc.major = sm.id AND sc.grade = sg.grade AND sc.class = c.class AND t.id = $tid";

        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (`major` = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR `major`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `major` = '" . $major[0] . "'";
                }
            }
        }

        $query .= " AND `department` = '" . $department . "'";

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (`grade` = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR `grade`='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND `grade` = '" . $grade[0] . "'";
                }
            }
        }

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        $json = json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getTeacherClass($page, $num,$tid, $grade = '', $major = '')
    {
        $database = $this->database;
        $department = $database->query("SELECT department FROM ".$this::teacher." WHERE id = $tid")->fetch_assoc()['department'];
        $query = "SELECT c.id,c.name as course,t.name,sg.grade,sd.departmentName as department,sm.name as major,sc.class,
(
	SELECT count(*) 
	FROM ".$this::student." 
	WHERE grade = c.grade AND department = c.department AND major = c.major AND class = c.class
) as num
FROM ".$this::course." c,".$this::teacher." t,".$this::grade." sg,".$this::department." sd,".$this::major." sm,".$this::_class." sc
WHERE c.tid = t.id AND
sd.id = c.department AND
sm.department = c.department AND
sm.id = c.major AND
sg.grade = c.grade AND
sg.department = sd.id AND
sg.major = sm.id AND
sc.department = sd.id AND
sc.major = sm.id AND
sc.grade = sg.grade AND
sc.class = c.class AND
t.id = $tid";


        if ((strlen($major) != 0)) {
            $major = json_decode($major);
            if (is_array($major) && count($major) != 0) {
                if (count($major) > 1) {
                    $query .= " AND (c.major = '" . $major[0] . "'";
                    foreach (array_slice($major, 1) as $s) {
                        $query .= " OR c.major ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND c.major = '" . $major[0] . "'";
                }
            }
        }

        $query .= " AND c.department = '" . $department . "'";

        if ((strlen($grade) != 0)) {
            $grade = json_decode($grade);
            if (is_array($grade) && count($grade) != 0) {
                if (count($grade) > 1) {
                    $query .= " AND (c.grade = '" . $grade[0] . "'";
                    foreach (array_slice($grade, 1) as $s) {
                        $query .= " OR c.grade ='$s'";
                    }
                    $query .= ")";
                } else {
                    $query .= " AND c.grade = '" . $grade[0] . "'";
                }
            }
        }

        $page = ($page - 1) * $num;
        $query .= " ORDER BY c.grade DESC,c.id ASC LIMIT $page,$num";

        $res = $database->query($query);
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, $data);
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getTeacherMajor($tid)
    {
        $database = $this->database;
        $res = $database->query("SELECT DISTINCT c.major,sm.name FROM ".$this::course." c,".$this::teacher." t,".$this::major." sm WHERE t.id = c.tid AND sm.department = c.department AND sm.id = c.major AND t.id = $tid ORDER BY c.major");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['name'], 'value' => $data['major']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }

    function getTeacherGrade($tid)
    {
        $database = $this->database;
        $res = $database->query("SELECT DISTINCT c.grade FROM course c,t_teacher t WHERE t.id = c.tid AND t.id = $tid ORDER BY c.grade DESC");
        $resNum = 0;
        $json = Array();
        while ($res->data_seek($resNum)) {
            $data = $res->fetch_assoc();
            array_push($json, Array('text' => $data['grade'] . '级', 'value' => $data['grade']));
            $resNum++;
        }
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        return $json;
    }
}

?>