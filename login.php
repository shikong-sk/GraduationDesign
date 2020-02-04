<?php

session_start();

if(isset($_SESSION['user']))
{
    header('Location:index.php');
}

include_once './template/default/front/head.html'; // 公用头

include_once './template/default/front/h_nav.html'; // 顶部导航栏

include_once './template/default/front/login.html'; // 登录页

include_once './template/default/front/foot.html'; // 页脚