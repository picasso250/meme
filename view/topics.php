<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
?>
<ul class="list">
<?php foreach ($topics as $t) {?>
    <li>
        <a href="<?=ROOT . 'meme/' . $t->id?>"><?=h($t->title)?></a>
        <span class="time"><?=$t->time?></span>
        <span class="last editor">最后编辑: <?=h($users[$t->editor]->name)?></span>
    </li>
<?php }?>
</ul>