<?php

use model\Topic;
use model\User;

if (is_numeric($action)) {
    $target = $action;
}
if ($target) {

    $topic = new Topic($target);
    $editor = new User($topic->editor);
    if($topic->origin){
        $origin=new Topic($topic->origin);
    }

    if ($is_ajax) {
        // login todo

        $node_id = req('node');
        $text = req('text');

        // 修改内容
        if ($is_post && ($action == 'edit' || $action == 'after') && $node_id && $text) {
            $user->editTopic($topic, $node_id, $text, $action);
            $new_topic = $user->forkTopic($topic);
            echo json_encode(ROOT . 'meme/' . $new_topic->id);
            exit;
        }

        // 删除节点
        if ($action == 'delete' && $node_id) {
            $topic->delNode($node_id);
            $new_topic = $user->forkTopic($topic);
            echo json_encode(ROOT . 'meme/' . $new_topic->id);
            exit;
        }
    }

    // 修改标题
    if ($is_post && ($title = req('title'))) {
        $topic->setTitle($title);
        $new_topic = $user->forkTopic($topic);
        redirect('meme/' . $new_topic->id);
    }

    // fork
    if ($action == 'fork') {
        $new_topic = $user->forkTopic($topic);
        redirect('meme/' . $new_topic->id . '?fork_success=1');
    }

} else {
    exit;
}

$view .= '?master';
