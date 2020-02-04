<?php

include_once './Core/System/core.php';
session_start();

var_dump(time().mtime());

$salt = '';

while(strlen($salt)<6)
{
    $x = mt_rand(0,9);
    $salt.=$x;
    echo $x;
}
echo '<br>';

$password = '123456';

echo sha1($password.$salt);

echo '<br>';

$_SESSION['user'] = 'admin';
$_SESSION['name'] = 'admin';
$_SESSION['identity'] = 'admin';

var_dump($_SESSION);

