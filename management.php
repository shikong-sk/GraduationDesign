<?php

session_start();

if(!isset($_SESSION['user']))
{
    header('Location:login.php');
}
else if(isset($_SESSION['user']) && $_SESSION['identity'] === 'admin')
{
    include_once './template/default/front/head.html'; // 公用头

    include_once './template/default/front/h_nav.html'; // 顶部导航栏

    include_once './template/default/front/management.html'; // 学生页

    include_once './template/default/front/foot.html'; // 页脚
}
else{
    die('<h1>ForBidden</h1>');
}