<?php

use model\Model;

// c is controller
// a is action
$url = $_SERVER['REQUEST_URI'];
$arr = explode('?', $url);
$url = $arr[0];
if (strlen(URL_ROOT) > 0) {
    strpos($url, URL_ROOT) === 0 or die("not under root " . URL_ROOT);
    $url = substr($url, strlen(URL_ROOT));
}
$arr = explode('/', $url);
$controller = isset($arr[1]) && $arr[1] ? $arr[1] : 'index';
$action = isset($arr[2]) ? $arr[2] : '';
$target = isset($arr[3]) ? $arr[3] : '';

$is_ajax = i($_REQUEST['is_ajax']) || (strtolower(i($_SERVER['HTTP_X_REQUESTED_WITH'])) == strtolower('XMLHttpRequest'));
$is_post = strtolower(i($_SERVER['REQUEST_METHOD'])) == 'post';

$page = array(
    'title' => $config['site']['name'],
    'head' => array(), // 在head里面的语句
    'scripts' => array(), // 页面底部的script
    'styles' => array(), // head里面的css
); // 关于这个页面的变量

$ip = $_SERVER['REMOTE_ADDR'];

$dbh=new \Pdo(DB_CONF['dsn'], DB_CONF['username'], DB_CONF['password']);
$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES , false);
Model::$db = $dbh;
Model::$logging = DEBUG;
