<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:24:01 PM
 */

require_once Pf::model('Topic');
require_once Pf::lib('Paginate');
$per_page = 50;
$p = req('p')?:1;
$paging = new Paginate($per_page, Topic::count());
$paging->setCurPage($p);
$topics = Topic::read(array(
    'limit' => $per_page,
    'offset' => $paging->offset()));

$view .= '?master';
$page['scripts'][] = 'widget';

?>