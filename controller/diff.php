<?php

use model\Topic;

$a = $action;
$b = $target;

if ($a && $b) {

    $a = new Topic($a);
    $b = new Topic($b);

} else {
    die("no a b");
}
if (!($a && $b)) {
    die("no a b in db");
}

$view .= '?master';
