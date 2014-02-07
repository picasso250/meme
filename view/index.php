<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jul 17, 2012 9:51:11 AM
 */
?>
<div class="board">我是一个特殊的论坛，在这里您可以修改别人说过的话。</div>
<?php if($has_login): ?><a class="post btn" href="<?= ROOT ?>post">发表新帖</a><?php endif; ?>
<?php include smart_view('topics'); ?>
<?php
$min = $paging->viewMin();
$max = $paging->viewMax();
$cur_page = $paging->curPage();
?>
<?php if ($paging->maxPage() > 1): ?>
<div class="paging">
    <ol>
        <?php if ($paging->reachStart()): ?><li>...</li><?php endif; ?>
        <?php for ($i = $min; $i <= $max; $i++): ?>
        <li class="<?= $i == $cur_page? 'on' : '' ?>">
            <a href="?p=<?= $i ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <?php if ($paging->reachEnd()): ?><li>...</li><?php endif; ?>
    </ol>
    <?php if ($paging->hasNext()): ?><a href="?p=<?= $cur_page+1 ?>" class="next-page btn">下一页</a><?php endif; ?>
</div>
<?php endif; ?>
