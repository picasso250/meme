<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="control">
    <?php if ($has_login): ?>
    <a><?= $user->name ?></a>
    <a href="<?= ROOT ?>login?logout=1">退出登录</a>
    <?php else: ?>
    <?php endif; ?>
</div>
<h1><a href="<?= ROOT ?>" title="Meme BBS">Meme BBS</a></h1>
<span>meme 集散地</span>
