<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if ($is_post && $has_login) {
    $title = req('title');
    $text = req('text');
    
    if ($title && $text) {
        $topic = $user->startTopic($title, $text);
        var_dump(ORM::get_query_log());exit;
        // redirect('meme/' . $topic->id);
    }
}

$view .= '?master';
