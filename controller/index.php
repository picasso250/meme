<?php

use model\Topic;
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:24:01 PM
 */

require_once Pf::lib('Paginate');
$per_page = 100;
$id = req('id')?:1;
$n=$per_page+1;
$topics = Topic::fetchAll("SELECT * from topic where id>=? limit $n",[$id]);

$view .= '?master';
$page['scripts'][] = 'widget';

