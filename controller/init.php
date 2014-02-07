<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    init
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

$page['description'] = 'PHP Tiny Frame 很小很小的 PHP 框架';
$page['keywords'] = array('PHP', '开源', '框架', 'MVC');

if (is_mobile()) {
    $page['styles'][] = 'mobile';
} else {
    $page['styles'][] = 'mouse';
}

require_once Pf::lib('QqLogin');
$qq = new QqLogin($config['qq_login']);

require_once Pf::model('User');
$user_id = $has_login = i($_SESSION['se_user_id']);
if ($has_login) {
    $user = new User($user_id);
}

