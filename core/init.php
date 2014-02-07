<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');

// c is controller
// a is action
$url = $_SERVER['REQUEST_URI'];
$arr = explode('?', $url);
$url = $arr[0];
$arr = explode('/', $url);
$controller = isset($arr[1]) ? $arr[1] : 'index';
$action = isset($arr[2]) ? $arr[2] : '';
$target = isset($arr[3]) ? $arr[3] : '';

$is_ajax = i($_REQUEST['is_ajax']) || (strtolower(i($_SERVER['HTTP_X_REQUESTED_WITH'])) == strtolower('XMLHttpRequest'));
$is_post = strtolower(i($_SERVER['REQUEST_METHOD'])) == 'post';

$page = array(
    'title'   => $config['site']['name'],
    'head'    => array(), // 在head里面的语句
    'scripts' => array(), // 页面底部的script
    'styles'  => array(), // head里面的css
); // 关于这个页面的变量

$ip = $_SERVER['REMOTE_ADDR'];

ORM::configure($config['db']['dsn']);
ORM::configure('username', $config['db']['username']);
ORM::configure('password', $config['db']['pwd']);

