<?php
header('Content-type:text/html;charset=utf-8');

//开启调试模式
define("APP_DEBUG",true);
//后台模块
define("APP_PATH",'./Admin/');
//前台模块
define('APP_PATH','./Home/');

//加载框架
require "../ThinkPHP/Think.php";

