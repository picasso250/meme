<?php

use model\Topic;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if ($is_post && $has_login) {
    $title = req('title');
    $text = req('text');

    if ($title && $text) {
        // insert
        $id = Topic::insert([
            'editor' => $user->id,
            'title' => $title,
            'text' => $text,
            'origin' => req('from') ?: 0,
        ]);
        Topic::updateById(['hit' => $id], $id);
        redirect('meme/' . $id);
    }
}

if (req('from')) {
    $old = Topic::getById(req('from'));
}
$view .= '?master';
