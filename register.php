<?php

require_once  './Core/System/core.php';

session_start();

if(isset($_SESSION['user']))
{
    header('Location:index.php');
}

include_once './template/default/front/head.html'; // 公用头

include_once './template/default/front/h_nav.html'; // 顶部导航栏

include_once './template/default/front/register.html'; // 注册页

include_once './template/default/front/foot.html'; // 页脚