<?php
use lib\QQ_Mail;
use model\User;

if ($has_login && req('logout')) {
    $user->logout();
    redirect();
}
if (req('token')) {
    $token = req('token');
    $email = req('email');
    $users = User::fetchAll(
        "SELECT*from user where `name` = ? and login_token =? and update_time>?",
        [$email, $token, date('Y-m-d H:i:s', strtotime('-1 day'))]);
    if ($users) {
        $id=$users[0]->id;
        User::updateById(['login_token'=>null],$id);
        $_SESSION['se_user_id'] = $id;
        redirect();
        exit;
    } else {
        die("link unvalid or expired");
    }
}
if ($is_post) {
    $token = uniqid();
    $email = req('email');
    $user = User::findOne(['name' => $email]);
    if ($user) {
        User::updateById(['login_token' => $token], $user->id);
    } else {
        $id = User::insert([
            'name' => $email,
            'login_token' => $token,
        ]);
        $user = User::getById($id);
    }
    $m = new QQ_Mail($env['mail']);
    $link = htmlentities(sprintf("%slogin?token=$token&email=$email", SITE_URL));
    $content = sprintf("<a href=\"%s\">请点击登陆meme</a>", $link);
    $rs = $m->send([$email], "登陆meme", $content);
    var_dump($rs);
}
$view .= '?master';
