<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form role="form" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">标题</label>
    <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="标题" value="<?= isset($old)?htmlentities($old->title):''?>">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">内容</label>
    <textarea name="text" class="form-control" id="exampleInputPassword1"><?= isset($old)?h($old->text):''?></textarea>
  </div>
  <button type="submit" class="btn btn-default">发表</button>
</form>
