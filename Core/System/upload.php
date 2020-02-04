<?php
/***************************************************
 * 数据来源白名单 *
 ***************************************************/

//$accepted_origins = array("http://localhost", "http://127.0.0.1", "http://example.com");

session_start();

/*********************************************
 * 设置图片保存的文件夹 *
 *********************************************/


if(isset($_POST['channel']))
{
    $imageFolder = "../../Storage/";
    switch ($_POST['channel']){
        case 'test': $imageFolder.='test/';break;
        case 'message':$imageFolder.='message/';break;
        case 'news':$imageFolder.='news/';break;
        case 'notice':$imageFolder.='notice/';break;

        default : header("HTTP/1.1 403 Forbidden");exit;
    }
    reset ($_FILES);
    $temp = current($_FILES);
    if (!is_uploaded_file($temp['tmp_name'])){
        // 通知编辑器上传失败
        header("HTTP/1.1 500 Server Error");
        exit;
    }
}
else if (isset($_GET['uploadLogo']) && isset($_SESSION['identity']) && $_SESSION['identity'] === 'admin')
{
    $imageFolder = "../../template/default/global/";
    reset ($_FILES);
    $temp = current($_FILES);

    if (!is_uploaded_file($temp['tmp_name'])){
        // 通知编辑器上传失败
        header("HTTP/1.1 500 Server Error");
        exit;
    }

    $temp['name'] = 'Logo.png';
}
else{
    header("HTTP/1.1 403 Forbidden");
    exit;
}


if(!file_exists($imageFolder))
{
    mkdir($imageFolder);
}

//if (isset($_SERVER['HTTP_ORIGIN'])) {
//    // 验证来源是否在白名单内
//    if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
//        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
//    } else {
//        header("HTTP/1.1 403 Origin Denied");
//        exit;
//    }
//}

/*
  如果脚本需要接收cookie，在init中加入参数 images_upload_credentials : true
  并加入下面两个被注释掉的header内容
*/
// header('Access-Control-Allow-Credentials: true');
// header('P3P: CP="There is no P3P policy."');


// 简单的过滤一下文件名是否合格
if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/u", $temp['name'])) {
    header("HTTP/1.1 400 文件名中包含非法字符");
    exit;
}

// 验证扩展名
if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
    header("HTTP/1.1 400 Invalid extension.");
    exit;
}


// 都没问题，就将上传数据移动到目标文件夹，此处直接使用原文件名，建议重命名
$filetowrite = $imageFolder . $temp['name'];

move_uploaded_file($temp['tmp_name'], iconv('utf-8','gbk',$filetowrite)); // 防止中文乱码

// 返回JSON格式的数据
// 形如下一行所示，使用location存放图片URL
// { location : '/your/uploaded/image/file.jpg'}
echo json_encode(array('location' => $filetowrite));

