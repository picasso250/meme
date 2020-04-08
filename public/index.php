<?php
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 * app logic
 */

use model\Model;

define('IN_PTF', 1);

chdir(dirname(__DIR__));
spl_autoload_register();

require 'vendor/autoload.php';
require 'config/common.php';
require 'lib/function.php';

// 变量初始化
require 'core/init.php';

ob_start();
session_start();
date_default_timezone_set('PRC');

// $_SESSION['se_user_id'] = 1; // for test
require Pf::controller('init');

if (isset($force_redirect)) { // 强制跳转 这个在整站关闭的时候很有用
    $controller = $force_redirect;
}
$view = $controller;

if (!file_exists(Pf::controller($controller))) {
    $controller = 'default'; // page 404
}

if (file_exists(_css($controller))) {
    $page['styles'][] = $controller;
}

if (file_exists(_js($controller))) {
    $page['scripts'][] = $controller;
}

include Pf::controller($controller); // 执行 controller

$arr = explode('?', $view);
if (count($arr) == 2 && $arr[1] == 'master') {
    $content = $arr[0];
    $view = 'master';
}
include smart_view($view); // 渲染 view

if (DEBUG) {
    echo "<pre>";

    if (isset($_GET['test_user_login'])) {
        $_SESSION['se_user_id'] = $_GET['test_user_login']; // for test
        echo "您已经登录.\n";
    }

    var_dump($_SESSION);
    var_dump($_REQUEST);
    print_r(Model::getLog());
}
