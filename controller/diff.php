<?php

use model\Topic;
use model\User;

$a= $action;
$b=    $target ;

if ($a&&$b) {

    $a = new Topic($a);
    $b = new Topic($b);
    
} else {
    die("no a b");
}

$view .= '?master';
