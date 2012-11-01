<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');

if ($has_login && req('logout')) {
    $user->logout();
    redirect();
}

if ($qq->isCallback()) {
    // create_user
    $openid = $qq->getOpenId();
    include_once Pf::model('User');
    include_once Pf::model('OpenAccount');
    define('QQ', 'QQ');
    
    // 如果无此帐号,则说明是第一次登录,则创建用户
    // 否则只需得到用户即可
    $open = OpenAccount::find(QQ, $openid);
    if ($open === false) {
        $open = OpenAccount::create(QQ, $openid);
        $user = User::create();
        $user->attachOpenAccount($open);
        
        // get username
        $qq_info = $qq->getInfo();
        $user->setName($qq_info['name']);
    } else {
        $user = $open->getUser();
    }
    
    
    $user->login();
    redirect();
}
exit;
?>
