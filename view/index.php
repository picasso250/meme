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

<?php if (count($topics)>$per_page): ?>
<a class="btn btn-default" href="?id=">下一页</a>
<?php endif; ?>
