<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$nodes = $topic->nodes;
$nodes_count = count($nodes);
?>
<?php if (req('fork_success')): ?>
<div class="fork success">fork 成功</div>
<?php endif; ?>
<?php if ($has_login): ?>
<a title="看到好的帖子，fork 一下以表激励" class="fork btn" href="?a=fork">fork</a>
<span class="change btn">修改标题</span>
<? endif; ?>
<h2><?= h($topic->title) ?></h2>
<div class="editor">最后编辑者：<a class="editor"><?= h($topic->editor->name) ?></a></div>
<span class="time"><?= $topic->time ?></span>
<?php foreach ($nodes as $n): ?>
<div class="node" data-id="<?= $n->id ?>">
    <?php if ($has_login): ?>
    <div class="control">
        <span class="edit btn">编辑</span>
        <?php if ($nodes_count > 1): ?><span class="del btn">删除</span><?php endif; ?>
    </div>
    <?php endif; ?>
    <a class="name"><?= h($n->user->name) ?></a>
    <div class="text"><?= h($n->text) ?></div>
</div>
<?php if ($has_login): ?><span data-id="<?= $n->id ?>" class="add btn">添加内容</span><?php endif; ?>
<?php endforeach; ?>