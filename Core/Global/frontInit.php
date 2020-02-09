<?php
include_once '../System/core.php';
include_once '../System/Config/db.config.php';

header('Content-Type:application/json; charset=utf-8');

$db = new sqlHelper();

if (isset($_POST['baseConfig'])) {
    exit($db->getGlobalConfig());
}

if (isset($_POST['h_nav'])) {
    exit($db->getHeaderNav());
}

if (isset($_POST['top_swiper'])) {
    exit($db->getTopSwiper());
}

if (isset($_POST['channelTop10'])) {
    exit($db->getChannelContentTop10($_POST['channelTop10']));
}

if (isset($_POST['departmentList'])) {
    exit($db->getDepartmentList());
}

if (isset($_POST['majorList'])) {
    exit($db->getMajorList($_POST['majorList']));
}

if (isset($_POST['gradeList']) && isset($_POST['department']) && isset($_POST['major'])) {
    exit($db->getGradeList($_POST['department'],$_POST['major']));
}

if (isset($_POST['classList']) && isset($_POST['department']) && isset($_POST['major']) && isset($_POST['grade'])) {
    exit($db->getClassList($_POST['department'],$_POST['major'],$_POST['grade']));
}

if(isset($_POST['studentReg']) && isset($_POST['name']) && isset($_POST['idCard']) && isset($_POST['password']) && isset($_POST['department']) && isset($_POST['major']) && isset($_POST['grade']) && isset($_POST['Class']) && isset($_POST['authCode']))
{

    if($_SESSION['authCode'] === strtoupper($_POST['authCode'])){
        exit($db->studentReg($_POST['name'],$_POST['idCard'],$_POST['password'],$_POST['department'],$_POST['major'],$_POST['grade'],$_POST['Class']));
    }
    else{
        exit(json_encode(Array('error'=>'验证码错误'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['studentLogin']) && isset($_POST['user']) && isset($_POST['password'])){
    exit($db->studentLogin($_POST['user'],$_POST['password']));
}

if(isset($_POST['teacherLogin']) && isset($_POST['user']) && isset($_POST['password'])){
//    var_dump($_POST['user'],$_POST['password']);
    exit($db->teacherLogin($_POST['user'],$_POST['password']));
//    var_dump($db->teacherLogin($_POST['user'],$_POST['password']));
}

if(isset($_POST['adminLogin']) && isset($_POST['user']) && isset($_POST['password'])){
//    var_dump($_POST['user'],$_POST['password']);
    exit($db->adminLogin($_POST['user'],$_POST['password']));
//    var_dump($db->teacherLogin($_POST['user'],$_POST['password']));
}

if(isset($_REQUEST['logout']))
{
    session_unset();
    session_destroy();
    header('Location:../../index.php');
}

if(isset($_POST['settingUpdate']) && isset($_POST['title']) && isset($_POST['h_nav_bgColor']) && isset($_POST['h_nav_height']) && isset($_POST['h_nav_color']) && isset($_POST['h_nav_M_bgColor']))
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->settingUpdate($_POST['title'], $_POST['h_nav_bgColor'], $_POST['h_nav_height'], $_POST['h_nav_color'], $_POST['h_nav_M_bgColor']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['getChannel']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->getChannelList());
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['channelAddContain']) && isset($_POST['channel']) && isset($_POST['title']) && isset($_POST['contain']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->channelAddContain($_POST['channel'],$_POST['title'],$_POST['contain']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['getChannelCount']))
{
//    if($_SESSION['identity'] === 'admin'){
        exit($db->getChannelCount($_POST['getChannelCount']));
//    }
//    else{
//        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
//    }
}


if(isset($_POST['getChannelTitle']) && isset($_POST['page']) && isset($_POST['num']))
{
    exit($db->getChannelTitle($_POST['getChannelTitle'],$_POST['page'],$_POST['num']));
}

if(isset($_POST['deleteChannelContent']) && isset($_POST['id']) && isset($_POST['title']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->deleteChannelContent($_POST['id'],$_POST['title']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['getChannelData']) && isset($_POST['id']) && isset($_POST['channel']))
{

    exit($db->getChannelData($_POST['channel'],$_POST['id']));

}

if(isset($_POST['getGrade']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->getGrade());
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['getDepartment']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->getDepartment());
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['getMajor']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->getMajor($_POST['department']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getStudentListCount']))
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->getStudentListCount($_POST['sex'],$_POST['grade'],$_POST['department'],$_POST['major']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getStudentList'])  && isset($_POST['page']) && isset($_POST['num']))
{

//

    if($_SESSION['identity'] === 'admin'){
        exit($db->getStudentList($_POST['page'],$_POST['num'],$_POST['sex'],$_POST['grade'],$_POST['department'],$_POST['major']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getMaxSeat'])  && isset($_POST['department']) && isset($_POST['major']) && isset($_POST['grade']) && isset($_POST['class']))
{

//

    if($_SESSION['identity'] === 'admin'){
        exit($db->getMaxSeat($_POST['department'],$_POST['major'],$_POST['grade'],$_POST['class']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['addStudent']) && isset($_POST['name']) && isset($_POST['sex']) && isset($_POST['both']) && isset($_POST['phone']) && isset($_POST['grade']) && isset($_POST['years']) && isset($_POST['department']) && isset($_POST['major']) && isset($_POST['class']) && isset($_POST['seat']) && isset($_POST['idCard']) )
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->addStudent($_POST['name'],$_POST['sex'],$_POST['both'],$_POST['phone'],$_POST['grade'],$_POST['years'],$_POST['department'],$_POST['major'],$_POST['class'],$_POST['seat'],$_POST['idCard']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['updateStudent']) && isset($_POST['name']) && isset($_POST['sex']) && isset($_POST['both']) && isset($_POST['phone']) && isset($_POST['idCard']) && isset($_POST['active']) )
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->updateStudent($_POST['updateStudent'],$_POST['name'],$_POST['sex'],$_POST['both'],$_POST['phone'],$_POST['idCard'],$_POST['active']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['delStudent']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->delStudent($_POST['delStudent']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getTeacherListCount']))
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->getTeacherListCount());
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getTeacherList'])  && isset($_POST['page']) && isset($_POST['num']))
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->getTeacherList($_POST['page'],$_POST['num']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['addTeacher']) && isset($_POST['name']) && isset($_POST['sex']) && isset($_POST['both']) && isset($_POST['phone']) && isset($_POST['department']) && isset($_POST['idCard']) && isset($_POST['password']) && isset($_POST['active']))
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->addTeacher($_POST['name'],$_POST['sex'],$_POST['both'],$_POST['phone'],$_POST['department'],$_POST['idCard'],$_POST['password'],$_POST['active']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['updateTeacher']) && isset($_POST['name']) && isset($_POST['sex']) && isset($_POST['both']) && isset($_POST['phone']) && isset($_POST['idCard']) && isset($_POST['active']) )
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->updateTeacher($_POST['updateTeacher'],$_POST['name'],$_POST['sex'],$_POST['both'],$_POST['phone'],$_POST['idCard'],$_POST['active']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['delTeacher']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->delTeacher($_POST['delTeacher']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['changeTeacherPassword']) && isset($_POST['password']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->changeTeacherPassword($_POST['changeTeacherPassword'],$_POST['password']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['upgradeToAdmin']) && isset($_POST['password']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->upgradeToAdmin($_POST['upgradeToAdmin'],$_POST['password']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getAdminListCount']))
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->getAdminListCount());
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getAdminList'])  && isset($_POST['page']) && isset($_POST['num']))
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->getAdminList($_POST['page'],$_POST['num']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['changeAdminPassword']) && isset($_POST['password']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->changeAdminPassword($_POST['changeAdminPassword'],$_POST['password']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['delAdmin']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->delAdmin($_POST['delAdmin']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getClassCount']))
{

    if($_SESSION['identity'] === 'admin'){
        exit($db->getClassCount($_POST['grade'],$_POST['department'],$_POST['major']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if (isset($_POST['getClass'])  && isset($_POST['page']) && isset($_POST['num']))
{

//

    if($_SESSION['identity'] === 'admin'){
        exit($db->getClass($_POST['page'],$_POST['num'],$_POST['grade'],$_POST['department'],$_POST['major']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['delClass']) && isset($_POST['grade']) && isset($_POST['department']) && isset($_POST['major']) && isset($_POST['class']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->delClass($_POST['grade'],$_POST['department'],$_POST['major'],$_POST['class']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['DepartmentList']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->DepartmentList($_POST['DepartmentList']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['MajorList']) && isset($_POST['grade']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->MajorList($_POST['MajorList'],$_POST['grade']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['getMaxClass']) && isset($_POST['grade']) && isset($_POST['department']) && isset($_POST['major']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->getMaxClass($_POST['grade'],$_POST['department'],$_POST['major']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}

if(isset($_POST['addClass']) && isset($_POST['grade']) && isset($_POST['department']) && isset($_POST['major']) && isset($_POST['class']))
{
    if($_SESSION['identity'] === 'admin'){
        exit($db->addClass($_POST['grade'],$_POST['department'],$_POST['major'],$_POST['class']));
    }
    else{
        exit(json_encode(Array('error'=>'您无权执行此操作'), JSON_UNESCAPED_UNICODE));
    }
}
header('Content-Type:text/html;charset=utf-8');
die('<h1>ForBidden</h1>');