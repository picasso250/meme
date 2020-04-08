<?php

use model\Topic;
use model\User;

if (is_numeric($action)) {
    $target = $action;
}
if ($target) {

    $topic = new Topic($target);
    $editor = new User($topic->editor);
    if ($topic->origin) {
        $origin = new Topic($topic->origin);
    }
    $text = $topic->text;
    if ($topic->merge) {
        $merge = new Topic($topic->merge);
        $text = $merge->text;
    }
    $forks = Topic::find(['origin' => $topic->id]);
    if ($forks) {
        $users = User::findByIds(array_column($forks, 'editor'));
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

function edit_distance($a, $b)
{
    if (mb_strlen($a) == 0) {
        return mb_strlen($b);
    }

    if (mb_strlen($b) == 0) {
        return mb_strlen($a);
    }

    $m = mb_strlen($a) + 1;
    $n = mb_strlen($b) + 1;

    $matrix = array_fill(0, $m, array_fill(0, $n, 0));
    $matrix[0][0] = 0;
    for ($i = 1; $i < $m; $i++) {
        $matrix[$i][0] = $matrix[$i - 1][0] + 1;
    }
    for ($j = 1; $j < $m; $j++) {
        $matrix[0][$j] = $matrix[0][$j - 1] + 1;
    }
    $cost = 0;

    for ($i = 1; $i < $m; $i++) {
        for ($j = 1; $j < $n; $j++) {
            if (mb_substr($a, $i - 1, 1) == mb_substr($b, $j - 1, 1)) {
                $cost = 0;
            } else {
                $cost = 1;
            }

            $matrix[$i][$j] = min($matrix[$i - 1][$j] + 1, $matrix[$i][$j - 1] + 1, $matrix[$i - 1][$j - 1] + $cost);
        }
    }

    return $matrix[$m - 1][$n - 1];
}
