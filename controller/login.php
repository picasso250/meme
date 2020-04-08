<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');

if ($has_login && req('logout')) {
    $user->logout();
    redirect();
}
if($is_post){

}
$view .= '?master';
