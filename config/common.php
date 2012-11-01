<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    common
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 */

if (isset($_SERVER['HTTP_APPNAME'])) { // on server
    define('ON_SERVER', TRUE);
    
    define('DEBUG', TRUE);
    
    define('ROOT', '/');
    
    define('UP_DOMAIN', 'xxxx');
} else {
    define('ON_SERVER', FALSE);
    
    define('DEBUG', TRUE);
    
    define('ROOT', '/meme/');
    
    define('JS_VER',  time());
    define('CSS_VER', time());
}

$config['site']['name'] = 'meme BBS';

$config['db'] = array(
    'dsn' => 'mysql:host=localhost;dbname=bbs',
    'username' => 'root',
    'pwd' => 'xiaosan'
);

$config['qq_login'] = array(
    'app_id'=>'100311379',
    'app_key'=>'c1710d23e0230c9354a74658b6c7fd48',
    'scope'=>implode(',', array('get_user_info')),
    'callback'=> 'http://meme8.sinaapp.com/' . (ON_SERVER ? '' : 'meme/') . 'login',
);

if (ON_SERVER) {
    // 会覆盖之前的配置
    $config['db'] = array(
        'dsn' => 'mysql:'.implode(';', array('host='.SAE_MYSQL_HOST_M, 'port='.SAE_MYSQL_PORT, 'dbname='.SAE_MYSQL_DB)),
        'dsn_s' => 'mysql:'.implode(';', array('host='.SAE_MYSQL_HOST_S, 'port='.SAE_MYSQL_PORT, 'dbname='.SAE_MYSQL_DB)),
        'username' => SAE_MYSQL_USER,
        'pwd' => SAE_MYSQL_PASS
    );
    include 'server.php';
}

?>
