<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php if (req('fork_success')): ?>
<div class="fork success">fork 成功</div>
<?php endif; ?>

<?php if ($has_login): ?>
<a title="看到好的帖子，fork 一下以表激励" class="fork btn" href="?a=fork">fork</a>
<?php endif; ?>

<h2><?= h($topic->title) ?></h2>
<div class="editor">最后编辑者：<a class="editor"><?= h($editor->name) ?></a></div>
<span class="time"><?= $topic->time ?></span>

<div class="text"><?= h($topic->text) ?></div>
