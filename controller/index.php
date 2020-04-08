<?php

use model\Topic;
use model\User;
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:24:01 PM
 */

$per_page = 100;
$id = req('id') ?: 1;
$n = $per_page + 1;
$topics = Topic::fetchAll("SELECT * from topic where id>=? and `merge`=0 order by hit DESC limit $n", [$id]);
$uids = array_map(function ($e) {
    return $e->editor;
}, $topics);
if ($uids) {
    $users = User::findByIds($uids);
}

$view .= '?master';
$page['scripts'][] = 'widget';
