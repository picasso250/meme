<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php if (req('fork_success')): ?>
<div class="fork success">fork 成功</div>
<?php endif;?>

<?php if ($has_login): ?>
<a title="看到好的帖子，fork 一下以表激励" class="fork btn" href="../post?from=<?=$topic->merge ?: $topic->id?>">fork</a>
<?php endif;?>

<h2><?=h($topic->title)?></h2>
<?php if ($topic->origin): ?>
<div>
fork自 <a href="<?=$topic->origin?>"><?=$origin->title?></a>
<a href="../diff/<?=$topic->origin?>/<?=$topic->id?>">diff</a>
</div>

<?php endif;?>
<div class="editor">最后编辑者：<a class="editor"><?=h($editor->name)?></a></div>
<span class="time"><?=$topic->time?></span>

<div class="text"><?=formatSimpleMarkdown($text)?></div>

<?php if ($topic->merge): ?>
<div class="">merge自<a href="<?=$topic->merge?>"><?=h($merge->title)?></a></div>
<a href="javascript:void(0);" onclick="$('#old').toggle()">展开/收起 原内容</a>
<div class="text" id="old" style="display:none"><?=formatSimpleMarkdown($topic->text)?></div>
<?php endif;?>

<?php if ($forks): ?>
<div class="">以下人员fork</div>
<ul>
<?php foreach ($forks as $fork): ?>
<li>
    <a href=""><?=h($users[$fork->editor]->name)?></a>
    fork
    <a href="<?=$fork->id?>"><?=h($fork->title)?></a>
    (<?=edit_distance($topic->text,$fork->text)?>)
    <a href="../diff/<?=$topic->id?>/<?=$fork->id?>">diff</a>
</li>
<?php endforeach;?>
<?php endif;?>
