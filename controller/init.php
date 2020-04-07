<?php

use model\User;

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

// require_once Pf::lib('QqLogin');
// $qq = new QqLogin($config['qq_login']);

$user_id = $has_login = i($_SESSION['se_user_id']);
if ($has_login) {
    $user = User::getById($user_id);
}

